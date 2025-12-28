<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ProfileGuru;

class GuruVerified
{
    public function handle(Request $request, Closure $next) {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Harus role guru
        if ($user->role_id != 3) {
            abort(403);
        }

        // Cek profile guru
        $profile = ProfileGuru::where('user_id', $user->id)
            ->where('is_active', true)
            ->whereNull('deleted_date')
            ->first();

        if (!$profile) {
            return redirect()->route('login')
                ->with('error', 'Akun guru belum terverifikasi');
        }

        return $next($request);
    }

}