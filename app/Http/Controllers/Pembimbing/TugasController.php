<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\Pembimbing;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use App\Models\TugasAssignee;

class TugasController extends Controller
{
    /**
     * Menampilkan semua tugas pembimbing
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $tenggatFilter = $request->input('tenggat_filter');
        $pembimbingUserId = Auth::id();

        // Ambil data pembimbing login
        $pembimbing = Pembimbing::where('user_id', $pembimbingUserId)
            ->whereNull('deleted_date')
            ->firstOrFail();

        // Ambil tugas milik pembimbing login
        $query = Tugas::with('pembimbing')
            ->where('pembimbing_id', $pembimbing->id)
            ->where('is_active', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($tenggatFilter) {
            $now = now();
            if ($tenggatFilter === 'today') {
                $query->whereDate('tenggat', $now->toDateString());
            } elseif ($tenggatFilter === '3days') {
                $query->whereBetween('tenggat', [$now, $now->copy()->addDays(3)]);
            } elseif ($tenggatFilter === '7days') {
                $query->whereBetween('tenggat', [$now, $now->copy()->addDays(7)]);
            }
        }

        $tugas = $query
            ->orderBy('tenggat', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        /**
         * 🔑 Ambil HANYA siswa yang dibimbing oleh pembimbing login
         */
        $siswa = SiswaProfile::where('is_active', 1)
    ->where(function($q) use ($pembimbingUserId) {
        $q->whereHas('pembimbingPkl', fn($p) => $p->where('user_id', $pembimbingUserId))
          ->orWhereHas('pembimbingMahasiswa', fn($p) => $p->where('user_id', $pembimbingUserId));
    })
    ->with(['user', 'pengajuan', 'pengajuanPkl']) // ambil semua relasi
    ->get();

            

        return view('pembimbing.tugas.index', compact('tugas', 'siswa'));
    }

    /**
     * Detail tugas
     */
    public function show($id)
    {
        $tugas = Tugas::with('pembimbing')->findOrFail($id);
        return view('pembimbing.tugas.show', compact('tugas'));
    }

    /**
     * Form buat tugas
     */
    public function create()
    {
        return view('pembimbing.tugas.create');
    }

    /**
     * Simpan tugas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string',
            'deskripsi' => 'required|string',
            'tenggat'   => 'required|date',
            'status'    => 'nullable|in:pending,sudah dinilai',
        ]);

        $pembimbing = Pembimbing::where('user_id', Auth::id())
            ->whereNull('deleted_date')
            ->firstOrFail();

        Tugas::create([
            'pembimbing_id' => $pembimbing->id,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'tenggat'       => $request->tenggat,
            'status'        => $request->status ?? 'pending',
            'is_active'     => 1,
            'created_id'    => Auth::id(),
            'created_date'  => now(),
        ]);

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil dibuat');
    }

    /**
     * Edit tugas
     */
    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('pembimbing.tugas.edit', compact('tugas'));
    }

    /**
     * Update tugas
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string',
            'deskripsi' => 'required|string',
            'tenggat'   => 'required|date',
            'status'    => 'required|in:pending,sudah dinilai',
        ]);

        $tugas = Tugas::findOrFail($id);

        $tugas->update([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'tenggat'      => $request->tenggat,
            'status'       => $request->status,
            'updated_id'   => Auth::id(),
            'updated_date' => now(),
        ]);

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui');
    }

    /**
     * Hapus tugas
     */
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil dihapus');
    }

    /**
     * Form assign siswa ke tugas
     */
    public function assignForm($id)
    {
        $tugas = Tugas::findOrFail($id);
        $pembimbingUserId = Auth::id();

        $siswa = SiswaProfile::where('is_active', 1)
            ->where(function ($q) use ($pembimbingUserId) {
                $q->whereHas('pembimbingPkl', fn ($p) => $p->where('user_id', $pembimbingUserId))
                  ->orWhereHas('pembimbingMahasiswa', fn ($p) => $p->where('user_id', $pembimbingUserId));
            })
            ->with('user')
            ->get();

        return view('pembimbing.tugas.assign', compact('tugas', 'siswa'));
    }

    /**
     * Simpan assign siswa
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|array',
        ]);

        $pembimbingUserId = Auth::id();

        // Validasi siswa harus dalam bimbingan
        $validSiswaIds = SiswaProfile::where('is_active', 1)
            ->where(function ($q) use ($pembimbingUserId) {
                $q->whereHas('pembimbingPkl', fn ($p) => $p->where('user_id', $pembimbingUserId))
                  ->orWhereHas('pembimbingMahasiswa', fn ($p) => $p->where('user_id', $pembimbingUserId));
            })
            ->pluck('id')
            ->toArray();

        foreach ($request->siswa_id as $siswa_id) {
            if (!in_array($siswa_id, $validSiswaIds)) {
                abort(403, 'Tidak boleh assign siswa di luar bimbingan.');
            }

            TugasAssignee::updateOrCreate(
                ['tugas_id' => $id, 'siswa_id' => $siswa_id],
                ['is_active' => 1]
            );
        }

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil ditugaskan ke peserta');
    }

    /**
     * Lihat semua submit tugas
     */
    public function submissions(Request $request, $id)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $tugas = Tugas::with(['submits.siswa'])->findOrFail($id);
        $submits = $tugas->submits;

        if ($search) {
            $submits = $submits->filter(function ($submit) use ($search) {
                return stripos($submit->siswa->nama, $search) !== false;
            });
        }

        $submits = new \Illuminate\Pagination\LengthAwarePaginator(
            $submits->forPage($request->input('page', 1), $perPage),
            $submits->count(),
            $perPage,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pembimbing.tugas.submissions', compact('tugas', 'submits'));
    }

    /**
     * Form nilai tugas
     */
    public function gradeForm($submit_id)
    {
        $submit = TugasSubmit::with('siswa')->findOrFail($submit_id);
        return view('pembimbing.tugas.grade', compact('submit'));
    }

   
