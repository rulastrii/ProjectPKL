<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed', // butuh input password_confirmation
            'role_id'   => 'nullable|exists:roles,id'         // kalau pakai role input form
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $request->password,
            'role_id'       => $request->role_id ?? 3,   // default siswa (silakan ubah)
            'is_active'     => true,
            'created_date'  => now(),
            'created_id'    => null,
        ]);


        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }
}
