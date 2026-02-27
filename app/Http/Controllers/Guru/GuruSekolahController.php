<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruSekolahController extends Controller
{
    /**
     * Tampilkan daftar sekolah
     */
    public function index()
{
    // Ambil profil guru login
    $guru = Auth::user()->guruProfile;

    if (!$guru || !$guru->sekolah) {
        // Guru belum punya sekolah terkait
        $sekolahs = collect(); // kosong
    } else {
        // Ambil sekolah lengkap sesuai nama di profil guru
        $sekolahs = Sekolah::where('nama', $guru->sekolah)->get();
    }

    return view('guru.sekolah.index', compact('sekolahs'));
}



    /**
     * Simpan sekolah baru (dari modal)
     */
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'npsn' => 'nullable|string|max:50',
        'alamat' => 'nullable|string|max:255',
        'kontak' => 'nullable|string|max:50',
    ]);

    $namaSekolah = trim($request->nama);

    // 1. Cek apakah nama sekolah sudah ada di tabel guru_profiles
    $existsInGuru = DB::table('guru_profiles')->where('sekolah', $namaSekolah)->exists();
    if ($existsInGuru) {
        return redirect()->back()->withInput()->withErrors([
            'nama' => 'Nama sekolah sudah ada di data guru, tidak bisa ditambahkan.'
        ]);
    }

    // 2. Cek apakah nama sekolah ada di master tabel sekolah
    $existsInMaster = Sekolah::where('nama', $namaSekolah)->exists();
    if (!$existsInMaster) {
        return redirect()->back()->withInput()->withErrors([
            'nama' => 'Nama sekolah tidak cocok dengan data master sekolah.'
        ]);
    }

    // Simpan sekolah baru
    $sekolah = Sekolah::create([
        'nama' => $namaSekolah,
        'npsn' => $request->npsn,
        'alamat' => $request->alamat,
        'kontak' => $request->kontak,
        'created_id' => Auth::id(),
        'created_date' => now(),
        'is_active' => 1,
    ]);

    // Jika request via AJAX, return JSON
    if ($request->ajax()) {
        return response()->json([
            'id' => $sekolah->id,
            'text' => $sekolah->nama,
        ]);
    }

    return redirect()->back()->with('success', 'Sekolah berhasil ditambahkan.');
}


    /**
     * Form edit sekolah
     */
    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        return view('guru.sekolah.edit', compact('sekolah'));
    }

    /**
     * Update sekolah
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'nama' => $request->nama,
            'npsn' => $request->npsn,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'updated_id' => Auth::id(),
            'updated_date' => now(),
        ]);

        return redirect()->route('guru.sekolah.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    /**
     * Hapus sekolah (soft delete)
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'is_active' => 0,
            'deleted_id' => Auth::id(),
            'deleted_date' => now(),
        ]);

        return redirect()->route('guru.sekolah.index')->with('success', 'Sekolah berhasil dihapus.');
    }

    /**
 * Tampilkan detail sekolah
 */
public function show($id)
{
    // Ambil sekolah sesuai ID
    $sekolah = Sekolah::findOrFail($id);

    // Cek apakah sekolah ini sesuai dengan sekolah guru yang login
    $guru = Auth::user()->guruProfile;
    if (!$guru || $guru->sekolah !== $sekolah->nama) {
        abort(403, 'Anda tidak berhak mengakses sekolah ini.');
    }

    return view('guru.sekolah.show', compact('sekolah'));
}

}
