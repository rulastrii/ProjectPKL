<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembimbing;
use App\Models\Presensi;
use App\Models\Tugas;
use App\Models\Aktivitas;
use App\Models\DailyReport;

class PembimbingDashboardController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai;

        // ===== INISIALISASI (WAJIB) =====
        $jumlahSiswa = 0;
        $jumlahPresensiHadir = 0;
        $jumlahLaporanBelumVerifikasi = 0;
        $jumlahTugasBaru = 0;
        $daftarSiswa = collect();
        $presensi = collect();
        $reports = collect();
        $aktivitas = collect();

        if ($pegawai) {

            // ================= DAFTAR SISWA =================
            $daftarSiswa = Pembimbing::with(['pengajuan', 'pegawai'])
                ->where('pegawai_id', $pegawai->id)
                ->whereNull('deleted_date')
                ->get();

            $jumlahSiswa = $daftarSiswa->count();

            // ================= PRESENSI HADIR =================
            $jumlahPresensiHadir = Presensi::where('is_active', 1)
                ->where('status', 'hadir')
                ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id)
                      ->whereNull('deleted_date');
                })
                ->count();

            // ================= ID PEMBIMBING =================
            $pembimbingIds = Pembimbing::where('pegawai_id', $pegawai->id)
                ->whereNull('deleted_date')
                ->pluck('id');

            // ================= TUGAS BARU =================
            if ($pembimbingIds->isNotEmpty()) {
                $jumlahTugasBaru = Tugas::whereIn('pembimbing_id', $pembimbingIds)
                    ->where('is_active', 1)
                    ->where('status', 'pending')
                    ->count();
            }

            // ================= LAPORAN BELUM VERIF =================
            $jumlahLaporanBelumVerifikasi = DailyReport::where('is_active', 1)
                ->whereNull('status_verifikasi')
                ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id)
                      ->whereNull('deleted_date');
                })
                ->count();

            // ================= LIST LAPORAN =================
            $reports = DailyReport::with('siswa')
                ->where('is_active', 1)
                ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id)
                      ->whereNull('deleted_date');
                })
                ->orderBy('tanggal', 'desc')
                ->paginate(10)
                ->withQueryString();

            // ================= PRESENSI HARI INI =================
            $presensi = Presensi::with('siswa')
                ->where('is_active', 1)
                ->whereDate('tanggal', now())
                ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id)
                      ->whereNull('deleted_date');
                })
                ->paginate(10)
                ->withQueryString();

            // ================= AKTIVITAS =================
            $aktivitas = Aktivitas::where('pegawai_id', $pegawai->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'nama'    => $item->nama,
                        'aksi'    => $item->aksi,
                        'tanggal' => $item->created_at,
                    ];
                });
        }

        return view('pembimbing.dashboard', compact(
            'jumlahSiswa',
            'jumlahPresensiHadir',
            'jumlahLaporanBelumVerifikasi',
            'jumlahTugasBaru',
            'daftarSiswa',
            'reports',
            'presensi',
            'aktivitas'
        ));
    }
}
