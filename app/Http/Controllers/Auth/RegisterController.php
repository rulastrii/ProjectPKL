<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyEmailNotification;

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
        'password'  => 'required|string|min:6|confirmed',
        'role_id'   => 'nullable|exists:roles,id'
    ]);

    $user = User::create([
        'name'          => $request->name,
        'email'         => $request->email,
        'password'      => $request->password,
        'role_id'       => $request->role_id ?? 3,
        'is_active'     => true,
        'created_date'  => now(),
        'created_id'    => null,
    ]);

    // Kirim email verifikasi
    $user->notify(new VerifyEmailNotification());


    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi akun.');
}
}
