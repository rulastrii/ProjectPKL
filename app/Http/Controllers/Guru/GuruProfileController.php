<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->guruProfile;

        $statusProfile = $profile && $profile->sekolah && $profile->dokumen_verifikasi;

        return view('guru.profile.index', compact('user','profile','statusProfile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->guruProfile;

        $request->validate([
            'name'     => 'required|string|max:150',
            'nip'      => 'nullable|string|max:20',
            'sekolah'  => 'required|string|max:150',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // update user
        $user->update([
            'name' => $request->name,
            'password' => $request->password ?: $user->password, // pakai MUTATOR
        ]);

        // update guru profile
        $profile->update([
            'nip'     => $request->nip,
            'sekolah' => $request->sekolah,
        ]);

        return back()->with('success', 'Profil guru berhasil diperbarui.');
    }

    public function uploadDokumen(Request $request)
    {
        $profile = Auth::user()->guruProfile;

        if ($profile->dokumen_verifikasi) {
            return back()->with('error', 'Dokumen sudah diupload.');
        }

        $request->validate([
            'dokumen_verifikasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('dokumen_verifikasi');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = public_path('uploads/guru/dokumen');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $filename);

        $profile->update([
            'dokumen_verifikasi' => 'uploads/guru/dokumen/'.$filename,
        ]);

        return back()->with('success', 'Dokumen berhasil diupload.');
    }
}
