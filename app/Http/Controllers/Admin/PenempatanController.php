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
                'bidang'
            ])
            ->whereNull('deleted_date')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('pengajuan.siswaProfile', function ($s) use ($search) {
                    $s->where('nama', 'like', "%$search%");
                })
                ->orWhereHas('bidang', function ($b) use ($search) {
                    $b->where('nama', 'like', "%$search%");
                });
            })
            ->when($is_active !== null, fn ($q) => $q->where('is_active', $is_active))
            ->paginate($per_page)
            ->appends($request->query());

        // 🔥 hanya pengajuan diterima & belum dihapus
        $pengajuan = PengajuanPklmagang::with('siswaProfile')
            ->where('status', 'diterima')
            ->whereNull('deleted_date')
            ->where('is_active', true)
            ->get();

        $bidang = Bidang::whereNull('deleted_date')
            ->where('is_active', true)
            ->get();

        return view('admin.penempatan.index', compact(
            'penempatan',
            'pengajuan',
            'bidang'
        ));
    }

    // ===============================
    // STORE
    // ===============================
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
