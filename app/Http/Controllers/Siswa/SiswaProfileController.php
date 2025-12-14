<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;

class SiswaProfileController extends Controller
{
    public function index()
{
    // Ambil / buat profile siswa dulu
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

    // Baru cek status kelengkapan
    $statusProfile = $profile->isLengkap();

    return view('siswa.profile.index', compact('profile','statusProfile'));
}


    public function update(Request $request)
    {
        $profile = SiswaProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            ['created_date' => now(), 'created_id' => Auth::id()]
        );

        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'nisn'    => 'required|string|max:50',
            'kelas'   => 'required|string|max:20',
            'jurusan' => 'required|string|max:50',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'foto_'.$profile->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_siswa'), $filename);
            $validated['foto'] = $filename;
        }

        $validated['updated_date'] = now();
        $validated['updated_id']   = Auth::id();

        $profile->update($validated);

        return redirect()->back()->with('success','Profile berhasil disimpan!');
    }
}
