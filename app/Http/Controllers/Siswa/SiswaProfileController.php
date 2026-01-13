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
     * Ambil pengajuan PKL (mandiri / sekolah)
     */
    private function resolvePengajuan($user)
    {
        // 1. PKL mandiri (login siswa)
        $pengajuan = PengajuanPklmagang::where('user_id', $user->id)->first();
        if ($pengajuan) {
            return $pengajuan;
        }

        // 2. PKL sekolah (diajukan guru)
        $pengajuanSiswa = PengajuanPklSiswa::where('email_siswa', $user->email)
            ->whereIn('status', ['diterima', 'diproses'])
            ->first();

        if ($pengajuanSiswa) {
            return PengajuanPklmagang::find($pengajuanSiswa->pengajuan_id);
        }

        return null;
    }

    /**
     * Tampilkan profile siswa PKL
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id != 4) {
            abort(403, 'Akses hanya untuk siswa PKL.');
        }

        $pengajuan = $this->resolvePengajuan($user);

        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuanpkl_id' => $pengajuan?->id,
                'nama'            => '',
                'nisn'            => '',
                'kelas'           => '',
                'jurusan'         => '',
                'foto'            => '',
                'is_active'       => true,
                'created_date'    => now(),
                'created_id'      => $user->id,
            ]
        );

        // Sinkron siswa_id ke pengajuan_pkl_siswa
        if ($pengajuan) {
            $pengajuanSiswa = PengajuanPklSiswa::where('pengajuan_id', $pengajuan->id)
                ->where('email_siswa', $user->email)
                ->first();

            if ($pengajuanSiswa && $pengajuanSiswa->siswa_id !== $profile->id) {
                $pengajuanSiswa->siswa_id = $profile->id;
                $pengajuanSiswa->save();
            }

            // pastikan pengajuanpkl_id tersimpan
            if ($profile->pengajuanpkl_id !== $pengajuan->id) {
                $profile->pengajuanpkl_id = $pengajuan->id;
                $profile->save();
            }
        }

        $statusProfile = $profile->isLengkap();
        $email = $user->email;

        return view('siswa.profile.index', compact('profile', 'statusProfile', 'email'));
    }

    /**
     * Update profile siswa PKL + password opsional
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 4) {
            abort(403, 'Akses hanya untuk siswa PKL.');
        }

        $pengajuan = $this->resolvePengajuan($user);

        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pengajuanpkl_id' => $pengajuan?->id,
                'created_date'    => now(),
                'created_id'      => $user->id,
            ]
        );

        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'nisn'             => 'required|string|max:50',
            'kelas'            => 'required|string|max:50',
            'jurusan'          => 'required|string|max:50',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'         => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|required_with:password|string',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($profile->foto && file_exists(public_path('uploads/foto_siswa/' . $profile->foto))) {
                unlink(public_path('uploads/foto_siswa/' . $profile->foto));
            }

            $file = $request->file('foto');
            $filename = 'foto_' . $profile->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_siswa'), $filename);
            $validated['foto'] = $filename;
        }

        $validated['pengajuanpkl_id'] = $pengajuan?->id;
        $validated['updated_date'] = now();
        $validated['updated_id'] = $user->id;
        $profile->update($validated);

        // Sinkron siswa_id
        if ($pengajuan) {
            $pengajuanSiswa = PengajuanPklSiswa::where('pengajuan_id', $pengajuan->id)
                ->where('email_siswa', $user->email)
                ->first();

            if ($pengajuanSiswa && $pengajuanSiswa->siswa_id !== $profile->id) {
                $pengajuanSiswa->siswa_id = $profile->id;
                $pengajuanSiswa->save();
            }
        }

        // Update password
        if (!empty($request->password)) {
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()->withErrors([
                    'current_password' => 'Password lama salah.'
                ]);
            }

            $user->password = $request->password;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile dan password berhasil disimpan!');
    }
}
