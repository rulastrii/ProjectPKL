<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\DailyReport;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    /**
     * Tampilkan daftar laporan harian untuk verifikasi
     */
    public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;
    $search  = $request->search;
    $pembimbingUserId = Auth::id();

    $query = DailyReport::with('siswa')
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
                $q->whereHas('pembimbingPkl', fn ($p) => $p->where('user_id', $pembimbingUserId))
                  ->orWhereHas('pembimbingMahasiswa', fn ($p) => $p->where('user_id', $pembimbingUserId));
            })
            ->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        });
    }

    $reports = $query->orderBy('tanggal', 'desc')
        ->paginate($perPage)
        ->withQueryString();

    return view('pembimbing.verifikasi-laporan.index', compact('reports'));
}


    /**
     * Verifikasi laporan harian
     */

    public function update(Request $request, $id)
{
    $request->validate([
        'status_verifikasi' => 'required|in:terverifikasi,ditolak'
    ]);

    $pembimbingUserId = Auth::id();

    $report = DailyReport::where('is_active', 1)
        ->whereHas('siswa', function ($s) use ($pembimbingUserId) {
            $s->where(function ($q) use ($pembimbingUserId) {
                $q->whereHas('pembimbingPkl', fn ($p) => $p->where('user_id', $pembimbingUserId))
                  ->orWhereHas('pembimbingMahasiswa', fn ($p) => $p->where('user_id', $pembimbingUserId));
            });
        })
        ->findOrFail($id);

    $report->update([
        'status_verifikasi' => $request->status_verifikasi,
        'updated_id'        => Auth::id(),
        'updated_date'      => Carbon::now()
    ]);

    return back()->with('success', 'Laporan berhasil diverifikasi.');
}

}