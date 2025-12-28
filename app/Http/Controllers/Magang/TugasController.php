<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use App\Models\Aktivitas;

class TugasController extends Controller
{
    // Daftar tugas yang ditugaskan ke siswa yang login
    public function index(Request $request) {
        $siswa_id = auth()->user()->siswaProfile->id;

        $search   = $request->search;
        $per_page = $request->per_page ?? 10;
        $status   = $request->status;
        $tenggat  = $request->tenggat;

        $tugas = Tugas::whereHas('tugasAssignees', function ($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            })
            //  AMBIL SUBMIT SISWA LOGIN
            ->with(['submits' => function ($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            }])

            ->when($search, function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            })

            //  FILTER STATUS DARI TUGAS_SUBMIT
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

        return view('magang.tugas.index', compact('tugas'));
    }

    public function show($id) {
        $siswa_id = auth()->user()->siswaProfile->id;

        $tugas = Tugas::with(['submits' => function($q) use ($siswa_id) {
            $q->where('siswa_id', $siswa_id);
        }])->findOrFail($id);

        return view('magang.tugas.show', compact('tugas'));
    }


    // Form submit tugas
    public function submitForm($id) {
        $siswa = auth()->user()->siswaProfile;

        $tugas = Tugas::with(['submits' => function ($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        }])->findOrFail($id);

        // ambil submit siswa (jika ada)
        $submit = $tugas->submits->first();

        return view('magang.tugas.submit', compact('tugas', 'submit'));
    }


    // Simpan submit tugas
    public function submit(Request $request, $id) {
        $request->validate(
            [
                'catatan' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240|required_without:link_lampiran',
                'link_lampiran' => 'nullable|url|required_without:file',
            ],
            [
                'file.required_without' => 'Upload file atau isi link lampiran.',
                'link_lampiran.required_without' => 'Upload file atau isi link lampiran.',
                'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
                'file.max' => 'Ukuran file maksimal 10 MB.',
                'link_lampiran.url' => 'Link lampiran harus berupa URL yang valid.',
            ]
        );

        // =========================
        // DATA DASAR
        // =========================
        $siswa = auth()->user()->siswaProfile;
        $tugas = Tugas::findOrFail($id);

        // =========================
        // CEK EXISTING SUBMIT
        // =========================
        $existingSubmit = TugasSubmit::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $isUpdate = $existingSubmit !== null;

        // =========================
        // UPLOAD FILE
        // =========================
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tugas'), $filename);
            $filePath = 'uploads/tugas/' . $filename;
        }

        // =========================
        // SIMPAN / UPDATE SUBMIT
        // =========================
        $submit = TugasSubmit::updateOrCreate([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
            ],
            [
                'catatan'       => $request->catatan,
                'file'          => $filePath ?? $existingSubmit?->file,
                'link_lampiran' => $request->link_lampiran,
                'submitted_at'  => now(),
                'status'        => 'pending',
                'is_active'     => 1,
                'updated_id'    => auth()->id(),
                'updated_date'  => now(),
            ]);


        // =========================
        // AMBIL PEMBIMBING (AMAN)
        // =========================
        $pembimbing = optional(
            $siswa->pengajuan->first()
        )->pembimbing->first();

        // =========================
        // SIMPAN AKTIVITAS
        // =========================
        Aktivitas::create([
            'pegawai_id' => $pembimbing?->pegawai_id,
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
        ->route('magang.tugas.index')
        ->with('success', $isUpdate 
            ? 'Tugas berhasil diperbarui' 
            : 'Tugas berhasil dikumpulkan'
        );

    }

}