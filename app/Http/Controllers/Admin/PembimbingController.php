<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Pegawai;
use App\Models\PengajuanPklMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    // LIST + SEARCH + PAGINATION
public function index(Request $request)
{
    $search   = $request->search;
    $per_page = $request->per_page ?? 10;
    $tahun    = $request->tahun; // 🔥 ambil request tahun

    $pembimbing = Pembimbing::with(['pengajuan.sekolah','pegawai'])
        ->whereNull('deleted_date')
        ->when($search, function($q) use ($search){
            $q->whereHas('pegawai', fn($q)=>$q->where('nama','like',"%$search%"))
              ->orWhereHas('pengajuan', fn($q)=>$q->where('no_surat','like',"%$search%"));
        })
        ->when($tahun, function($q) use ($tahun){      // 🔥 Filter tahun
            $q->where('tahun', $tahun);
        })
        ->orderBy('id','desc')
        ->paginate($per_page)
        ->appends($request->query());

    $pengajuan = PengajuanPklMagang::with('sekolah')->get();
    $pegawai   = Pegawai::whereNull('deleted_date')->get();

    // 🔥 menyiapkan pilihan tahun unik dari tabel pembimbing
    $tahunList = Pembimbing::select('tahun')
                ->whereNotNull('tahun')
                ->groupBy('tahun')
                ->orderBy('tahun','desc')
                ->get();

    return view('admin.pembimbing.index', compact('pembimbing','pengajuan','pegawai','tahunList'));
}


    // FORM CREATE
    public function create()
    {
        $pengajuan = PengajuanPklMagang::with('sekolah')->get();
        $pegawai   = Pegawai::all();
        return view('admin.pembimbing.create', compact('pengajuan','pegawai'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_pklmagang,id',
            'pegawai_id'   => 'required|exists:pegawai,id',
            'tahun'        => 'nullable|integer',
        ]);

        // Cek duplikasi
        if (Pembimbing::where('pengajuan_id',$request->pengajuan_id)
                      ->where('pegawai_id',$request->pegawai_id)
                      ->whereNull('deleted_date')
                      ->exists()) {
            return back()->with('warning','Pembimbing sudah terdaftar pada pengajuan ini!');
        }

        Pembimbing::create([
            'pengajuan_id' => $request->pengajuan_id,
            'pegawai_id'   => $request->pegawai_id,
            'tahun'        => $request->tahun,
            'is_active'    => $request->is_active ?? 1,
            'created_id'   => Auth::id(),
            'created_date' => now(),
        ]);

        return redirect()->route('admin.pembimbing.index')->with('success','Pembimbing berhasil ditambahkan');
    }

    // EDIT
    public function edit(Pembimbing $pembimbing)
    {
        $pengajuan = PengajuanPklMagang::all();
        $pegawai   = Pegawai::all();

        return view('admin.pembimbing.edit', compact('pembimbing','pengajuan','pegawai'));
    }

    // UPDATE
    public function update(Request $request, Pembimbing $pembimbing)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_pklmagang,id',
            'pegawai_id'   => 'required|exists:pegawai,id',
            'tahun'        => 'nullable|integer',
        ]);

        // Cek duplikasi kecuali record ini
        if (Pembimbing::where('pengajuan_id',$request->pengajuan_id)
                      ->where('pegawai_id',$request->pegawai_id)
                      ->where('id','!=',$pembimbing->id)
                      ->whereNull('deleted_date')
                      ->exists()) {
            return back()->with('warning','Pembimbing ini sudah terdapat pada pengajuan tersebut!');
        }

        $pembimbing->update([
            'pengajuan_id' => $request->pengajuan_id,
            'pegawai_id'   => $request->pegawai_id,
            'tahun'        => $request->tahun,
            'is_active'    => $request->is_active ?? $pembimbing->is_active,
            'updated_id'   => Auth::id(),
            'updated_date' => now(),
        ]);

        return redirect()->route('admin.pembimbing.index')->with('success','Pembimbing berhasil diperbarui');
    }

    // SOFT DELETE
    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->update([
            'deleted_id'   => Auth::id(),
            'deleted_date' => now(),
        ]);

        return redirect()->route('admin.pembimbing.index')->with('success','Pembimbing berhasil dihapus');
    }
}
