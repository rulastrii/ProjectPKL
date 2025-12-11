<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penempatan;
use App\Models\PengajuanPklmagang;
use App\Models\Bidang;
use Illuminate\Support\Facades\Auth;

class PenempatanController extends Controller
{
    // List data penempatan
    public function index(Request $request)
{
    $search    = $request->search;
    $is_active = $request->is_active;
    $per_page  = $request->per_page ?? 10;

    $penempatan = Penempatan::with(['pengajuan','bidang'])
        ->whereNull('deleted_date')
        ->when($search, fn($q) => 
            $q->whereHas('pengajuan', fn($p)=>$p->where('nama_siswa','like',"%$search%"))
              ->orWhereHas('bidang', fn($b)=>$b->where('nama','like',"%$search%"))
        )
        ->when($is_active !== null, fn($q)=>$q->where('is_active',$is_active))
        ->paginate($per_page)
        ->appends($request->query());

    // <-- Tambahkan fetch daftar pengajuan & bidang untuk modal create/edit
    $pengajuan = PengajuanPklmagang::whereNull('deleted_date')->where('is_active', true)->get();
    $bidang    = Bidang::whereNull('deleted_date')->where('is_active', true)->get();

    // kirim semua variabel ke view
    return view('admin.penempatan.index', compact('penempatan','pengajuan','bidang'));
}


    // Form tambah
    public function create()
    {
        $pengajuan = PengajuanPklmagang::where('is_active', true)->whereNull('deleted_date')->get();
        $bidang    = Bidang::where('is_active', true)->whereNull('deleted_date')->get();

        return view('admin.penempatan.create', compact('pengajuan','bidang'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_pklmagang,id',
            'bidang_id'    => 'required|exists:bidang,id',
        ]);

        Penempatan::create([
            'pengajuan_id' => $request->pengajuan_id,
            'bidang_id'    => $request->bidang_id,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('admin.penempatan.index')->with('success','Penempatan berhasil ditambahkan');
    }

    // Form edit
    public function edit($id)
    {
        $penempatan = Penempatan::findOrFail($id);
        $pengajuan  = PengajuanPklmagang::whereNull('deleted_date')->get();
        $bidang     = Bidang::whereNull('deleted_date')->get();

        return view('admin.penempatan.edit', compact('penempatan','pengajuan','bidang'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $penempatan = Penempatan::findOrFail($id);

        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_pklmagang,id',
            'bidang_id'    => 'required|exists:bidang,id',
            'is_active'    => 'required|boolean',
        ]);

        $penempatan->update([
            'pengajuan_id' => $request->pengajuan_id,
            'bidang_id'    => $request->bidang_id,
            'is_active'    => $request->is_active,
            'updated_date' => now(),
            'updated_id'   => Auth::id(),
        ]);

        return redirect()->route('admin.penempatan.index')->with('success','Penempatan berhasil diperbarui');
    }

    // Soft delete
    public function destroy($id)
    {
        $penempatan = Penempatan::findOrFail($id);
        $penempatan->deleted_date = now();
        $penempatan->deleted_id = Auth::id();
        $penempatan->save();

        return redirect()->route('admin.penempatan.index')->with('success','Penempatan berhasil dihapus');
    }
}
