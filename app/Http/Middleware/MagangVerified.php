<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PengajuanMagangMahasiswa;

class MagangVerified
{
    public function handle(Request $request, Closure $next) {
        $user = auth()->user();

        // Belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Harus role mahasiswa magang
        if ($user->role_id != 5) {
            abort(403, 'Akses ditolak');
        }

        // Cek pengajuan magang
        $pengajuan = PengajuanMagangMahasiswa::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->whereNull('deleted_date')
            ->first();

        if (!$pengajuan || !$user->is_active) {
            return redirect()->route('login')
                ->with('error', 'Akun magang belum diverifikasi admin');
        }

        return $next($request);
    }

}