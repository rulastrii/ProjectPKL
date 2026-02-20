<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaProfile;

class MagangMahasiswaController extends Controller
{
    /**
     * LIST DATA MAGANG MAHASISWA
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;

       $siswa = SiswaProfile::with(['user','pengajuan'])
    ->whereHas('user', function ($q) {
        $q->where('role_id', 5); // MAHASISWA MAGANG
    })
    ->where('is_active', true)

    // SEARCH
    ->when($request->search, function ($q) use ($request) {
        $q->where('nama', 'like', '%'.$request->search.'%')
          ->orWhere('nim', 'like', '%'.$request->search.'%');
    })

    // FILTER STATUS
    ->when($request->status, function ($q) use ($request) {
        $q->whereHas('pengajuan', function ($qq) use ($request) {
            $qq->where('status', $request->status);
        });
    })

    ->orderBy('created_date', 'desc') // ⬅️ FIX
    ->paginate($perPage)
    ->withQueryString();

        return view('admin.magang-mahasiswa.index', compact('siswa'));
    }

    /**
     * DETAIL MAGANG MAHASISWA
     */
    public function show($id)
    {
        $siswa = SiswaProfile::with([
        'pengajuan.pembimbing.user'
    ])->findOrFail($id);


    // ambil penempatan (karena bukan relasi eloquent)
    $penempatan = $siswa->penempatan();

    return view('admin.magang-mahasiswa.show', compact('siswa', 'penempatan'));
}

}
