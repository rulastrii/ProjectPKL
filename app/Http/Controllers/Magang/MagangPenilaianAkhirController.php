<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;
use App\Models\PenilaianAkhir;

class MagangPenilaianAkhirController extends Controller
{
    /**
     * Lihat nilai akhir peserta
     */
    public function index() {
        $siswa = SiswaProfile::where('user_id', auth()->id())->firstOrFail();

        $penilaian = PenilaianAkhir::where('siswa_id', $siswa->id)->first();

        return view('magang.penilaian-akhir.index', compact('penilaian'));
    }

}