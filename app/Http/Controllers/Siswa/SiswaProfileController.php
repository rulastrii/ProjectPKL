<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanPklSiswa;

class SiswaProfileController extends Controller
{
    /**
     * Tampilkan profile siswa PKL
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan role PKL
        if ($user->role_id != 4) {
            abort(403, 'Akses hanya untuk siswa PKL.');
        }

        // Ambil pengajuan PKL yang terkait user ini
        $pengajuan = PengajuanPklmagang::where('user_id', $user->id)->first();

        // Ambil atau buat profile
        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuanpkl_id' => $pengajuan?->id,
                'nama'            => '',
                'nisn'            => '',
                'kelas'           => '',
                'jurusan'         => $pengajuan?->jurusan ?? '',
                'foto'            => '',
                'is_active'       => true,
                'created_date'    => now(),
                'created_id'      => $user->id
            ]
        );

        // Pastikan siswa_id di pengajuan_pkl_siswa terisi
        if ($pengajuan) {
            $pengajuanSiswa = PengajuanPklSiswa::where('email_siswa', $user->email)
                ->whereNull('siswa_id')
                ->first();

            if ($pengajuanSiswa) {
                $pengajuanSiswa->siswa_id = $profile->id;
                $pengajuanSiswa->save();
            }
        }

        $statusProfile = $profile->isLengkap();
        $email = $user->email;

        return view('siswa.profile.index', compact('profile', 'statusProfile', 'email'));
    }

    /**
     * Update profile siswa PKL + optional password
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 4) {
            abort(403, 'Akses hanya untuk siswa PKL.');
        }

        $pengajuan = PengajuanPklmagang::where('user_id', $user->id)->first();

        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuanpkl_id' => $pengajuan?->id,
                'created_date'    => now(),
                'created_id'      => $user->id,
            ]
        );

        // Validasi input + password opsional
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'nisn'             => 'required|string|max:50',
            'kelas'            => 'required|string|max:50',
            'jurusan'          => 'required|string|max:50',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'         => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|required_with:password|string',
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
        $validated['pengajuanpkl_id'] = $pengajuan?->id;
        $validated['updated_date'] = now();
        $validated['updated_id']   = $user->id;
        $profile->update($validated);

        // Pastikan siswa_id di pengajuan_pkl_siswa tetap sinkron
        if ($pengajuan) {
            $pengajuanSiswa = PengajuanPklSiswa::where('email_siswa', $user->email)
                ->whereNull('siswa_id')
                ->first();

            if ($pengajuanSiswa) {
                $pengajuanSiswa->siswa_id = $profile->id;
                $pengajuanSiswa->save();
            }
        }

        // Update password jika diisi
        if (!empty($request->password)) {
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama salah.']);
            }

            $user->password = $request->password;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile dan password berhasil disimpan!');
    }
}
