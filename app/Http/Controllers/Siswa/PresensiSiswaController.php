<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;

class PresensiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;

        $siswa = auth()->user()->siswaProfile;

        $presensi = Presensi::with('siswa')
            ->where('siswa_id', $siswa->id)
            ->when($request->search, fn($q) => $q->where('tanggal','like','%'.$request->search.'%'))
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('siswa.presensi.index', compact('presensi'));
    }

    public function create()
    {
        $siswa = auth()->user()->siswaProfile;

        return view('siswa.presensi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $siswa = auth()->user()->siswaProfile;

        $request->validate([
            'tanggal' => 'required|date',
            'tab' => 'required|in:masuk,pulang',
            'jam_masuk' => 'required_if:tab,masuk',
            'jam_keluar' => 'required_if:tab,pulang',
            'status' => 'required_if:tab,masuk|in:hadir,absen,sakit',
            'foto_masuk' => 'nullable|image|max:2048',
            'foto_pulang' => 'nullable|image|max:2048',
        ]);

        $data = ['siswa_id' => $siswa->id, 'tanggal' => $request->tanggal];

        if($request->tab == 'masuk') {
            $data['jam_masuk'] = $request->jam_masuk;
            $data['status'] = $request->status;

            if($request->hasFile('foto_masuk')){
                $file = $request->file('foto_masuk');
                $filename = time().'_masuk_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $data['foto_masuk'] = $filename;
            }

            // Cek apakah hari ini sudah ada presensi, update jam_masuk jika belum ada
            Presensi::updateOrCreate(
                ['siswa_id' => $siswa->id, 'tanggal' => $request->tanggal],
                $data
            );

        } elseif($request->tab == 'pulang') {
            $presensi = Presensi::firstOrCreate(
                ['siswa_id' => $siswa->id, 'tanggal' => $request->tanggal]
            );

            $presensi->jam_keluar = $request->jam_keluar;

            if($request->hasFile('foto_pulang')){
                $file = $request->file('foto_pulang');
                $filename = time().'_pulang_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_pulang = $filename;
            }

            $presensi->save();
        }

        return redirect()->route('siswa.presensi.index')
            ->with('success', 'Presensi berhasil disimpan.');
    }
}
