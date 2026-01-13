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
    public function showLoginForm() {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request) {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        // Cek status akun guru
        if (!$user->is_active) {
            if ($user->reject_reason) {
                // Akun ditolak admin
                return back()->with('error', 'Akun Anda telah ditolak oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.')->withInput();
            } else {
                // Menunggu persetujuan admin
                return back()->with('error', 'Akun Anda masih menunggu persetujuan admin.')->withInput();
            }
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        // Cek verifikasi email (hanya untuk akun yang sudah disetujui)
        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'Akun Anda sudah disetujui admin, namun email belum diverifikasi. Silakan cek email untuk melakukan verifikasi.')->withInput();
        }

        // Login berhasil
        Auth::login($user);

        // Cek apakah user harus ganti password
        $rolesForceChange = [2,3,4,5]; // role yang wajib ganti password
        if (in_array($user->role_id, $rolesForceChange) && $user->force_change_password) {
            return redirect()->route('auth.change-password')
                ->with('info', 'Anda harus mengganti password terlebih dahulu.');
        }

        // Arahkan dashboard sesuai role
            return match($user->role_id) {
                1 => redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!'),
                2 => redirect()->route('pembimbing.dashboard')->with('success', 'Selamat datang Pembimbing!'),
                3 => redirect()->route('guru.dashboard')->with('success', 'Selamat datang Guru!'),
                4 => redirect()->route('siswa.dashboard')->with('success', 'Selamat datang Siswa!'),
                5 => redirect()->route('magang.dashboard')->with('success', 'Selamat datang Magang!'),
                default => redirect()->route('login')->with('success', 'Selamat datang!'),
            };
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

}