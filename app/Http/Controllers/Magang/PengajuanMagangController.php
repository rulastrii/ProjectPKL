<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanMagangMahasiswa;

class PengajuanMagangController extends Controller
{
    /**
     * Form daftar magang
     */
    public function create()
    {
        return view('magang.daftar');
    }

    /**
     * Simpan pengajuan magang dari mahasiswa
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_mahasiswa'  => 'required|string|max:100',
        'email_mahasiswa' => 'required|email',
        'universitas'     => 'required|string|max:150',
        'jurusan'         => 'nullable|string|max:100',
        'periode_mulai'   => 'required|date',
        'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        'file_surat_path' => 'required|file|mimes:pdf|max:2048',
        'catatan'         => 'nullable|string',
    ]);

    $filePath = null;
    if ($request->hasFile('file_surat_path')) {
        $file = $request->file('file_surat_path');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/surat'), $filename);
        $filePath = 'uploads/surat/'.$filename;
    }

    PengajuanMagangMahasiswa::create([
        'nama_mahasiswa'  => $request->nama_mahasiswa,
        'email_mahasiswa' => $request->email_mahasiswa,
        'universitas'     => $request->universitas,
        'jurusan'         => $request->jurusan,
        'periode_mulai'   => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
        'file_surat_path' => $filePath,
        'catatan'         => $request->catatan,
        'status'          => 'draft',
        'is_active'       => true,
        'created_date'    => now(),
    ]);

    return redirect()
        ->route('magang.daftar')
        ->with('success', 'Pengajuan magang berhasil dikirim. Silakan tunggu konfirmasi admin melalui email.');
}

}
