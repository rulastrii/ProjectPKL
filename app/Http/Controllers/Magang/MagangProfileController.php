<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\PengajuanMagangMahasiswa;

class MagangProfileController extends Controller
{
    /**
     * Tampilkan profile mahasiswa magang
     */
    public function index() {
        $user = Auth::user();

        // Ambil pengajuan magang yang sudah diterima dan terkait user ini
        $pengajuan = PengajuanMagangMahasiswa::where('user_id', $user->id)->first();

        // Ambil atau buat profile gabungan
        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuan_id' => $pengajuan?->id,
                'nama'        => '',
                'nim'         => '',
                'jurusan'     => $pengajuan?->jurusan ?? '',
                'universitas' => $pengajuan?->universitas ?? '',
                'foto'        => '',
                'is_active'   => true,
                'created_date'=> now(),
                'created_id'  => $user->id
            ]
        );

        $statusProfile = $profile->isLengkap();
        $email = $user->email; // Tambahkan email user

        return view('magang.profile.index', compact('profile', 'statusProfile', 'email'));
    }


    /**
     * Update profile mahasiswa magang + optional password
     */
    public function update(Request $request) {
        $user = Auth::user();

        // Ambil pengajuan magang yang sudah diterima dan terkait user ini
        $pengajuan = PengajuanMagangMahasiswa::where('user_id', $user->id)->first();

        // Ambil atau buat profile
        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuan_id' => $pengajuan?->id,
                'created_date' => now(),
                'created_id'   => $user->id,
            ]
        );

        // Validasi input + password opsional
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'nim'         => 'required|string|max:50',
            'jurusan'     => 'required|string|max:50',
            'universitas' => 'required|string|max:100',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'    => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|required_with:password|string'
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            if ($profile->foto && file_exists(public_path('uploads/foto_siswa/'.$profile->foto))) {
                unlink(public_path('uploads/foto_siswa/'.$profile->foto));
            }

            $file = $request->file('foto');
            $filename = 'foto_'.$profile->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_siswa'), $filename);
            $validated['foto'] = $filename;
        }

        // Update profile
            $validated['pengajuan_id'] = $pengajuan?->id;
            $validated['updated_date'] = now();
            $validated['updated_id']   = $user->id;
            $profile->update($validated);

        // Update password jika diisi (mutator otomatis hash)
        if (!empty($request->password)) {
            // cek password lama
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama salah.']);
            }

            $user->password = $request->password; // mutator akan hash otomatis
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile dan password berhasil disimpan!');
    }

}