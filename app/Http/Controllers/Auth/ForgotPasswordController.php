<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // Form forgot password
    public function showForm() {
        return view('auth.forgot-password');
    }

    // Proses kirim kode ke email
    public function sendResetCode(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $token = Str::upper(Str::random(6)); // Kode 6 karakter uppercase

        // Simpan kode ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Kirim email
        Mail::raw("Your password reset code: $token", function($message) use ($email) {
            $message->to($email)
                    ->subject('Password Reset Code');
        });

        return back()->with('success', 'Password reset code has been sent!');

    }

    // Form reset password
    public function showResetForm() {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        // Ambil token dari DB dan cek validitas
        $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

        if (!$reset) {
            return back()->withInput()->with('error', 'Invalid reset code.');
        }

        // Cek waktu kadaluarsa token 15 menit
        if (\Carbon\Carbon::parse($reset->created_at)->lt(now()->subMinutes(15))) {
            return back()->withInput()->with('error', 'Reset code has expired.');
        }

        // Update password di tabel users (mutator otomatis hash)
        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        // Hapus token setelah berhasil reset
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset. You can login now.');
    }

}