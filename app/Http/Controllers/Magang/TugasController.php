<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\TugasSubmit;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Daftar tugas yang ditugaskan ke siswa yang login
   public function index(Request $request)
{
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

public function show($id)
{
    $siswa_id = auth()->user()->siswaProfile->id;

    $tugas = Tugas::with(['submits' => function($q) use ($siswa_id) {
        $q->where('siswa_id', $siswa_id);
    }])->findOrFail($id);

    return view('magang.tugas.show', compact('tugas'));
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
    $request->validate(
        [
            'catatan' => 'nullable|string',

            // salah satu WAJIB
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240|required_without:link_lampiran',
            'link_lampiran' => 'nullable|url|required_without:file',
        ],
        [
            // custom error message (biar rapi)
            'file.required_without' => 'Upload file atau isi link lampiran.',
            'link_lampiran.required_without' => 'Upload file atau isi link lampiran.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
            'link_lampiran.url' => 'Link lampiran harus berupa URL yang valid.',
        ]
    );

    $filePath = null;

    if ($request->hasFile('file')) {
    $file = $request->file('file');
    $filename = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->move(public_path('uploads/tugas'), $filename);
    // simpan path relatif untuk database
    $filePath = 'uploads/tugas/' . $filename;
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
            'status'        => 'pending',
            'is_active'     => 1,
            'created_date'  => now(),
            'created_id'    => auth()->id(),
        ]
    );

    return redirect()
        ->route('magang.tugas.index')
        ->with('success', 'Tugas berhasil dikumpulkan');
}

}
