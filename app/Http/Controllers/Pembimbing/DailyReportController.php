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
    public function index(Request $request) {
        $perPage = $request->per_page ?? 10;
        $search  = $request->search;

        $query = DailyReport::with('siswa')
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

        $reports = $query->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pembimbing.verifikasi-laporan.index', compact('reports'));
    }

    /**
     * Verifikasi laporan harian
     */

    public function update(Request $request, $id) {
        $request->validate([
            'status_verifikasi' => 'required|in:terverifikasi,ditolak'
        ]);

        $report = DailyReport::with('siswa')
            ->where('is_active', 1)
            ->findOrFail($id);

        $this->authorize('verify', $report);

        $report->update([
            'status_verifikasi' => $request->status_verifikasi,
            'updated_id'   => Auth::id(),
            'updated_date' => Carbon::now()
        ]);

        return back()->with('success', 'Laporan berhasil diverifikasi.');
    }

}