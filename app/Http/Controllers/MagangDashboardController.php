<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\SiswaProfile;
use App\Models\TugasSubmit;
use App\Models\Presensi;
use App\Models\Tugas;
use App\Models\Pembimbing;
use App\Models\Penempatan;
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

        // Jika belum ada profil, tampilkan dashboard kosong
        if (!$magang) {
            return view('magang.dashboard', [
                'magang'              => null,
                'pembimbing'          => null,
                'penempatan'          => null,
                'todayPresensi'       => null,
                'sudahPresensi'       => false,
                'totalHariMagang'     => 0,
                'jumlahPresensi'      => 0,
                'prosentasePresensi'  => 0,
                'jumlahLaporanHariIni'=> 0,
                'jumlahTugasPending'  => 0,
                'totalTugas'          => 0,
                'tugasSelesai'        => 0,
                'prosentaseTugas'     => 0,
                'tugasTerbaru'        => collect(),
                'penilaian'           => null,
                'serverTime'          => now('Asia/Jakarta')->format('H:i:s'),
            ]);
        }

        // Ambil pembimbing jika pengajuan_id ada
        $pembimbing = null;
        if ($magang->pengajuan_id) {
            $pembimbing = Pembimbing::where('pengajuan_id', $magang->pengajuan_id)
                ->where('pengajuan_type', \App\Models\PengajuanMagangMahasiswa::class)
                ->where('is_active', 1)
                ->whereNull('deleted_date')
                ->with(['pegawai', 'user'])
                ->first();
        }

        // Ambil penempatan jika pengajuan_id ada
        $penempatan = null;
        if ($magang->pengajuan_id) {
            $penempatan = Penempatan::where('pengajuan_id', $magang->pengajuan_id)
                ->where('pengajuan_type', \App\Models\PengajuanMagangMahasiswa::class)
                ->where('is_active', 1)
                ->with('bidang')
                ->first();
        }

        $serverTime = now('Asia/Jakarta')->format('H:i:s');

        // Ambil 3 tugas terbaru
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

        $sudahPresensi = $todayPresensi 
            && (!is_null($todayPresensi->jam_masuk) || !is_null($todayPresensi->jam_keluar));

        $jamMasukNormal = Carbon::createFromTime(11, 0, 0, 'Asia/Jakarta');
        $telatMasuk = false;
        if ($todayPresensi && $todayPresensi->jam_masuk) {
            $telatMasuk = Carbon::createFromFormat('H:i:s', $todayPresensi->jam_masuk, 'Asia/Jakarta')
                ->gt($jamMasukNormal);
        }

        // Progress presensi
        $tanggalMulai = optional($magang->pengajuan)->tanggal_mulai
            ? Carbon::parse($magang->pengajuan->tanggal_mulai)
            : Carbon::today();

        $tanggalSekarang = Carbon::today();
        $totalHariMagang = 0;
        for ($d = $tanggalMulai->copy(); $d->lte($tanggalSekarang); $d->addDay()) {
            if (!$d->isWeekend()) $totalHariMagang++;
        }

        $jumlahPresensi = Presensi::where('siswa_id', $magang->id)
            ->whereNotNull('jam_masuk')
            ->count();

        $prosentasePresensi = $totalHariMagang > 0
            ? round(($jumlahPresensi / $totalHariMagang) * 100)
            : 0;

        // Total tugas & tugas selesai
        $totalTugas = Tugas::whereHas('tugasAssignees', function ($q) use ($magang) {
            $q->where('siswa_id', $magang->id);
        })->count();

        $tugasSelesai = TugasSubmit::where('siswa_id', $magang->id)
            ->where('status', '!=', 'pending')
            ->where('is_active', 1)
            ->count();

        $prosentaseTugas = $totalTugas > 0
            ? round(($tugasSelesai / $totalTugas) * 100)
            : 0;

        // Laporan hari ini
        $jumlahLaporanHariIni = TugasSubmit::where('siswa_id', $magang->id)
            ->whereDate('submitted_at', now('Asia/Jakarta')->toDateString())
            ->count();

        // Tugas pending
        $jumlahTugasPending = TugasSubmit::where('siswa_id', $magang->id)
            ->where('status', 'pending')
            ->where('is_active', 1)
            ->count();

        // Penilaian akhir
        $penilaian = PenilaianAkhir::where('siswa_id', $magang->id)->first();

        return view('magang.dashboard', compact(
            'magang',
            'pembimbing',
            'penempatan',
            'todayPresensi',
            'sudahPresensi',
            'totalHariMagang',
            'jumlahPresensi',
            'telatMasuk',
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
