<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $profile = SiswaProfile::where('user_id', Auth::id())->first();

        if (!$profile || !$profile->isLengkap()) {
            return redirect()
                ->route('siswa.profile.index')
                ->with('error', 'Lengkapi profile terlebih dahulu sebelum mengajukan PKL.');
        }

        return $next($request);
    }
}
