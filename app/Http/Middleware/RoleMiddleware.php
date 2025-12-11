<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{

    // Jika role tidak sesuai
    if (!in_array(auth()->user()->role_id, $roles)) {

        // Redirect otomatis ke dashboard sesuai role user
        $route = match(auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'pembimbing.dashboard',
            default => 'siswa.dashboard',
        };

        return redirect()->route($route)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }

    return $next($request);
}

}
