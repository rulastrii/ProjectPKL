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

        /* =============================
         * BASE QUERY SISWA BIMBINGAN GURU
         * ============================= */
        $baseQuery = PengajuanPklSiswa::whereHas('pengajuan', function ($q) use ($guruId) {
            $q->where('created_id', $guruId);
        });

        /* =============================
         * TOTAL SISWA BIMBINGAN
         * ============================= */
        $totalSiswa = (clone $baseQuery)->count();

        /* =============================
         * STATUS PENGAJUAN
         * ============================= */

        $pengajuanDisetujui = (clone $baseQuery)
            ->where('status', 'diterima')
            ->count();

        $pengajuanDitolak = (clone $baseQuery)
            ->where('status', 'ditolak')
            ->count();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'pengajuanDisetujui',
            'pengajuanDitolak'
        ));
    }
}
