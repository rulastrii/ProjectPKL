<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\PenilaianAkhir;
use App\Models\SiswaProfile;

class MagangPenilaianAkhirController extends Controller
{
    /**
     * Lihat nilai akhir peserta
     */
    public function index()
    {
        $siswa = SiswaProfile::where('user_id', auth()->id())->firstOrFail();

        $penilaian = PenilaianAkhir::where('siswa_id', $siswa->id)->first();

        return view('magang.penilaian_akhir.index', compact('penilaian'));
    }
}
