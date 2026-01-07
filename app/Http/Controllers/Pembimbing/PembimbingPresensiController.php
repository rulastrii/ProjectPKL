<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Carbon\Carbon;

class PembimbingPresensiController extends Controller
{
    public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;
    $search  = $request->search;
    $pembimbingUserId = Auth::id();

    $query = Presensi::with('siswa')
        ->where('is_active', 1)
        ->whereHas('siswa', function ($s) use ($pembimbingUserId) {
            $s->where(function ($q) use ($pembimbingUserId) {
                $q->whereHas('pembimbingPkl', function ($p) use ($pembimbingUserId) {
                    $p->where('user_id', $pembimbingUserId);
                })
                ->orWhereHas('pembimbingMahasiswa', function ($p) use ($pembimbingUserId) {
                    $p->where('user_id', $pembimbingUserId);
                });
            });
        });

    if ($request->filled('tanggal')) {
        $query->where('tanggal', $request->tanggal);
    }

    if ($search) {
        $query->whereHas('siswa', function ($s) use ($search, $pembimbingUserId) {
            $s->where(function ($q) use ($pembimbingUserId) {
                $q->whereHas('pembimbingPkl', fn($p) => $p->where('user_id', $pembimbingUserId))
                  ->orWhereHas('pembimbingMahasiswa', fn($p) => $p->where('user_id', $pembimbingUserId));
            })
            ->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        });
    }

    $presensi = $query->orderBy('jam_masuk', 'asc')
        ->paginate($perPage)
        ->withQueryString();

    return view('pembimbing.verifikasi-presensi.index', compact('presensi'));
}


   public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:hadir,izin,sakit,absen'
    ]);

    $pembimbingUserId = Auth::id();

    $presensi = Presensi::whereHas('siswa', function ($s) use ($pembimbingUserId) {
        $s->where(function ($q) use ($pembimbingUserId) {
            $q->whereHas('pembimbingPkl', fn($p) => $p->where('user_id', $pembimbingUserId))
              ->orWhereHas('pembimbingMahasiswa', fn($p) => $p->where('user_id', $pembimbingUserId));
        });
    })->findOrFail($id);

    if ($request->status === 'hadir' && !$presensi->jam_masuk) {
        return back()->with('error', 'Tidak bisa verifikasi HADIR tanpa absen masuk.');
    }

    if ($presensi->tanggal != date('Y-m-d')) {
        return back()->with('error', 'Presensi hanya bisa diverifikasi di hari yang sama.');
    }

    $presensi->update([
        'status'       => $request->status,
        'updated_id'   => Auth::id(),
        'updated_date' => Carbon::now()
    ]);

    return back()->with('success', 'Presensi berhasil diverifikasi.');
}


}