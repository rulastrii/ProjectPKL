<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Presensi;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\Tugas;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingDashboardController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai;

        if (!$pegawai) {
            $jumlahSiswa = 0;
            $jumlahLaporanBelumVerifikasi = 0;
            $jumlahPending    = 0;
            $daftarSiswa = collect();
            $presensi = collect();
            $reports = collect(); 

        } else {
            // Ambil semua bimbingan pegawai
            $daftarSiswa = Pembimbing::with('pengajuan')
                ->whereNull('deleted_date')
                ->where('pegawai_id', $pegawai->id)
                ->get();

            $jumlahSiswa = $daftarSiswa->count();

             // Hitung presensi pending untuk pegawai ini
            $jumlahPresensiHadir = Presensi::where('is_active', 1)
        ->where('status', 'hadir')
        ->whereHas('siswa', function($s) use ($pegawai) {
            $s->whereHas('pengajuan', function($p) use ($pegawai) {
                $p->whereHas('pembimbing', function($b) use ($pegawai) {
                    $b->where('pegawai_id', $pegawai->id)
                      ->whereNull('deleted_date');
                });
            });
        })
        ->count();

        // Jumlah tugas baru pembimbing
    $pembimbing = Pembimbing::where('pegawai_id', $pegawai->id)
        ->whereNull('deleted_date')
        ->first();

    if ($pembimbing) {
        $jumlahTugasBaru = Tugas::where('pembimbing_id', $pembimbing->id)
            ->where('is_active', 1)
            ->where('status', 'pending') // tugas baru = pending
            ->count();
    }
    // Jumlah laporan harian yang belum diverifikasi
$jumlahLaporanBelumVerifikasi = DailyReport::where('is_active', 1)
    ->whereNull('status_verifikasi')
    ->whereHas('siswa', function ($s) use ($pegawai) {
        $s->whereHas('pengajuan', function ($p) use ($pegawai) {
            $p->whereHas('pembimbing', function ($b) use ($pegawai) {
                $b->where('pegawai_id', $pegawai->id)
                  ->whereNull('deleted_date');
            });
        });
    })
    ->count();

$reports = DailyReport::with('siswa')
    ->where('is_active', 1)
    ->whereHas('siswa', function ($s) use ($pegawai) {
        $s->whereHas('pengajuan', function ($p) use ($pegawai) {
            $p->whereHas('pembimbing', function ($b) use ($pegawai) {
                $b->where('pegawai_id', $pegawai->id)
                  ->whereNull('deleted_date');
            });
        });
    })
    ->orderBy('tanggal', 'desc')
    ->paginate(10)
    ->withQueryString();

    // Ambil semua presensi hari ini untuk modal
            $presensi = Presensi::with('siswa')
                ->where('is_active', 1)
                ->whereDate('tanggal', date('Y-m-d'))
                ->whereHas('siswa', function($s) use ($pegawai) {
                    $s->whereHas('pengajuan', function($p) use ($pegawai) {
                        $p->whereHas('pembimbing', function($b) use ($pegawai) {
                            $b->where('pegawai_id', $pegawai->id)
                              ->whereNull('deleted_date');
                        });
                    });
                })
                ->paginate(10) 
    ->withQueryString();

        }

        return view('pembimbing.dashboard', compact(
            'jumlahSiswa', 
            'jumlahPresensiHadir',
            'jumlahLaporanBelumVerifikasi', 
            'jumlahTugasBaru', 
            'daftarSiswa',
            'reports',
            'presensi'
        ));
    }
}