/**
 * Simpan nilai tugas (penalti 5% per hari telat)
 */
public function grade(Request $request, $submit_id)
{
    $request->validate([
        'skor'     => 'required|numeric|min:0|max:100',
        'feedback' => 'nullable|string',
    ]);

    // ================== AMANKAN SUBMIT ==================
    $submit = TugasSubmit::whereHas('tugas.pembimbing', function ($q) {
            $q->where('user_id', Auth::id());
        })
        ->with('tugas')
        ->findOrFail($submit_id);

    $tugas = $submit->tugas;

    // ================== HITUNG KETERLAMBATAN ==================
    $isLate      = false;
    $lateDays    = 0;
    $latePenalty = 0; // persen

    if ($submit->submitted_at && $tugas->tenggat) {
        if ($submit->submitted_at->gt($tugas->tenggat)) {
            $isLate   = true;
            $lateDays = max(
                1,
                $tugas->tenggat->diffInDays($submit->submitted_at)
            );

            // 🔥 ATURAN: 5% PER HARI
            $latePenalty = $lateDays * 5;

            // (OPSIONAL) BATAS MAKSIMAL PENALTI
            $latePenalty = min($latePenalty, 50); // max 50%
        }
    }

    // ================== HITUNG NILAI ==================
    $skorAwal  = $request->skor;
    $skorAkhir = $skorAwal;

    if ($isLate && $latePenalty > 0) {
        $skorAkhir -= ($skorAwal * $latePenalty / 100);
    }

    $skorAkhir = max(0, round($skorAkhir, 2));

    // ================== UPDATE SUBMIT ==================
    $submit->update([
        'skor'         => $skorAkhir,
        'feedback'     => $request->feedback,
        'status'       => 'sudah dinilai',

        // 🔄 SIMPAN DATA TELAT
        'is_late'      => $isLate,
        'late_days'    => $lateDays,
        'late_penalty' => $latePenalty,

        'updated_id'   => Auth::id(),
        'updated_date' => now(),
    ]);

    // ================== UPDATE STATUS TUGAS ==================
    if ($tugas->submits()->where('status', 'pending')->count() === 0) {
        $tugas->update(['status' => 'sudah dinilai']);
    }

    return back()->with('success', 'Tugas berhasil dinilai.');
}


}
