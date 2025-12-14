<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\Sekolah;
use App\Models\SiswaProfile;
use Illuminate\Support\Facades\Auth;

class PengajuanSiswaController extends Controller
{
    /**
     * List Pengajuan Siswa
     */
    public function index(Request $request)
    {
        $query = PengajuanPklmagang::with('sekolah')
            ->where('created_id', Auth::id());

        // Filter Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('no_surat', 'like', '%' . $request->search . '%')
                  ->orWhereHas('sekolah', function($q2) use ($request) {
                      $q2->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $pengajuan = $query->orderByDesc('created_date')->paginate($perPage);
        $pengajuan->appends($request->all());

        return view('siswa.pengajuan.index', compact('pengajuan'));
    }

    /**
     * Detail Pengajuan
     */
    public function detail($id)
    {
        $pengajuan = PengajuanPklmagang::with('sekolah')->findOrFail($id);

        // Cek pemilik
        if ($pengajuan->created_id != Auth::id()) {
            abort(403);
        }

        return view('siswa.pengajuan.detail', compact('pengajuan'));
    }

    /**
     * Form Create Pengajuan
     */
    public function create()
    {
        // BATAS: hanya boleh 1 pengajuan aktif
        $pengajuanAktif = PengajuanPklmagang::where('created_id', Auth::id())
            ->whereIn('status', ['draft', 'proses'])
            ->first();

        if ($pengajuanAktif) {
            return redirect()
                ->route('siswa.pengajuan.index')
                ->with('error', 'Anda masih memiliki pengajuan yang belum selesai.');
        }

        $sekolah = Sekolah::all();
        return view('siswa.pengajuan.create', compact('sekolah'));
    }

    /**
     * Store Pengajuan Baru
     */
    public function store(Request $request)
{
    $request->validate([
        'sekolah_id' => 'required|exists:sekolah,id',
        'jumlah_siswa' => 'required|integer|min:1',
        'periode_mulai' => 'required|date',
        'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        'file_surat' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    // Upload file surat
    $filePath = null;
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/surat'), $fileName);
        $filePath = 'uploads/surat/' . $fileName;
    }

    // SIMPAN KE VARIABEL
    $pengajuan = PengajuanPklmagang::create([
        'sekolah_id'      => $request->sekolah_id,
        'jumlah_siswa'    => $request->jumlah_siswa,
        'periode_mulai'   => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
        'file_surat_path' => $filePath,
        'status'          => 'draft',
        'created_id'      => Auth::id(),
        'created_date'    => now(),
    ]);

    // UPDATE siswa_profile
    SiswaProfile::where('user_id', auth()->id())
        ->update([
            'pengajuan_id' => $pengajuan->id,
            'updated_date' => now(),
            'updated_id'   => auth()->id(),
        ]);

    return redirect()->route('siswa.pengajuan.index')
        ->with('success', 'Pengajuan berhasil dibuat!');
}

    /**
     * Edit Draft Pengajuan
     */
    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);

        if ($pengajuan->status !== 'draft') {
            abort(403);
        }

        $sekolah = Sekolah::all();
        return view('siswa.pengajuan.edit', compact('pengajuan', 'sekolah'));
    }

    /**
     * Update Draft Pengajuan
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);

        if ($pengajuan->status !== 'draft') {
            abort(403);
        }

        $request->validate([
            'sekolah_id' => 'required|exists:sekolah,id',
            'jumlah_siswa' => 'required|integer|min:1',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Replace file
        if ($request->hasFile('file_surat')) {
            if ($pengajuan->file_surat_path && file_exists(public_path($pengajuan->file_surat_path))) {
                unlink(public_path($pengajuan->file_surat_path));
            }

            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $fileName);
            $pengajuan->file_surat_path = 'uploads/surat/' . $fileName;
        }

        $pengajuan->update([
            'sekolah_id'      => $request->sekolah_id,
            'jumlah_siswa'    => $request->jumlah_siswa,
            'periode_mulai'   => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'updated_id'      => Auth::id(),
            'updated_date'    => now(),
        ]);

        return redirect()->route('siswa.pengajuan.index')
            ->with('success', 'Pengajuan berhasil diupdate!');
    }
}
