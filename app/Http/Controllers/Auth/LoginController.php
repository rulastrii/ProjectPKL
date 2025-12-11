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

        $user = User::where('email', $request->email)
            ->where('is_active', true)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        Auth::login($user);

        // Arahkan dashboard sesuai role
        return match($user->role_id) {
            1 => redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!'),
            2 => redirect()->route('pembimbing.dashboard')->with('success', 'Selamat datang Pembimbing!'),
            default => redirect()->route('siswa.dashboard')->with('success', 'Selamat datang Siswa!'),
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
