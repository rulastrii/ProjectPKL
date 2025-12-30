<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Sertifikat;

class SiswaSertifikatController extends Controller
{
    public function index() {
        $user = Auth::user();
        $siswaId = $user->siswaProfile->id ?? null;

        $sertifikat = Sertifikat::with('siswa')
            ->where('siswa_id', $siswaId)
            ->paginate(10);

        return view('siswa.sertifikat.index', compact('sertifikat'));
    }

}