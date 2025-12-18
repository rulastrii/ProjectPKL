<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceChangePassword
{
    public function handle($request, Closure $next)
{
    $user = Auth::user();

    // Hanya berlaku untuk role tertentu (sesuaikan role_id)
    $roles = [2, 4, 5]; // 4 = Siswa, 5 = Magang, 2 = Pembimbing

    if ($user && in_array($user->role_id, $roles) && $user->force_change_password) {
    if ($request->routeIs('auth.change-password') || $request->routeIs('password.update')) {
        return $next($request);
    }

    return redirect()->route('auth.change-password')
        ->with('info', 'Silakan ganti password Anda terlebih dahulu.');
}


    return $next($request);
}

}
