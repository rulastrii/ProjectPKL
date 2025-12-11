<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanSiswaController extends Controller
{
    // Tampilkan daftar / status pengajuan
    public function index(Request $request)
{
    $query = PengajuanPklmagang::with('sekolah')
        ->where('created_id', auth()->id());

    if ($request->search) {
        $query->where(function($q) use ($request){
            $q->where('no_surat', 'like', '%'.$request->search.'%')
              ->orWhereHas('sekolah', function($q2) use ($request){
                  $q2->where('nama', 'like', '%'.$request->search.'%');
              });
        });
    }

    $perPage = $request->per_page ?? 10;
    $pengajuan = $query->orderByDesc('created_date')->paginate($perPage);

    return view('siswa.pengajuan.index', compact('pengajuan'));
}


    // Tampilkan form pengajuan
    public function create()
    {
        $sekolah = Sekolah::all();
        return view('siswa.pengajuan.create', compact('sekolah'));
    }

    // Simpan pengajuan baru
    // Simpan pengajuan baru
public function store(Request $request)
{
    $request->validate([
        'sekolah_id' => 'required|exists:sekolah,id',
        'jumlah_siswa' => 'required|integer|min:1',
        'periode_mulai' => 'required|date',
        'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        'file_surat' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $filePath = null;
    if($request->hasFile('file_surat')){
        $file = $request->file('file_surat');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/surat'), $fileName);
        $filePath = 'uploads/surat/'.$fileName;
    }

    PengajuanPklmagang::create([
        'sekolah_id' => $request->sekolah_id,
        'jumlah_siswa' => $request->jumlah_siswa,
        'periode_mulai' => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
        'file_surat_path' => $filePath,
        'status' => 'draft',
        'created_id' => Auth::id(),
        'created_date' => now(),
    ]);

    return redirect()->route('siswa.pengajuan.index')->with('success','Pengajuan berhasil dibuat!');
}


    // Edit pengajuan (hanya draft)
    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);
        if($pengajuan->status != 'draft') abort(403);
        $sekolah = Sekolah::all();
        return view('siswa.pengajuan.edit', compact('pengajuan','sekolah'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanPklmagang::findOrFail($id);
        if($pengajuan->status != 'draft') abort(403);

        $request->validate([
            'sekolah_id' => 'required|exists:sekolah,id',
            'jumlah_siswa' => 'required|integer|min:1',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if($request->hasFile('file_surat')){
    // Hapus file lama jika ada
    if($pengajuan->file_surat_path && file_exists(public_path($pengajuan->file_surat_path))){
        unlink(public_path($pengajuan->file_surat_path));
    }

    $file = $request->file('file_surat');
    $fileName = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('uploads/surat'), $fileName);
    $pengajuan->file_surat_path = 'uploads/surat/'.$fileName;
}


        $pengajuan->update([
            'sekolah_id' => $request->sekolah_id,
            'jumlah_siswa' => $request->jumlah_siswa,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'updated_id' => Auth::id(),
            'updated_date' => now(),
        ]);

        return redirect()->route('siswa.pengajuan.index')->with('success','Pengajuan berhasil diupdate!');
    }
}
