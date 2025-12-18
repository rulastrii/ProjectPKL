<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;

class PresensiSiswaController extends Controller
{
    public function index(Request $request)
{
    $siswa = auth()->user()->siswaProfile;

    $query = Presensi::where('siswa_id', $siswa->id);

    // Filter search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('siswa', function($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
              ->orWhere('nisn', 'like', "%$search%");
        });
    }

    // Filter tanggal
    if ($request->filled('tanggal')) {
        $query->where('tanggal', $request->tanggal);
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $perPage = $request->input('per_page', 10);
    $presensi = $query->orderBy('tanggal', 'desc')->paginate($perPage);

    // Tetap bawa query string agar pagination mempertahankan filter
    $presensi->appends($request->all());

    return view('siswa.presensi.index', compact('presensi'));
}


    public function create()
    {
        $siswa = auth()->user()->siswaProfile;

        // Ambil presensi hari ini
        $todayPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        // Helper untuk view agar lebih ringkas dan aman null
        $jamMasuk = $todayPresensi->jam_masuk ?? null;
        $jamPulang = $todayPresensi->jam_keluar ?? null;

        $absenMasukSudah = !is_null($jamMasuk);
        $absenPulangSudah = !is_null($jamPulang);

        return view('siswa.presensi.index', compact(
            'siswa', 'todayPresensi', 'jamMasuk', 'jamPulang', 'absenMasukSudah', 'absenPulangSudah'
        ));
    }

    public function store(Request $request)
    {
        $siswa = auth()->user()->siswaProfile;
        $tanggal = date('Y-m-d');

        $request->validate([
            'tab' => 'required|in:masuk,pulang',
            'status' => 'required_if:tab,masuk|in:hadir,absen,sakit',
            'foto_masuk' => 'nullable|image|max:2048',
            'foto_pulang' => 'nullable|image|max:2048',
        ]);

        /** ================= ABSEN MASUK ================= */
        if ($request->tab === 'masuk') {

            $presensi = Presensi::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal' => $tanggal
            ]);

            if ($presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Absensi masuk sudah dilakukan.']);
            }

            $presensi->jam_masuk = Carbon::now('Asia/Jakarta')->format('H:i:s');
            $presensi->status = $request->status;

            if ($request->hasFile('foto_masuk')) {
                $file = $request->file('foto_masuk');
                $filename = time().'_masuk_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_masuk = $filename;
            }

            $presensi->save();
        }

        /** ================= ABSEN PULANG ================= */
        if ($request->tab === 'pulang') {

            $presensi = Presensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->first();

            if (!$presensi || !$presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Anda belum melakukan absensi masuk.']);
            }

            if ($presensi->jam_keluar) {
                return back()->withErrors(['msg' => 'Absensi pulang sudah dilakukan.']);
            }

            $presensi->jam_keluar = Carbon::now('Asia/Jakarta')->format('H:i:s');

            if ($request->hasFile('foto_pulang')) {
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
