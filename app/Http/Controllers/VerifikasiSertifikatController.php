<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;

class VerifikasiSertifikatController extends Controller
{
    public function show($token) {
        $sertifikat = Sertifikat::with('siswa')
            ->where('qr_token', $token)
            ->first();

        if (!$sertifikat) {
            return view('sertifikat.verifikasi_invalid');
        }

        return view('sertifikat.verifikasi_valid', compact('sertifikat'));
    }
    
}
