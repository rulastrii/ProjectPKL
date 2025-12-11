<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;

class PengajuanPklmagangController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->search;
        $status   = $request->status;
        $per_page = $request->per_page ?? 10;

        // ambil pengajuan, paginasi
        $pengajuan = PengajuanPklmagang::whereNull('deleted_date')
            ->when($search, function($q) use ($search){
                $q->where('no_surat','like',"%$search%")
                  ->orWhere('catatan','like',"%$search%");
            })
            ->when($status, function($q) use ($status){
                $q->where('status', $status);
            })
            ->paginate($per_page)
            ->appends($request->query());

        // kirim juga daftar sekolah (dipakai di modal create/edit)
        $sekolahs = Sekolah::whereNull('deleted_date')->get();

        return view('admin.pengajuan.index', compact('pengajuan','sekolahs'));
    }

    public function create()
    {
        // kalau ada view terpisah untuk create modal/page, kirim sekolah
        $sekolahs = Sekolah::whereNull('deleted_date')->get();
        return view('admin.pengajuan.create', compact('sekolahs'));
    }

   public function store(Request $request)
{
    $request->validate([
        'sekolah_id' => 'required|exists:sekolah,id',
        'jumlah_siswa' => 'required|integer',
        'periode_mulai' => 'required|date',
        'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        'file_surat_path' => 'nullable|mimes:pdf|max:2048'
    ]);

    $fileName = null;
    if ($request->hasFile('file_surat_path')) {
        $file = $request->file('file_surat_path');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/surat/'), $fileName); // ⬅ langsung public
    }

    PengajuanPklmagang::create([
        'no_surat' => $request->no_surat,
        'tgl_surat' => $request->tgl_surat,
        'sekolah_id' => $request->sekolah_id,
        'jumlah_siswa' => $request->jumlah_siswa,
        'periode_mulai' => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
        'file_surat_path' => $fileName, // simpan nama file
        'catatan' => $request->catatan,
        'created_date'=>now(),
        'created_id'=>Auth::id(),
        'status'=>'draft',
        'is_active'=> true,
    ]);

    return redirect()->route('admin.pengajuan.index')->with('success','Pengajuan berhasil dibuat');
}


    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);
        $sekolahs = Sekolah::whereNull('deleted_date')->get();
        return view('admin.pengajuan.edit', compact('pengajuan','sekolahs'));
    }

    public function update(Request $request,$id)
{
    $pengajuan = PengajuanPklmagang::findOrFail($id);

    if ($request->hasFile('file_surat_path')) {
        $file = $request->file('file_surat_path');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/surat/'), $fileName);
        
        // hapus file lama jika ada
        if ($pengajuan->file_surat_path && file_exists(public_path('uploads/surat/'.$pengajuan->file_surat_path))) {
            unlink(public_path('uploads/surat/'.$pengajuan->file_surat_path));
        }
        $pengajuan->file_surat_path = $fileName;
    }

    $pengajuan->update($request->except('file_surat_path') + [
        'updated_date'=>now(),
        'updated_id'=>Auth::id(),
    ]);

    return redirect()->route('admin.pengajuan.index')->with('success','Pengajuan berhasil diupdate');
}


    public function destroy($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);
        $pengajuan->update([
            'deleted_date'=>now(),
            'deleted_id'=>Auth::id()
        ]);

        return back()->with('success','Pengajuan berhasil dihapus');
    }
}
