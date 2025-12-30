<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklSiswa;

class SiswaPklController extends Controller
{
    /**
     * Tampilkan daftar siswa PKL milik guru login
     */
    public function index(Request $request)
{
    $guruId = auth()->id();

    $perPage = $request->get('per_page', 10);
    $search  = $request->get('search');

    $siswa = PengajuanPklSiswa::with(['pengajuan.sekolah'])
        ->whereHas('pengajuan', function ($q) use ($guruId) {
            $q->where('created_id', $guruId);
        })
        ->when($search, function ($q) use ($search) {
            $q->where('nama_siswa', 'like', "%{$search}%")
              ->orWhere('email_siswa', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate($perPage)
        ->withQueryString();

    return view('guru.siswa.index', compact('siswa'));
}


    /**
     * Detail siswa (optional)
     */
    public function show($id)
    {
        $guruId = auth()->id();

        $siswa = PengajuanPklSiswa::with(['siswaProfile', 'pengajuan'])
            ->where('id', $id)
            ->whereHas('pengajuan', function ($q) use ($guruId) {
                $q->where('created_id', $guruId);
            })
            ->firstOrFail();

        return view('guru.siswa.show', compact('siswa'));
    }
}
