<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\PengajuanPklmagang;
use App\Models\SiswaProfile;
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
        $pesertaPerBulan = SiswaProfile::selectRaw('MONTH(created_date) as bulan, COUNT(*) as total')
                                ->whereYear('created_date', $currentYear)
                                ->where('is_active', true)
                                ->groupBy('bulan')
                                ->orderBy('bulan')
                                ->pluck('total', 'bulan')
                                ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $pesertaPerBulan[$i] ?? 0;
        }

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
                    'sekolah' => $item->sekolah?->nama_sekolah ?? '-',
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
            'chartData',
            'pengajuanTerbaru'
        ));
    }

}