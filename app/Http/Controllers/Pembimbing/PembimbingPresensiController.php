<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Carbon\Carbon;

class PembimbingPresensiController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->per_page ?? 10;
        $search  = $request->search;

        $query = Presensi::with('siswa')
            ->where('is_active', 1);

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($search) {
            $query->whereHas('siswa', function ($s) use ($search) {
                $s->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $presensi = $query->orderBy('jam_masuk', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pembimbing.verifikasi-presensi.index', compact('presensi'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,absen'
        ]);

        $presensi = Presensi::findOrFail($id);

        // TIDAK BOLEH HADIR TANPA JAM MASUK
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