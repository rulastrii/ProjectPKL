<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\SiswaProfile;
use App\Models\TugasSubmit;
use App\Models\Presensi;
use App\Models\Tugas;
use App\Models\PenilaianAkhir;
use Carbon\Carbon;

class MagangDashboardController extends Controller
{
    /**
     * Tampilkan dashboard magang
     */
    public function index() {
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

        // Ambil 3 tugas terbaru (dari tenggat terdekat) yang ditugaskan ke siswa ini
        $tugasTerbaru = Tugas::whereHas('tugasAssignees', function($q) use ($magang) {
            $q->where('siswa_id', $magang->id);
        })->with(['submits' => function($q) use ($magang) {
            $q->where('siswa_id', $magang->id);
        }])->orderBy('tenggat', 'asc')
           ->take(3)
           ->get();

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

        // Ambil total tugas yang diberikan ke siswa magang
        $totalTugas = Tugas::whereHas('tugasAssignees', function ($q) use ($magang) {
            $q->where('siswa_id', $magang->id);
        })->count();

        // Hitung tugas yang sudah selesai
        $tugasSelesai = TugasSubmit::where('siswa_id', $magang->id)
            ->where('status', '!=', 'pending')
            ->where('is_active', 1)
            ->count();

        // Hitung prosentase tugas selesai
        $prosentaseTugas = $totalTugas > 0
            ? round(($tugasSelesai / $totalTugas) * 100)
            : 0;

        // ================= HITUNG LAPORAN HARI INI =================
        $jumlahLaporanHariIni = TugasSubmit::where('siswa_id', $magang->id)
            ->whereDate('submitted_at', now('Asia/Jakarta')->toDateString())
            ->count();

        // Hitung jumlah tugas pending untuk siswa magang yang login
        $jumlahTugasPending = TugasSubmit::where('siswa_id', $magang->id)
            ->where('status', 'pending')
            ->where('is_active', 1)
            ->count();

        // ================= PENILAIAN AKHIR =================
        $penilaian = PenilaianAkhir::where('siswa_id', $magang->id)->first();

                return view('magang.dashboard', compact(
                    'magang',
                    'todayPresensi',
                    'sudahPresensi',
                    'totalHariMagang',
                    'jumlahPresensi',
                    'prosentasePresensi',
                    'jumlahLaporanHariIni',
                    'jumlahTugasPending',
                    'totalTugas',
                    'tugasSelesai',
                    'prosentaseTugas',
                    'tugasTerbaru',
                    'penilaian',
                    'serverTime'
                ));
    }

}