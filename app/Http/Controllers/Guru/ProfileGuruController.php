<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileGuru;

class ProfileGuruController extends Controller
{
    /* =========================
     * INDEX
     * ========================= */
    public function index() {
        $data = ProfileGuru::active()
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json($data);
    }

    /* =========================
     * STORE
     * ========================= */
    public function store(Request $request) {
        $request->validate([
            'nip'                => 'required|string|max:20|unique:profile_guru,nip',
            'nama_lengkap'       => 'required|string|max:100',
            'tanggal_lahir'      => 'required|date',
            'unit_kerja'         => 'required|string|max:100',
            'email_resmi'        => 'required|email|unique:profile_guru,email_resmi',
            'no_hp'              => 'nullable|string|max:20',
        ]);

        $guru = ProfileGuru::create([
            'nip'                => $request->nip,
            'nama_lengkap'       => $request->nama_lengkap,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'unit_kerja'         => $request->unit_kerja,
            'email_resmi'        => $request->email_resmi,
            'no_hp'              => $request->no_hp,

            // sistem
            'jabatan'            => 'guru',
            'status_kepegawaian' => 'aktif',
            'is_active'          => true,

            // audit
            'created_date'       => now(),
            'created_id'         => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Data guru berhasil ditambahkan',
            'data'    => $guru
        ], 201);
    }

    /* =========================
     * SHOW
     * ========================= */
    public function show($id) {
        $guru = ProfileGuru::active()->findOrFail($id);

        return response()->json($guru);
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function update(Request $request, $id) {
        $guru = ProfileGuru::active()->findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'unit_kerja'    => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        $guru->update([
            'nama_lengkap' => $request->nama_lengkap,
            'unit_kerja'   => $request->unit_kerja,
            'no_hp'        => $request->no_hp,

            // audit
            'updated_date' => now(),
            'updated_id'   => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Data guru berhasil diperbarui',
            'data'    => $guru
        ]);
    }

    /* =========================
     * DELETE (SOFT)
     * ========================= */
    public function destroy($id) {
        $guru = ProfileGuru::active()->findOrFail($id);

        $guru->update([
            'is_active'    => false,
            'deleted_date' => now(),
            'deleted_id'   => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Data guru berhasil dihapus'
        ]);
    }

}