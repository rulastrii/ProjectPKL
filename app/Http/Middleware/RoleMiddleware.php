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
        $userRole = auth()->user()->role_id;

        // Jika role tidak sesuai
        if (!in_array($userRole, $roles)) {

            // Redirect otomatis ke dashboard sesuai role user
            $route = match($userRole) {
                1 => 'admin.dashboard',        // ADMIN
                2 => 'pembimbing.dashboard',   // PEMBIMBING
                3 => 'guru.dashboard',         // GURU
                4 => 'siswa.dashboard',        // SISWA
                5 => 'magang.dashboard',       // MAGANG
                default => 'magang.dashboard', // DEFAULT
            };

            return redirect()->route($route)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
