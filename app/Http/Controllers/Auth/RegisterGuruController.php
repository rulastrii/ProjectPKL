<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileGuru;
use App\Models\MockDataGuru;


class RegisterGuruController extends Controller
{
    public function showForm() {
        return view('auth.register-guru');
    }

    public function register(Request $request) {
        $request->validate([
            'nip'           => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
        ]);

        //  Validasi ke SISTEM DATA GURU (SIMULASI)
        $guru = MockDataGuru::where([
                'nip'                => $request->nip,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'status_kepegawaian' => 'aktif',
                'jabatan'            => 'guru',
            ])->first();

        if (!$guru) {
            return back()->withErrors([
                'nip' => 'Data guru tidak ditemukan atau tidak aktif dalam sistem'
            ]);
        }

        //  Cegah register ganda berdasarkan NIP
        if (ProfileGuru::where('nip', $guru->nip)->exists()) {
            return back()->withErrors([
                'nip' => 'Guru dengan NIP ini sudah terdaftar'
            ]);
        }

        DB::beginTransaction();

        try {
            //  Buat akun USER (email dari input guru)
            $user = User::create([
                'name'         => $guru->nama_lengkap,
                'email'        => $request->email,
                'password'     => $request->password,
                'role_id'      => 3, // GURU
                'is_active'    => false, // nunggu approve admin
                'created_date' => now(),
            ]);

            //  Buat PROFILE GURU (data resmi)
            ProfileGuru::create([
                'user_id'            => $user->id,
                'nip'                => $guru->nip,
                'nama_lengkap'       => $guru->nama_lengkap,
                'tanggal_lahir'      => $guru->tanggal_lahir,
                'unit_kerja'         => $guru->unit_kerja,
                'email_resmi'        => $guru->email_resmi,
                'jabatan'            => 'guru',
                'status_kepegawaian' => 'aktif',
                'is_active'          => false,
                'created_date'       => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi berhasil. Menunggu persetujuan admin.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat proses registrasi.'
            ]);
        }
    }

    /**
     * Validasi data guru (AJAX)
     */
    public function cekDataGuru(Request $request) {
        $request->validate([
            'nip'           => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $guru = MockDataGuru::where([
                'nip'                => $request->nip,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'status_kepegawaian' => 'aktif',
                'jabatan'            => 'guru',
            ])->first();

        if (!$guru) {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        if (ProfileGuru::where('nip', $guru->nip)->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'Guru sudah terdaftar'
            ], 409);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'nama'       => $guru->nama_lengkap,
                'unit_kerja' => $guru->unit_kerja,
            ]
        ]);
    }

}