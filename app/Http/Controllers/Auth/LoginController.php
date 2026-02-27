<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
{
    $request->validate([
        'email'     => 'required|email',
        'password'  => 'required|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    // User tidak ditemukan
    if (!$user) {
        return back()->with('error', 'Email atau password salah.')->withInput();
    }

    /**
     * CEK STATUS AKUN
     * Jika nonaktif → sudah diblokir
     */
    if (!$user->is_active) {
        return back()->with(
            'error_code',
            'ACCOUNT_BLOCKED'
        )->withInput();
    }

    /**
     * PASSWORD SALAH
     */
    if (!Hash::check($request->password, $user->password)) {

        $user->failed_login_attempts += 1;

        // Jika sudah 3x salah → NONAKTIFKAN AKUN
        if ($user->failed_login_attempts >= 3) {
            $user->is_active = false;
        }

        $user->save();

        return back()->with('error', 'Email atau password salah.')->withInput();
    }

    /**
     * LOGIN BERHASIL → RESET COUNTER
     */
    $user->failed_login_attempts = 0;
    $user->save();

    /**
     * CEK VERIFIKASI EMAIL
     */
    if (!$user->hasVerifiedEmail()) {
        return back()->with(
            'error',
            'Email belum diverifikasi. Silakan cek email Anda.'
        )->withInput();
    }

    Auth::login($user);

    /**
     * FORCE CHANGE PASSWORD
     */
    $rolesForceChange = [2,3,4,5];
    if (in_array($user->role_id, $rolesForceChange) && $user->force_change_password) {
        return redirect()->route('auth.change-password')
            ->with('info', 'Anda harus mengganti password terlebih dahulu.');
    }

    /**
     * REDIRECT SESUAI ROLE
     */
    return match ($user->role_id) {
        1 => redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!'),
        2 => redirect()->route('pembimbing.dashboard')->with('success', 'Selamat datang Pembimbing!'),
        3 => redirect()->route('guru.dashboard')->with('success', 'Selamat datang Guru!'),
        4 => redirect()->route('siswa.dashboard')->with('success', 'Selamat datang Siswa!'),
        5 => redirect()->route('magang.dashboard')->with('success', 'Selamat datang Magang!'),
        default => redirect()->route('login')->with('success', 'Selamat datang!'),
    };
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
