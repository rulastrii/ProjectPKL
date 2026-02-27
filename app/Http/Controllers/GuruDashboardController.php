<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PengajuanPklSiswa;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();

        // Base query siswa bimbingan guru
        $baseQuery = PengajuanPklSiswa::whereHas('pengajuan', function ($q) use ($guruId) {
            $q->where('created_id', $guruId);
        });

        // Statistik kartu
        $totalSiswa = (clone $baseQuery)->count();
        $pengajuanDisetujui = (clone $baseQuery)->where('status', 'diterima')->count();
        $pengajuanDitolak = (clone $baseQuery)->where('status', 'ditolak')->count();
        $pengajuanDiproses = $totalSiswa - $pengajuanDisetujui - $pengajuanDitolak;

        // Grafik per bulan
        $currentYear = Carbon::now()->year;
        // Ambil semua siswa bimbingan
        $siswaList = (clone $baseQuery)->with('pengajuan')->get();
// Inisialisasi array 12 bulan untuk Diterima / Ditolak
$diterimaData = array_fill(0, 12, 0);
$ditolakData  = array_fill(0, 12, 0);

foreach ($siswaList as $siswa) {
    if ($siswa->pengajuan && $siswa->pengajuan->periode_mulai) {
        $bulan = (int) $siswa->pengajuan->periode_mulai->format('n'); // 1..12
        if ($siswa->status === 'diterima') {
            $diterimaData[$bulan - 1]++;
        } elseif ($siswa->status === 'ditolak') {
            $ditolakData[$bulan - 1]++;
        }
    }
}


        $bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

// Pie chart
$pengajuanDisetujui = $siswaList->where('status','diterima')->count();
$pengajuanDitolak   = $siswaList->where('status','ditolak')->count();
$pengajuanDiproses  = $siswaList->where('status','diproses')->count();

        // Notifikasi
        $pendingSiswa = (clone $baseQuery)->where('status', 'diproses')->count();

        // Ambil semua siswa bimbingan
        $siswaStatus = (clone $baseQuery)
            ->get()
            ->groupBy('status');

        // Daftar status lengkap
        $allStatus = ['draft', 'diproses', 'diterima', 'ditolak', 'selesai'];

        // Hitung per status, pastikan selalu ada key
        $notifData = [];
        foreach ($allStatus as $status) {
            $notifData[$status] = isset($siswaStatus[$status]) ? $siswaStatus[$status]->count() : 0;
        }

        // Siswa PKL akan segera selesai (misal 1 minggu lagi)
        $soonEnding = (clone $baseQuery)
            ->where('status', 'diterima') 
            ->whereHas('pengajuan', function($q){
                $q->whereDate('periode_selesai', '<=', Carbon::now()->addDays(5))
                  ->whereDate('periode_selesai', '>=', Carbon::now());
            })
            ->count();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'pengajuanDisetujui',
            'pengajuanDitolak',
            'pengajuanDiproses',
            'bulanLabels',
            'diterimaData',
            'ditolakData',
            'pendingSiswa',
            'soonEnding',
            'siswaList',
            'siswaStatus',
            'notifData',
            'allStatus'
        ));
    }
}
