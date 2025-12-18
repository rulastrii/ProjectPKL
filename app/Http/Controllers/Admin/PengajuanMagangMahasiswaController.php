<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanMagangMahasiswa;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PengajuanMagangStatusNotification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PengajuanMagangMahasiswaController extends Controller
{
    /**
     * List Pengajuan Magang Mahasiswa
     */
    public function index(Request $request)
{
    $search      = $request->search;
    $status      = $request->status;
    $universitas = $request->universitas;
    $per_page    = $request->per_page ?? 10;

    $pengajuan = PengajuanMagangMahasiswa::whereNull('deleted_date')

        ->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('nama_mahasiswa', 'like', "%$search%")
                   ->orWhere('email_mahasiswa', 'like', "%$search%");
            });
        })

        ->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        })

        ->when($universitas, function ($q) use ($universitas) {
            $q->where('universitas', $universitas);
        })

        ->orderByDesc('created_date')
        ->paginate($per_page)
        ->appends($request->query());

    // data dropdown
    $listUniversitas = PengajuanMagangMahasiswa::whereNull('deleted_date')
        ->select('universitas')
        ->distinct()
        ->orderBy('universitas')
        ->pluck('universitas');

    return view('admin.pengajuan-magang.index', compact(
        'pengajuan',
        'listUniversitas'
    ));
}

    /**
     * Detail Pengajuan
     */
    public function show($id)
    {
        $pengajuan = PengajuanMagangMahasiswa::findOrFail($id);
        return view('admin.pengajuan-magang.show', compact('pengajuan'));
    }

    /**
     * Form Create
     */
    public function create()
    {
        return view('admin.pengajuan-magang.create');
    }

    /**
     * Simpan Pengajuan Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa'  => 'required|string|max:100',
            'email_mahasiswa' => 'required|email|unique:pengajuan_magang_mahasiswa,email_mahasiswa',
            'universitas'     => 'required|string|max:150',
            'jurusan'         => 'nullable|string|max:100',
            'periode_mulai'   => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'no_surat'        => 'nullable|string|max:50',
            'tgl_surat'       => 'nullable|date',
            'file_surat_path' => 'nullable|file|mimes:pdf|max:2048',
            'catatan'         => 'nullable|string',
            'status'          => 'nullable|in:draft,diproses,diterima,ditolak,selesai',
        ]);

        // === UPLOAD FILE KE PUBLIC ===
        $filename = null;
        if ($request->hasFile('file_surat_path')) {
            $file = $request->file('file_surat_path');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $filename);
        }

        PengajuanMagangMahasiswa::create([
            'nama_mahasiswa'  => $request->nama_mahasiswa,
            'email_mahasiswa' => $request->email_mahasiswa,
            'universitas'     => $request->universitas,
            'jurusan'         => $request->jurusan,
            'periode_mulai'   => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'no_surat'        => $request->no_surat,
            'tgl_surat'       => $request->tgl_surat,
            'file_surat_path' => $filename, // SIMPAN NAMA FILE SAJA
            'catatan'         => $request->catatan,
            'status'          => $request->status ?? 'draft',
            'is_active'       => false,
            'created_date'    => now(),
            'created_id'      => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pengajuan-magang.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $pengajuan = PengajuanMagangMahasiswa::findOrFail($id);
        return view('admin.pengajuan-magang.edit', compact('pengajuan'));
    }

    /**
     * Update Pengajuan
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanMagangMahasiswa::findOrFail($id);

        $request->validate([
            'nama_mahasiswa'  => 'required|string|max:100',
            'email_mahasiswa' => 'required|email|unique:pengajuan_magang_mahasiswa,email_mahasiswa,' . $id,
            'universitas'     => 'required|string|max:150',
            'jurusan'         => 'nullable|string|max:100',
            'periode_mulai'   => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'no_surat'        => 'nullable|string|max:50',
            'tgl_surat'       => 'nullable|date',
            'file_surat_path' => 'nullable|file|mimes:pdf|max:2048',
            'catatan'         => 'nullable|string',
            'status'          => 'required|in:draft,diproses,diterima,ditolak,selesai',
        ]);

        // === UPDATE FILE SURAT ===
        if ($request->hasFile('file_surat_path')) {

            // hapus file lama
            if ($pengajuan->file_surat_path) {
                $oldFile = public_path('uploads/surat/'.$pengajuan->file_surat_path);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('file_surat_path');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $filename);

            $pengajuan->file_surat_path = $filename;
        }

        $pengajuan->update([
            'nama_mahasiswa'  => $request->nama_mahasiswa,
            'email_mahasiswa' => $request->email_mahasiswa,
            'universitas'     => $request->universitas,
            'jurusan'         => $request->jurusan,
            'periode_mulai'   => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'no_surat'        => $request->no_surat,
            'tgl_surat'       => $request->tgl_surat,
            'catatan'         => $request->catatan,
            'status'          => $request->status,
            'updated_date'    => now(),
            'updated_id'      => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pengajuan-magang.index')
            ->with('success', 'Pengajuan berhasil diupdate.');
    }

    /**
     * Soft Delete
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanMagangMahasiswa::findOrFail($id);

        $pengajuan->update([
            'deleted_date' => now(),
            'deleted_id'   => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function approve(PengajuanMagangMahasiswa $pengajuan)
{
    $pengajuan->update([
        'status'        => 'diterima',
        'approved_id'   => auth()->id(),
        'approved_date' => now(),
    ]);

    // Email pemberitahuan SAJA
    $pengajuan->notify(
        new PengajuanMagangStatusNotification('diterima')
    );

    return back()->with('success', 'Pengajuan diterima. Silakan buat akun magang.');
}

public function reject(Request $request, PengajuanMagangMahasiswa $pengajuan)
{
    $request->validate([
        'reason' => 'required|string|max:255'
    ]);

    $pengajuan->update([
        'status'        => 'ditolak',
        'reject_reason' => $request->reason,
        'rejected_id'   => auth()->id(),
        'rejected_date' => now(),
    ]);

    $pengajuan->notify(
        new PengajuanMagangStatusNotification('ditolak', $request->reason)
    );

    return back()->with('success', 'Pengajuan magang ditolak dan email dikirim.');
}

}
