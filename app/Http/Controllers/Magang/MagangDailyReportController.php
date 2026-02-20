<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyReport;
use App\Models\Aktivitas;
use Carbon\Carbon;

class MagangDailyReportController extends Controller
{
    /**
     * R - List laporan harian milik magang
     */
    public function index(Request $request) {
        $perPage = $request->per_page ?? 10;

        $reports = DailyReport::with('siswa')
            ->where('is_active', 1)
            ->where('created_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('magang.daily-report.index', compact('reports'));
    }

    /**
     * C - Form buat laporan
     */
    public function create() {
        $siswa = Auth::user()->siswaProfile;

        if (!$siswa || !$siswa->isLengkap()) {
            abort(403, 'Profil siswa belum lengkap. Lengkapi profil terlebih dahulu.');
        }

        return view('magang.daily-report.create', compact('siswa'));
    }

    /**
     * C - Simpan laporan
     */
    public function store(Request $request) {
        $siswa = Auth::user()->siswaProfile;

        if (!$siswa || !$siswa->isLengkap()) {
            abort(403, 'Profil siswa belum lengkap.');
        }

        $request->validate([
            'tanggal'   => 'required|date',
            'ringkasan' => 'required|string',
            'kendala'   => 'nullable|string',
            'screenshot'=> 'nullable|image|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/daily-report'), $filename);
        }

        $dailyReport = DailyReport::create([
            'siswa_id'     => $siswa->id,
            'tanggal'      => $request->tanggal,
            'ringkasan'    => $request->ringkasan,
            'kendala'      => $request->kendala,
            'screenshot'   => $filename,
            'created_id'   => Auth::id(),
            'created_date' => Carbon::now(),
            'is_active'    => 1,
        ]);

        $pembimbing = optional(
            $siswa->pengajuan->first()
        )->pembimbing->first();

        Aktivitas::create([
            'pegawai_id' => $pembimbing?->pegawai_id,
            'siswa_id'   => $siswa->id,
            'nama'       => $siswa->nama,
            'aksi'       => 'mengisi laporan harian',
            'sumber'     => 'laporan',
            'ref_id'     => $dailyReport->id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('magang.daily-report.index')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }

    /**
     * R - Detail laporan
     */
    public function show($id) {
        $report = DailyReport::with('siswa')
            ->where('id', $id)
            ->where('created_id', Auth::id())
            ->where('is_active', 1)
            ->firstOrFail();

        return view('magang.daily-report.show', compact('report'));
    }

    /**
     * U - Form edit laporan
     */
    public function edit($id) {
        $report = DailyReport::where('id', $id)
            ->where('created_id', Auth::id())
            ->where('is_active', 1)
            ->firstOrFail();

        if ($report->status_verifikasi) {
            abort(403, 'Laporan sudah diverifikasi dan tidak bisa diubah.');
        }

        return view('magang.daily-report.edit', compact('report'));
    }

    /**
     * U - Update laporan
     */
    public function update(Request $request, $id) {
        $report = DailyReport::where('id', $id)
            ->where('created_id', Auth::id())
            ->where('is_active', 1)
            ->firstOrFail();

        if ($report->status_verifikasi) {
            abort(403, 'Laporan sudah diverifikasi dan tidak bisa diubah.');
        }

        $request->validate([
            'ringkasan' => 'required|string',
            'kendala'   => 'nullable|string',
            'screenshot'=> 'nullable|image|max:2048',
        ]);

        $filename = $report->screenshot;

        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/daily-report'), $filename);
        }

        $report->update([
            'ringkasan'    => $request->ringkasan,
            'kendala'      => $request->kendala,
            'screenshot'   => $filename,
            'updated_id'   => Auth::id(),
            'updated_date' => Carbon::now(),
        ]);

        $pembimbing = optional(
            $report->siswa->pengajuan->first()
        )->pembimbing->first();

        Aktivitas::create([
            'pegawai_id' => $pembimbing?->pegawai_id,
            'siswa_id'   => $report->siswa_id,
            'nama'       => $report->siswa->nama,
            'aksi'       => 'memperbarui laporan harian',
            'sumber'     => 'laporan',
            'ref_id'     => $report->id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('magang.daily-report.index')
            ->with('success', 'Laporan harian berhasil diperbarui.');
    }

}