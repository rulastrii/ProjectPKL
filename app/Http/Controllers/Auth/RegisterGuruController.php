<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GuruProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterGuruController extends Controller
{
    /**
     * Tampilkan form register guru
     */
    public function showForm()
    {
        return view('auth.register-guru');
    }

    /**
     * Proses register guru
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'nip'       => 'nullable|string|max:20',
            'sekolah'   => 'required|string|max:150',
            'dokumen'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            // simpan user (guru)
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'password'     => $request->password,
                'role_id'      => 3,        // GURU
                'is_active'    => false,    // belum aktif
                'created_date' => now(),
                'created_id'   => null,
            ]);

            // upload dokumen ke public/uploads
            $file = $request->file('dokumen');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/guru/dokumen'), $filename);


            // simpan profile guru
            GuruProfile::create([
                'user_id'             => $user->id,
                'nip'                 => $request->nip,
                'sekolah'             => $request->sekolah,
                'dokumen_verifikasi' => 'uploads/guru/dokumen/'.$filename,
                'status_verifikasi'   => 'pending',
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Registrasi guru berhasil. Menunggu verifikasi admin.');
    }
}
