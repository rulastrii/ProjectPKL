<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Daftar tugas yang ditugaskan ke siswa yang login
    public function index()
    {
        $siswa_id = auth()->user()->siswaProfile->id;
        $tugas = Tugas::whereHas('tugasAssignees', function ($q) use ($siswa_id) {
            $q->where('siswa_id', $siswa_id);
        })->get();

        return view('magang.tugas.index', compact('tugas'));
    }

    // Form submit tugas
    public function submitForm($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('magang.tugas.submit', compact('tugas'));
    }

    // Simpan submit tugas
    public function submit(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB
            'link_lampiran' => 'nullable|url',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tugas_files', 'public');
        }

        TugasSubmit::updateOrCreate(
    [
        'tugas_id' => $id,
        'siswa_id' => auth()->user()->siswaProfile->id,
    ],
    [
        'catatan'       => $request->catatan,
        'file'          => $filePath,
        'link_lampiran' => $request->link_lampiran,
        'submitted_at'  => now(),
        'status'        => 'pending', // ✅ SESUAI ENUM
        'is_active'     => 1,
        'created_date'  => now(),
        'created_id'    => auth()->id(),
    ]
);

        return redirect()->route('magang.tugas.index')->with('success', 'Tugas berhasil dikumpulkan');
    }
}
