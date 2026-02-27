<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\PengajuanPklmagang;
use App\Models\SiswaProfile;
use App\Models\Penempatan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index() {
        // Total Bidang Aktif
        $totalBidang = Bidang::active()->count();

        // Total Pembimbing Aktif
        $totalPembimbing = Pembimbing::where('is_active', true)->count();

        // Total Pengajuan Masuk (aktif)
        $totalPengajuan = PengajuanMagangMahasiswa::where('is_active', true)->count();

        // Menunggu Verifikasi
        $menungguVerifikasi = PengajuanMagangMahasiswa::where('status', 'diproses')
                                ->where('is_active', true)
                                ->count();

        // Total Peserta Aktif
        $totalPeserta = SiswaProfile::where('is_active', true)->count();

        // Data peserta PKL per bulan
        $currentYear = Carbon::now()->year;
        // --- Hitung PKL per bulan ---
$pkls = DB::table('pengajuan_pkl_siswa')
    ->join('pengajuan_pklmagang', 'pengajuan_pkl_siswa.pengajuan_id', '=', 'pengajuan_pklmagang.id')
    ->whereYear('pengajuan_pklmagang.periode_mulai', $currentYear)
    ->where('pengajuan_pkl_siswa.status', 'diterima')
    ->select('pengajuan_pkl_siswa.nama_siswa', 'pengajuan_pklmagang.periode_mulai')
    ->get();

$pklsPerBulan = [];
foreach ($pkls as $p) {
    $bulan = Carbon::parse($p->periode_mulai)->month;
    $pklsPerBulan[$bulan][] = $p->nama_siswa; // simpan nama siswa
}

// --- Hitung Magang per bulan ---
$magangs = PengajuanMagangMahasiswa::where('is_active', true)
    ->whereYear('periode_mulai', $currentYear)
    ->where('status', 'diterima')
    ->select('id','universitas','periode_mulai')
    ->get();

$magangPerBulan = [];
foreach ($magangs as $m) {
    $bulan = Carbon::parse($m->periode_mulai)->month;
    $magangPerBulan[$bulan][] = $m->universitas ?? 'Mahasiswa';
}

// --- Siapkan data chart ---
$chartDataPKL = [];
$chartDataMagang = [];
for ($i = 1; $i <= 12; $i++) {
    $chartDataPKL[] = isset($pklsPerBulan[$i]) ? count($pklsPerBulan[$i]) : 0;
    $chartDataMagang[] = isset($magangPerBulan[$i]) ? count($magangPerBulan[$i]) : 0;
}

        // =======================
// Statistik Peserta Per Bidang
// =======================
$pesertaPerBidang = Penempatan::where('penempatan.is_active', true)
    ->join('bidang', 'penempatan.bidang_id', '=', 'bidang.id')
    ->where('bidang.is_active', true)
    ->select(
        'bidang.nama as bidang',
        DB::raw('COUNT(penempatan.id) as total')
    )
    ->groupBy('bidang.nama')
    ->orderBy('bidang.nama')
    ->get();

// Pisahkan label & value (buat chart)
$bidangLabels = $pesertaPerBidang->pluck('bidang');
$bidangTotals = $pesertaPerBidang->pluck('total');

        // --- Pengajuan Terbaru ---
        $pengajuanMagang = PengajuanMagangMahasiswa::where('is_active', true)
            ->select('id','no_surat','tgl_surat','status','periode_mulai','periode_selesai','universitas')
            ->get()
            ->map(function($item) {
                $periodeMulai = $item->periode_mulai ? Carbon::parse($item->periode_mulai)->format('M Y') : '-';
                $periodeSelesai = $item->periode_selesai ? Carbon::parse($item->periode_selesai)->format('M Y') : '-';
                return [
                    'id' => $item->id,
                    'no_surat' => $item->no_surat,
                    'sekolah' => $item->universitas ?? '-',
                    'periode' => "$periodeMulai - $periodeSelesai",
                    'status' => $item->status,
                    'type' => 'magang',
                    'tgl_surat' => $item->tgl_surat
                ];
            });

        $pengajuanPkl = PengajuanPklmagang::where('is_active', true)
            ->with('sekolah')
            ->select('id','no_surat','tgl_surat','status','sekolah_id','periode_mulai','periode_selesai')
            ->get()
            ->map(function($item) {
                $periodeMulai = $item->periode_mulai ? Carbon::parse($item->periode_mulai)->format('M Y') : '-';
                $periodeSelesai = $item->periode_selesai ? Carbon::parse($item->periode_selesai)->format('M Y') : '-';
                return [
                    'id' => $item->id,
                    'no_surat' => $item->no_surat,
                    'sekolah' => $item->sekolah?->nama ?? '-',
                    'periode' => "$periodeMulai - $periodeSelesai",
                    'status' => $item->status,
                    'type' => 'pkl',
                    'tgl_surat' => $item->tgl_surat
                ];
            });

        $pengajuanTerbaru = collect($pengajuanMagang)
                            ->merge($pengajuanPkl)
                            ->sortByDesc('tgl_surat')
                            ->take(5);

        return view('admin.dashboard', compact(
            'totalBidang',
            'totalPembimbing',
            'totalPengajuan',
            'menungguVerifikasi',
            'totalPeserta',
            'chartDataPKL',
            'chartDataMagang',
            'pengajuanTerbaru',
            'bidangLabels',
    'bidangTotals'
        ));
    }

}