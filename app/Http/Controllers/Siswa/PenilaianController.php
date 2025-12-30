<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;
use App\Models\PenilaianAkhir;

class PenilaianController extends Controller
{
    /**
     * Lihat nilai akhir peserta
     */
    public function index() {
        $siswa = SiswaProfile::where('user_id', auth()->id())->firstOrFail();

        $penilaian = PenilaianAkhir::where('siswa_id', $siswa->id)->first();

        return view('siswa.penilaian.index', compact('penilaian'));
    }

}