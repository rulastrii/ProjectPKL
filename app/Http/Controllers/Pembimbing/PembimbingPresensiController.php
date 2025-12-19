<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembimbingPresensiController extends Controller
{
    /**
     * R - List presensi peserta bimbingan
     */
    public function index(Request $request)
    {
        $tanggal  = $request->tanggal ?? date('Y-m-d');
        $perPage  = $request->per_page ?? 10;
        $search   = $request->search;

        $presensi = Presensi::with('siswa')
            ->where('tanggal', $tanggal)
            ->where('is_active', 1)
            ->when($search, function ($q) use ($search) {
                $q->whereHas('siswa', function ($s) use ($search) {
                    $s->where('nama', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                });
            })
            ->orderBy('jam_masuk', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pembimbing.verifikasi-presensi.index', [
            'presensi' => $presensi,
            'tanggal'  => $tanggal
        ]);
    }

    /**
     * R - Detail presensi (opsional)
     */
    public function show($id)
    {
        $presensi = Presensi::with('siswa')->findOrFail($id);

        return view('pembimbing.verifikasi-presensi.show', [
            'presensi' => $presensi
        ]);
    }

    /**
     * U - Verifikasi / update status presensi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,absen'
        ]);

        $presensi = Presensi::findOrFail($id);

        // hanya boleh diverifikasi di hari yang sama
        if ($presensi->tanggal != date('Y-m-d')) {
            return redirect()
                ->back()
                ->with('error', 'Presensi hanya bisa diverifikasi di hari yang sama');
        }

        $presensi->update([
            'status'       => $request->status,
            'updated_id'   => Auth::id(),
            'updated_date' => Carbon::now()
        ]);

        return redirect()
            ->back()
            ->with('success', 'Presensi berhasil diverifikasi');
    }
}
