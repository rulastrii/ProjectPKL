<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;
use App\Models\Presensi;
use Carbon\Carbon;

class MagangDashboardController extends Controller
{
    /**
     * Tampilkan dashboard magang
     */
    public function index()
    {
        $user = auth()->user();

        // Validasi role magang
        if ($user->role_id != 5) {
            abort(403, 'Akses hanya untuk magang');
        }

        // Ambil profil magang
        $magang = SiswaProfile::where('user_id', $user->id)->first();

        // Jam server Asia/Jakarta (24 jam)
        $serverTime = now('Asia/Jakarta')->format('H:i:s');

        if (!$magang) {
            return view('magang.dashboard', [
                'magang'              => null,
                'todayPresensi'       => null,
                'sudahPresensi'       => false,
                'totalHariMagang'     => 0,
                'jumlahPresensi'      => 0,
                'prosentasePresensi'  => 0,
                'serverTime'          => $serverTime,
            ]);
        }

        // Presensi hari ini
        $todayPresensi = Presensi::where('siswa_id', $magang->id)
            ->where('tanggal', Carbon::today()->toDateString())
            ->first();

        $sudahPresensi = $todayPresensi && $todayPresensi->jam_masuk;

        // ================= HITUNG PROGRESS PRESENSI =================
        $tanggalMulai = optional($magang->pengajuan)->tanggal_mulai 
            ? Carbon::parse($magang->pengajuan->tanggal_mulai)
            : Carbon::today();

        $tanggalSekarang = Carbon::today();

        $totalHariMagang = 0;
        for ($d = $tanggalMulai->copy(); $d->lte($tanggalSekarang); $d->addDay()) {
            if (!$d->isWeekend()) {
                $totalHariMagang++;
            }
        }

        $jumlahPresensi = Presensi::where('siswa_id', $magang->id)
            ->whereNotNull('jam_masuk')
            ->count();

        $prosentasePresensi = $totalHariMagang > 0
            ? round(($jumlahPresensi / $totalHariMagang) * 100)
            : 0;

        return view('magang.dashboard', compact(
            'magang',
            'todayPresensi',
            'sudahPresensi',
            'totalHariMagang',
            'jumlahPresensi',
            'prosentasePresensi',
            'serverTime'
        ));
    }
}
