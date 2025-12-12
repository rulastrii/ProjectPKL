<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PengajuanPklmagang;
use App\Models\SiswaProfile;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total Bidang Aktif
        $totalBidang = Bidang::active()->count();

        // Total Pembimbing Aktif
        $totalPembimbing = Pembimbing::where('is_active', true)->count();

        // Total Pengajuan Masuk (aktif)
        $totalPengajuan = PengajuanPklmagang::where('is_active', true)->count();

        // Menunggu Verifikasi (status = 0 atau sesuai kode status verifikasi)
        $menungguVerifikasi = PengajuanPklmagang::where('status', 'diproses')
                                         ->where('is_active', true)
                                         ->count();

        // Total Peserta Aktif (jumlah SiswaProfile yang is_active)
        $totalPeserta = SiswaProfile::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalBidang',
            'totalPembimbing',
            'totalPengajuan',
            'menungguVerifikasi',
            'totalPeserta'
        ));
    }
}
