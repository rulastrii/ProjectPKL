<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\User;

class SiswaProfileController extends Controller
{
    public function index()
{
    // Ambil / buat profile siswa
    $profile = SiswaProfile::firstOrCreate(
        ['user_id' => Auth::id()],
        [
            'nama' => '',
            'nisn' => '',
            'kelas' => '',
            'jurusan' => '',
            'is_active' => true,
            'created_date' => now(),
            'created_id' => Auth::id()
        ]
    );

    // Cek status kelengkapan
    $statusProfile = $profile->isLengkap();

    // Ambil email user
    $email = Auth::user()->email;

    return view('siswa.profile.index', compact('profile','statusProfile','email'));
}


    public function update(Request $request)
    {
        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            ['created_date' => now(), 'created_id' => Auth::id()]
        );

        // Validasi profile + password opsional
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nisn'               => 'required|string|max:50',
            'kelas'              => 'required|string|max:20',
            'jurusan'            => 'required|string|max:50',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'           => 'nullable|string|min:6|confirmed',
            'current_password'   => 'nullable|required_with:password|string'
        ]);

        // Upload foto
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
        $validated['updated_date'] = now();
        $validated['updated_id']   = Auth::id();
        $profile->update($validated);

        // Update password jika diisi (mutator otomatis hash)
        if (!empty($request->password)) {
            $user = Auth::user();
            // cek current password
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama salah.']);
            }
            $user->password = $request->password; // mutator hash otomatis
            $user->save();
        }

        return redirect()->back()->with('success','Profile dan password berhasil disimpan!');
    }
}
