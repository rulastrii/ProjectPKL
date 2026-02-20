<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Penempatan;
use App\Models\PengajuanPklSiswa;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\Bidang;

class PenempatanController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index(Request $request)
    {
        $search    = $request->search;
        $is_active = $request->is_active;
        $per_page  = $request->per_page ?? 10;

        $penempatan = Penempatan::with([
                'pengajuan.siswaProfile',
                'pengajuan', // mahasiswa / pkl siswa
                'bidang'
            ])
            ->whereNull('deleted_date')
            ->when($search, function ($q) use ($search) {
                $q->whereHasMorph(
                    'pengajuan',
                    [PengajuanPklSiswa::class, PengajuanMagangMahasiswa::class],
                    function ($p) use ($search) {
                        $p->where('nama_siswa', 'like', "%$search%")
                          ->orWhere('nama_mahasiswa', 'like', "%$search%");
                    }
                )
                ->orWhereHas('bidang', function ($b) use ($search) {
                    $b->where('nama', 'like', "%$search%");
                });
            })
            ->when($is_active !== null, fn ($q) => $q->where('is_active', $is_active))
            ->paginate($per_page)
            ->appends($request->query());

        /**
         * ===============================
         * DATA UNTUK MODAL CREATE
         * ===============================
         */

        // PKL → ambil dari pengajuan_pkl_siswa
        $pengajuanPkl = PengajuanPklSiswa::with(['siswaProfile'])
            ->where('status', 'diterima')
            ->get()
            ->map(function ($p) {
                return [
                    'id'    => $p->id,
                    'nama'  => $p->siswaProfile->nama ?? $p->nama_siswa,
                    'email' => $p->siswaProfile->email ?? $p->email_siswa,
                ];
            });

        // Mahasiswa
        $pengajuanMahasiswa = PengajuanMagangMahasiswa::where('status', 'diterima')
            ->whereNull('deleted_date')
            ->where('is_active', true)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'nama_mahasiswa'  => $m->nama_mahasiswa,
                    'email_mahasiswa' => $m->email_mahasiswa,
                ];
            });

        $bidang = Bidang::whereNull('deleted_date')
            ->where('is_active', true)
            ->get();

        return view('admin.penempatan.index', compact(
            'penempatan',
            'pengajuanPkl',
            'pengajuanMahasiswa',
            'bidang'
        ));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
    'pengajuan_id'   => ['required'],
    'pengajuan_type' => [
        'required',
        Rule::in([
            \App\Models\PengajuanPklSiswa::class,
            \App\Models\PengajuanMagangMahasiswa::class,
        ]),
    ],
    'bidang_id' => ['required', 'exists:bidang,id'],
]);


        $pengajuanModel = $request->pengajuan_type;

        $pengajuan = $pengajuanModel::findOrFail($request->pengajuan_id);

        Penempatan::create([
            'pengajuan_id'   => $pengajuan->id,
            'pengajuan_type' => $pengajuanModel,
            'bidang_id'      => $request->bidang_id,
            'created_date'   => now(),
            'created_id'     => Auth::id(),
            'is_active'      => true,
        ]);

        return redirect()
            ->route('admin.penempatan.index')
            ->with('success', 'Penempatan berhasil ditambahkan');
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $penempatan = Penempatan::findOrFail($id);

        $request->validate([
            'pengajuan_id'   => 'required',
            'pengajuan_type' => 'required|in:
                App\Models\PengajuanPklSiswa,
                App\Models\PengajuanMagangMahasiswa',
            'bidang_id'      => 'required|exists:bidang,id',
            'is_active'      => 'required|boolean',
        ]);

        $pengajuanModel = $request->pengajuan_type;
        $pengajuan = $pengajuanModel::findOrFail($request->pengajuan_id);

        $penempatan->update([
            'pengajuan_id'   => $pengajuan->id,
            'pengajuan_type' => $pengajuanModel,
            'bidang_id'      => $request->bidang_id,
            'is_active'      => $request->is_active,
            'updated_date'   => now(),
            'updated_id'     => Auth::id(),
        ]);

        return redirect()
            ->route('admin.penempatan.index')
            ->with('success', 'Penempatan berhasil diperbarui');
    }

    // ===============================
    // DELETE (SOFT)
    // ===============================
    public function destroy($id)
    {
        $penempatan = Penempatan::findOrFail($id);

        $penempatan->update([
            'deleted_date' => now(),
            'deleted_id'   => Auth::id(),
        ]);

        return redirect()
            ->route('admin.penempatan.index')
            ->with('success', 'Penempatan berhasil dihapus');
    }
}
