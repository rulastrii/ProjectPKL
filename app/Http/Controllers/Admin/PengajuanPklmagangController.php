<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;

class PengajuanPklmagangController extends Controller
{
    /**
     * List Pengajuan
     */
    public function index(Request $request)
    {
        $search   = $request->search;
        $status   = $request->status;
        $per_page = $request->per_page ?? 10;

        $pengajuan = PengajuanPklmagang::whereNull('deleted_date')
            ->when($search, function ($q) use ($search) {
                $q->where('no_surat', 'like', "%$search%")
                  ->orWhere('catatan', 'like', "%$search%");
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderByDesc('created_date')
            ->paginate($per_page)
            ->appends($request->query());

        $sekolahs = Sekolah::whereNull('deleted_date')->get();

        return view('admin.pengajuan.index', compact('pengajuan', 'sekolahs'));
    }

    /**
     * Detail Pengajuan
     */
    public function show($id)
    {
        $pengajuan = PengajuanPklmagang::with('sekolah')->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Form Create
     */
    public function create()
    {
        $sekolahs = Sekolah::whereNull('deleted_date')->get();
        return view('admin.pengajuan.create', compact('sekolahs'));
    }

    /**
     * Simpan Pengajuan Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat'         => 'required|string|max:100',
            'tgl_surat'        => 'required|date',
            'sekolah_id'       => 'required|exists:sekolah,id',
            'jumlah_siswa'     => 'required|integer|min:1',
            'periode_mulai'    => 'required|date',
            'periode_selesai'  => 'required|date|after_or_equal:periode_mulai',
            'file_surat_path'  => 'nullable|file|mimes:pdf|max:2048',
            'catatan'          => 'nullable|string',
            'status'           => 'nullable|string',
        ]);

        // Upload file
        $fileName = null;
        if ($request->hasFile('file_surat_path')) {
            $file = $request->file('file_surat_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat/'), $fileName);
        }

        PengajuanPklmagang::create([
            'no_surat'         => $request->no_surat,
            'tgl_surat'        => $request->tgl_surat,
            'sekolah_id'       => $request->sekolah_id,
            'jumlah_siswa'     => $request->jumlah_siswa,
            'periode_mulai'    => $request->periode_mulai,
            'periode_selesai'  => $request->periode_selesai,
            'file_surat_path'  => $fileName,
            'catatan'          => $request->catatan,
            'status'           => $request->status ?? 'draft',
            'is_active'        => true,
            'created_date'     => now(),
            'created_id'       => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibuat');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);
        $sekolahs = Sekolah::whereNull('deleted_date')->get();

        return view('admin.pengajuan.edit', compact('pengajuan', 'sekolahs'));
    }

    /**
     * Update Pengajuan
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);

        // VALIDASI WAJIB
        $request->validate([
            'no_surat'         => 'required|string|max:100',
            'tgl_surat'        => 'required|date',
            'sekolah_id'       => 'required|exists:sekolah,id',
            'jumlah_siswa'     => 'required|integer|min:1',
            'periode_mulai'    => 'required|date',
            'periode_selesai'  => 'required|date|after_or_equal:periode_mulai',
            'file_surat_path'  => 'nullable|file|mimes:pdf|max:2048',
            'catatan'          => 'nullable|string',
            'status'           => 'required|string',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file_surat_path')) {
            $file = $request->file('file_surat_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat/'), $fileName);

            // hapus file lama
            if ($pengajuan->file_surat_path && file_exists(public_path('uploads/surat/' . $pengajuan->file_surat_path))) {
                unlink(public_path('uploads/surat/' . $pengajuan->file_surat_path));
            }

            $pengajuan->file_surat_path = $fileName;
        }

        $pengajuan->update([
            'no_surat'        => $request->no_surat,
            'tgl_surat'       => $request->tgl_surat,
            'sekolah_id'      => $request->sekolah_id,
            'jumlah_siswa'    => $request->jumlah_siswa,
            'periode_mulai'   => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'catatan'         => $request->catatan,
            'status'          => $request->status,
            'updated_date'    => now(),
            'updated_id'      => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan berhasil diupdate');
    }

    /**
     * Soft Delete
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);

        $pengajuan->update([
            'deleted_date' => now(),
            'deleted_id'   => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan berhasil dihapus');
    }
}
