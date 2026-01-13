<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuruVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // bukan guru
        if (! $user || ! $user->isGuru()) {
            abort(403);
        }

        // belum diverifikasi admin
        if (
            ! $user->guruProfile ||
            $user->guruProfile->status_verifikasi !== 'approved' ||
            ! $user->is_active
        ) {
            return redirect()->route('login')
                ->with('error', 'Akun guru belum diverifikasi oleh admin.');
        }

        return $next($request);
    }
}
