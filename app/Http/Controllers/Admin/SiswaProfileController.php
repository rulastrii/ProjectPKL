<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;

class SiswaProfileController extends Controller
{
    public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;

    // Ambil list unik untuk dropdown filter
    $kelasList = SiswaProfile::select('kelas')
        ->whereNotNull('kelas')
        ->distinct()
        ->pluck('kelas');

    $jurusanList = SiswaProfile::select('jurusan')
        ->whereNotNull('jurusan')
        ->distinct()
        ->pluck('jurusan');

    $siswa = SiswaProfile::where('is_active', true)

        // SEARCH
        ->when($request->search, function ($q) use ($request) {
            $q->where('nama','like','%'.$request->search.'%')
              ->orWhere('nisn','like','%'.$request->search.'%');
        })

        // FILTER KELAS
        ->when($request->kelas, function ($q) use ($request) {
            $q->where('kelas', $request->kelas);
        })

        // FILTER JURUSAN
        ->when($request->jurusan, function ($q) use ($request) {
            $q->where('jurusan', $request->jurusan);
        })

        ->paginate($perPage)
        ->withQueryString();

    return view('admin.siswa.index', compact(
        'siswa','kelasList','jurusanList'
    ));
}



    public function show($id)
    {
        $siswa = SiswaProfile::with(['user','pengajuan'])
            ->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }
}
