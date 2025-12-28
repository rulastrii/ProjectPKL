<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    // Tampilkan daftar sekolah
    public function index(Request $request) {
        $search   = $request->search;
        $is_active = $request->is_active; // bisa 0,1 atau null
        $per_page = $request->per_page ?? 10;

        $sekolahs = Sekolah::whereNull('deleted_date')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                    ->orWhere('npsn', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%");
                });
            })
            ->when($is_active !== null, function ($q) use ($is_active) {
                $q->where('is_active', $is_active);
            })
            ->paginate($per_page)
            ->appends($request->query());

        return view('admin.sekolah.index', compact('sekolahs'));
    }

    public function show($id) {
        // Ambil data sekolah berdasarkan ID
        $sekolah = Sekolah::findOrFail($id); // akan 404 jika tidak ditemukan

        // Kirim data ke view
        return view('admin.sekolah.show', compact('sekolah'));
    }

    // Form tambah sekolah
    public function create() {
        return view('admin.sekolah.create');
    }

    // Simpan sekolah baru
    public function store(Request $request) {
        $request->validate([
            'nama'   => 'required|string|max:150',
            'npsn'   => 'nullable|string|max:50|unique:sekolah,npsn',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:100',
        ]);

        Sekolah::create([
            'nama'         => $request->nama,
            'npsn'         => $request->npsn,
            'alamat'       => $request->alamat,
            'kontak'       => $request->kontak,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    // Form edit sekolah
    public function edit($id) {
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    // Update sekolah
    public function update(Request $request, $id) {
        $sekolah = Sekolah::findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:150',
            'npsn'   => 'nullable|string|max:50|unique:sekolah,npsn,' . $sekolah->id,
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $sekolah->update([
            'nama'         => $request->nama,
            'npsn'         => $request->npsn,
            'alamat'       => $request->alamat,
            'kontak'       => $request->kontak,
            'is_active'    => $request->is_active,
            'updated_date' => now(),
            'updated_id'   => Auth::id(),
        ]);

        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    // Hapus sekolah (soft delete)
    public function destroy($id) {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->deleted_date = now();
        $sekolah->deleted_id = Auth::id();
        $sekolah->save();

        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil dihapus.');
    }

}