<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use App\Models\Aktivitas;
use Illuminate\Support\Facades\Auth;

class SiswaTugasController extends Controller
{
    // Daftar tugas yang ditugaskan ke siswa PKL
    public function index(Request $request) {
        $siswa_id = Auth::user()->siswaProfile->id;

        $search   = $request->search;
        $per_page = $request->per_page ?? 10;
        $status   = $request->status;
        $tenggat  = $request->tenggat;

        $tugas = Tugas::whereHas('tugasAssignees', function ($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            })
            ->with(['submits' => function ($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            }])
            ->when($search, function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            })
            ->when($status, function ($q) use ($status, $siswa_id) {
                $q->whereHas('submits', function ($qs) use ($status, $siswa_id) {
                    $qs->where('siswa_id', $siswa_id)
                       ->where('status', $status);
                });
            })
            ->when($tenggat, function ($q) use ($tenggat) {
                $q->whereDate('tenggat', $tenggat);
            })
            ->orderBy('tenggat', 'asc')
            ->paginate($per_page)
            ->appends($request->query());

        return view('siswa.tugas.index', compact('tugas'));
    }

    // Detail tugas
    public function show($id) {
        $siswa_id = Auth::user()->siswaProfile->id;

        $tugas = Tugas::with(['submits' => function($q) use ($siswa_id) {
            $q->where('siswa_id', $siswa_id);
        }])->findOrFail($id);

        return view('siswa.tugas.show', compact('tugas'));
    }

    // Form submit tugas
    public function submitForm($id) {
        $siswa = Auth::user()->siswaProfile;

        $tugas = Tugas::with(['submits' => function ($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        }])->findOrFail($id);

        $submit = $tugas->submits->first();

        return view('siswa.tugas.submit', compact('tugas', 'submit'));
    }

    // Simpan submit tugas
    public function submit(Request $request, $id) {
        $request->validate([
            'catatan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240|required_without:link_lampiran',
            'link_lampiran' => 'nullable|url|required_without:file',
        ], [
            'file.required_without' => 'Upload file atau isi link lampiran.',
            'link_lampiran.required_without' => 'Upload file atau isi link lampiran.',
        ]);

        $siswa = Auth::user()->siswaProfile;
        $tugas = Tugas::findOrFail($id);

        $existingSubmit = TugasSubmit::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $isUpdate = $existingSubmit !== null;

        $filePath = $existingSubmit?->file;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tugas'), $filename);
            $filePath = 'uploads/tugas/' . $filename;
        }

        $submit = TugasSubmit::updateOrCreate([
            'tugas_id' => $tugas->id,
            'siswa_id' => $siswa->id,
        ], [
            'catatan'       => $request->catatan,
            'file'          => $filePath,
            'link_lampiran' => $request->link_lampiran,
            'submitted_at'  => now(),
            'status'        => 'pending',
            'is_active'     => 1,
            'updated_id'    => $siswa->user_id,
            'updated_date'  => now(),
        ]);

        Aktivitas::create([
            'pegawai_id' => null,
            'siswa_id'   => $siswa->id,
            'nama'       => $siswa->nama,
            'aksi'       => $isUpdate
                ? 'memperbarui tugas ' . $tugas->judul
                : 'mengumpulkan tugas ' . $tugas->judul,
            'sumber'     => 'tugas',
            'ref_id'     => $submit->id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('siswa.tugas.index')
            ->with('success', $isUpdate
                ? 'Tugas berhasil diperbarui'
                : 'Tugas berhasil dikumpulkan'
            );
    }
}
