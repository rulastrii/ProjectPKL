<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklSiswa;
use App\Models\User;

class PklSiswaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;

        // Ambil data siswa PKL beserta pengajuan dan sekolah
        $siswa = PengajuanPklSiswa::with(['pengajuan.sekolah'])
            ->when($request->search, function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%'.$request->search.'%')
                  ->orWhere('email_siswa', 'like', '%'.$request->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.pkl-siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        // Ambil siswa PKL beserta pengajuan dan sekolah
        $siswa = PengajuanPklSiswa::with(['pengajuan.sekolah'])
            ->findOrFail($id);

        // Ambil guru yang mengajukan PKL dari email_guru
        $guru = null;
        if ($siswa->pengajuan) {
            $guru = User::where('email', $siswa->pengajuan->email_guru)
                        ->where('role_id', 3) // pastikan role guru
                        ->first();
        }

        return view('admin.pkl-siswa.show', compact('siswa', 'guru'));
    }
}
