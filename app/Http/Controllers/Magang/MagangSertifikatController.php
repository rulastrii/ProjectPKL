<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Sertifikat;

class MagangSertifikatController extends Controller
{
    public function index() {
        $user = Auth::user();
        $siswaId = $user->siswaProfile->id ?? null;

        $sertifikat = Sertifikat::with('siswa')
            ->where('siswa_id', $siswaId)
            ->paginate(10);

        return view('magang.sertifikat.index', compact('sertifikat'));
    }

}