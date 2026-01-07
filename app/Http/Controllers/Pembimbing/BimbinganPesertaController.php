<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Pembimbing;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanMagangMahasiswa;

class BimbinganPesertaController extends Controller
{
    public function index(Request $request) {
        $user     = Auth::user();
        $pegawai  = $user->pegawai;
        $search   = $request->search;
        $perPage  = $request->per_page ?? 10;
        $tahun    = $request->tahun;

        // Kalau pegawai tidak ada, buat paginator kosong
        if (!$pegawai) {
            $pembimbing = new LengthAwarePaginator([], 0, $perPage, 1);
            $tahunList  = collect();
            return view('pembimbing.bimbingan-peserta.index', compact('pembimbing','tahunList'))
                ->with('error', 'Pegawai tidak ditemukan untuk user login.');
        }

        // Ambil data bimbingan pegawai login
        $pembimbing = Pembimbing::with(['pegawai'])
    ->whereNull('deleted_date')
    ->where('pegawai_id', $pegawai->id)
    ->when($tahun, fn($q) => $q->where('tahun', $tahun))
    ->when($search, fn($q) => $q->whereHasMorph(
        'pengajuan',
        [PengajuanPklmagang::class, PengajuanMagangMahasiswa::class],
        fn($q) => $q->where('no_surat', 'like', "%{$search}%")
                     ->orWhere('nama_mahasiswa', 'like', "%{$search}%")
    ))
    ->orderBy('tahun', 'desc')
    ->paginate($perPage)
    ->appends($request->query());


        // list tahun untuk filter
        $tahunList = Pembimbing::whereNull('deleted_date')
            ->where('pegawai_id', $pegawai->id)
            ->whereNotNull('tahun')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        return view('pembimbing.bimbingan-peserta.index', compact('pembimbing','tahunList'));
    }

    public function show($id) {
        $pegawai = Auth::user()->pegawai;
        if (!$pegawai) {
            abort(403, 'Pegawai tidak ditemukan untuk user login.');
        }

        $pembimbing = Pembimbing::with(['pengajuan', 'pegawai'])
            ->where('id', $id)
            ->whereNull('deleted_date')
            ->where('pegawai_id', $pegawai->id)
            ->firstOrFail();

        return view('pembimbing.bimbingan-peserta.show', compact('pembimbing'));
    }

}