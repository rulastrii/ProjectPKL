<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // =====================
    // FORM FORGOT PASSWORD
    // =====================
    public function showForm() {
        return view('auth.forgot-password');
    }

    // =====================
    // KIRIM KODE RESET
    // =====================
    public function sendResetCode(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = strtolower(trim($request->email));

        // 🔐 generate kode kuat (uppercase + angka + simbol)
        $token = strtoupper($this->generateStrongCode(6));

        // ❗ hapus token lama (hindari konflik)
        DB::table('password_resets')->where('email', $email)->delete();

        // simpan token baru
        DB::table('password_resets')->insert([
            'email'      => $email,
            'token'      => $token,
            'created_at' => now(),
        ]);

        // kirim email (blade)
        Mail::send('emails.password-reset-code', [
            'token' => $token,
        ], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Password Reset Code');
        });

        return back()->with('success', 'Kode reset password telah dikirim ke email Anda.');
    }

    // =====================
    // FORM RESET PASSWORD
    // =====================
    public function showResetForm() {
        return view('auth.reset-password');
    }

    // =====================
    // PROSES RESET PASSWORD
    // =====================
    public function resetPassword(Request $request) {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        $email = strtolower(trim($request->email));
        $token = strtoupper(trim($request->token)); // 🔥 FIX PALING PENTING

        // ambil token dari DB
        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return back()->withInput()->with('error', 'Kode reset tidak valid.');
        }

        // cek expired (15 menit)
        if (Carbon::parse($reset->created_at)->lt(now()->subMinutes(15))) {
            DB::table('password_resets')->where('email', $email)->delete();

            return back()->withInput()->with('error', 'Kode reset sudah kadaluarsa.');
        }

        // update password (mutator hash otomatis)
        $user = User::where('email', $email)->first();
        $user->password = $request->password;
        $user->save();

        // hapus token setelah sukses
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }

    // =====================
    // GENERATE KODE KUAT
    // =====================
    private function generateStrongCode(int $length = 6): string
    {
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*';

        // wajib ada tiap jenis
        $code  = $upper[random_int(0, strlen($upper) - 1)];
        $code .= $numbers[random_int(0, strlen($numbers) - 1)];
        $code .= $symbols[random_int(0, strlen($symbols) - 1)];

        $all = $upper . $numbers . $symbols;

        for ($i = strlen($code); $i < $length; $i++) {
            $code .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($code);
    }
}
