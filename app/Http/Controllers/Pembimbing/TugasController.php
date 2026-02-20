<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaProfile;
use App\Models\Pembimbing;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use App\Models\TugasAssignee;

class TugasController extends Controller
{
    // Menampilkan semua tugas
    public function index(Request $request) {
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->whereNull('deleted_date')
            ->firstOrFail();

        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $tenggatFilter = $request->input('tenggat_filter');

        $query = Tugas::with('pembimbing')
            ->where('pembimbing_id', $pembimbing->id)
            ->where('is_active', 1);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($tenggatFilter) {
            $now = now();
            if ($tenggatFilter == 'today') {
                $query->whereDate('tenggat', $now->toDateString());
            } elseif ($tenggatFilter == '3days') {
                $query->whereBetween('tenggat', [$now, $now->copy()->addDays(3)]);
            } elseif ($tenggatFilter == '7days') {
                $query->whereBetween('tenggat', [$now, $now->copy()->addDays(7)]);
            }
        }

        $tugas = $query->orderBy('tenggat', 'asc')->paginate($perPage)->withQueryString();

        // Ambil semua siswa aktif untuk modal assign
        $siswa = SiswaProfile::where('is_active', 1)->get();

        return view('pembimbing.tugas.index', compact('tugas', 'siswa'));
    }

    // Menampilkan detail tugas
    public function show($id) {
        $tugas = Tugas::with('pembimbing')->findOrFail($id);

        return view('pembimbing.tugas.show', compact('tugas'));
    }


    // Form buat tugas baru
    public function create() {
        return view('pembimbing.tugas.create');
    }

    // Simpan tugas baru
    public function store(Request $request) {
        $request->validate([
            'judul'     => 'required|string',
            'deskripsi' => 'required|string',
            'tenggat'   => 'required|date',
            'status'    => 'nullable|in:pending,sudah dinilai',
        ]);

        //  Ambil pembimbing berdasarkan user login
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->whereNull('deleted_date')
            ->first();

        if (!$pembimbing) {
            abort(403, 'Akun ini bukan pembimbing.');
        }

        Tugas::create([
            'pembimbing_id' => $pembimbing->id, 
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'tenggat'       => $request->tenggat,
            'status'        => $request->status ?? 'pending',
            'is_active'     => 1,
            'created_id'    => auth()->id(),
            'created_date'  => now(),
        ]);

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil dibuat');
    }

    // Form edit tugas
    public function edit($id) {
        $tugas = Tugas::findOrFail($id);
        return view('pembimbing.tugas.edit', compact('tugas'));
    }

    // Update tugas
    public function update(Request $request, $id) {
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
            'updated_id'   => auth()->id(),
            'updated_date' => now(),
        ]);

        return redirect()
            ->route('pembimbing.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui');
    }


    // Hapus tugas
    public function destroy($id) {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();
        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil dihapus');
    }

    // Assign siswa ke tugas
    public function assignForm($id) {
        $tugas = Tugas::findOrFail($id);
        $siswa = SiswaProfile::where('is_active', 1)->get(); // semua peserta PKL/Magang aktif
        return view('pembimbing.tugas.assign', compact('tugas', 'siswa'));
    }

    public function assign(Request $request, $id) {
        $request->validate([
            'siswa_id' => 'required|array',
        ]);

        foreach ($request->siswa_id as $siswa_id) {
            TugasAssignee::updateOrCreate(
                ['tugas_id' => $id, 'siswa_id' => $siswa_id],
                ['is_active' => 1]
            );
        }

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil ditugaskan ke peserta');
    }

    
    // Lihat semua submit
    public function submissions(Request $request, $id)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $tugas = Tugas::with(['submits.siswa'])->findOrFail($id);

        // Filter search nama siswa
        $submits = $tugas->submits;
        if ($search) {
            $submits = $submits->filter(function($submit) use ($search) {
                return stripos($submit->siswa->nama, $search) !== false;
            });
        }

        // Pagination manual
        $submits = new \Illuminate\Pagination\LengthAwarePaginator(
            $submits->forPage($request->input('page', 1), $perPage),
            $submits->count(),
            $perPage,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pembimbing.tugas.submissions', compact('tugas', 'submits'));
    }


    // Form menilai
    public function gradeForm($submit_id) {
        $submit = TugasSubmit::with('siswa')->findOrFail($submit_id);
        return view('pembimbing.tugas.grade', compact('submit'));
    }


    public function grade(Request $request, $submit_id) {
        $request->validate([
            'skor' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
            'status' => 'required|in:pending,sudah dinilai'
        ]);

        $submit = TugasSubmit::findOrFail($submit_id);
        $submit->update([
            'skor' => $request->skor,
            'feedback' => $request->feedback,
            'status' => $request->status,
            'updated_id' => auth()->id(),
            'updated_date' => now()
        ]);

        // Opsional: auto-update status tugas jika semua submit sudah dinilai
        $tugas = $submit->tugas;
        if ($tugas->submits()->where('status', 'pending')->count() == 0) {
            $tugas->update(['status' => 'sudah dinilai']);
        }

        return redirect()->back()->with('success', 'Tugas berhasil dinilai.');
    }

}