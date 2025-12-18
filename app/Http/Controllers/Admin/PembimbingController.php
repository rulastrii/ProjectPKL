<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Pegawai;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanMagangMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    // ==========================
    // INDEX
    // ==========================
    public function index(Request $request)
{
    $search   = $request->search;
    $per_page = $request->per_page ?? 10;
    $tahun    = $request->tahun;

    $pembimbing = Pembimbing::with(['pegawai','pengajuan'])
        ->whereNull('deleted_date')
        ->when($search, function ($q) use ($search) {
            $q->whereHas('pegawai', fn($q)=>$q->where('nama','like',"%$search%"))
              ->orWhereHasMorph(
                    'pengajuan',
                    [PengajuanPklmagang::class, PengajuanMagangMahasiswa::class],
                    fn($q)=>$q->where('no_surat','like',"%$search%")
              );
        })
        ->when($tahun, fn($q)=>$q->where('tahun',$tahun))
        ->orderBy('id','desc')
        ->paginate($per_page)
        ->appends($request->query());

    return view('admin.pembimbing.index', [
        'pembimbing' => $pembimbing,
        'pegawai'    => Pegawai::whereNull('deleted_date')->get(),
        'tahunList'  => Pembimbing::select('tahun')
                            ->whereNotNull('tahun')
                            ->groupBy('tahun')
                            ->orderBy('tahun','desc')
                            ->get(),

        //  TAMBAHKAN INI
        'pkl'        => PengajuanPklmagang::with('sekolah')->get(),
        'mahasiswa' => PengajuanMagangMahasiswa::all(),
    ]);
}


    // ==========================
    // CREATE
    // ==========================
    public function create()
    {
        return view('admin.pembimbing.create', [
            'pegawai'    => Pegawai::whereNull('deleted_date')->get(),
            'pkl'        => PengajuanPklmagang::with('sekolah')->get(),
            'mahasiswa' => PengajuanMagangMahasiswa::all(),
        ]);
    }

    // ==========================
    // STORE
    // ==========================
    public function store(Request $request)
{
    $request->validate([
        'pengajuan_key' => 'required|string',
        'pegawai_id'    => 'required|exists:pegawai,id',
        'tahun'         => 'nullable|integer',
    ]);

    [$type, $id] = explode(':', $request->pengajuan_key);

    $map = [
        'pkl' => PengajuanPklmagang::class,
        'mhs' => PengajuanMagangMahasiswa::class,
    ];

    if (!isset($map[$type])) {
        abort(400, 'Invalid pengajuan');
    }

    $exists = Pembimbing::where([
        'pengajuan_id'   => $id,
        'pengajuan_type' => $map[$type],
        'pegawai_id'     => $request->pegawai_id,
    ])->whereNull('deleted_date')->exists();

    if ($exists) {
        return back()->with('warning','Pembimbing sudah terdaftar!');
    }

    Pembimbing::create([
        'pengajuan_id'   => $id,
        'pengajuan_type' => $map[$type],
        'pegawai_id'     => $request->pegawai_id,
        'tahun'          => $request->tahun,
        'is_active'      => 1,
        'created_id'     => auth()->id(),
        'created_date'   => now(),
    ]);

    return redirect()->route('admin.pembimbing.index')
        ->with('success','Pembimbing berhasil ditambahkan');
}


    // ==========================
    // SHOW
    // ==========================
    public function show($id)
    {
        $pembimbing = Pembimbing::with(['pegawai','pengajuan'])->findOrFail($id);
        return view('admin.pembimbing.show', compact('pembimbing'));
    }

    // ==========================
    // EDIT
    // ==========================
    public function edit(Pembimbing $pembimbing)
    {
        return view('admin.pembimbing.edit', [
            'pembimbing' => $pembimbing,
            'pegawai'    => Pegawai::whereNull('deleted_date')->get(),
            'pkl'        => PengajuanPklmagang::all(),
            'mahasiswa'  => PengajuanMagangMahasiswa::all(),
        ]);
    }

    // ==========================
    // UPDATE
    // ==========================
    public function update(Request $request, Pembimbing $pembimbing)
{
    $request->validate([
        'pengajuan_key' => 'required|string',
        'pegawai_id'    => 'required|exists:pegawai,id',
        'tahun'         => 'nullable|integer',
    ]);

    [$type, $id] = explode(':', $request->pengajuan_key);

    $map = [
        'pkl' => PengajuanPklmagang::class,
        'mhs' => PengajuanMagangMahasiswa::class,
    ];

    $pembimbing->update([
        'pengajuan_id'   => $id,
        'pengajuan_type' => $map[$type],
        'pegawai_id'     => $request->pegawai_id,
        'tahun'          => $request->tahun,
        'is_active'      => $request->is_active,
        'updated_id'     => auth()->id(),
        'updated_date'   => now(),
    ]);

    return redirect()->route('admin.pembimbing.index')
        ->with('success','Pembimbing berhasil diperbarui');
}


    // ==========================
    // DELETE
    // ==========================
    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->update([
            'deleted_id'   => Auth::id(),
            'deleted_date' => now(),
        ]);

        return redirect()->route('admin.pembimbing.index')
            ->with('success','Pembimbing berhasil dihapus');
    }
}
