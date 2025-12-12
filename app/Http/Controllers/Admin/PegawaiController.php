<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bidang;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    // ==========================
    // Tampilkan daftar pegawai
    // ==========================
    public function index(Request $request)
    {
        $search    = $request->search;
        $bidang_id = $request->bidang_id;
        $is_active = $request->is_active;
        $per_page  = $request->per_page ?? 10;

        $pegawais = Pegawai::whereNull('deleted_date')
            ->when($search, fn($q) => $q->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhere('jabatan', 'like', "%$search%");
            }))
            ->when($bidang_id, fn($q) => $q->where('bidang_id', $bidang_id))
            ->when($is_active !== null, fn($q) => $q->where('is_active', $is_active))
            ->paginate($per_page)
            ->appends($request->query());

        $bidangs = Bidang::active()->get();

        return view('admin.pegawai.index', compact('pegawais', 'bidangs'));
    }

// Tampilkan detail pegawai
    public function show($id)
    {
        $pegawai = Pegawai::with(['bidang', 'user'])->findOrFail($id);
        return view('admin.pegawai.show', compact('pegawai'));
    }

    // ==========================
    // Form tambah pegawai
    // ==========================
    public function create()
    {
        $bidangs = Bidang::active()->get();
        return view('admin.pegawai.create', compact('bidangs'));
    }


    // ==========================
    // Simpan pegawai baru
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'nip'       => 'required|string|max:50|unique:pegawai,nip',
            'nama'      => 'required|string|max:100',
            'jabatan'   => 'nullable|string|max:100',
            'bidang_id' => 'nullable|exists:bidang,id',
        ]);

        Pegawai::create([
            'user_id'      => Auth::id(), // otomatis user yang login
            'nip'          => $request->nip,
            'nama'         => $request->nama,
            'jabatan'      => $request->jabatan,
            'bidang_id'    => $request->bidang_id,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }


    // ==========================
    // Form edit pegawai
    // ==========================
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $bidangs = Bidang::active()->get();

        return view('admin.pegawai.edit', compact('pegawai', 'bidangs'));
    }


    // ==========================
    // Update pegawai
    // ==========================
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nip'       => 'required|string|max:50|unique:pegawai,nip,' . $pegawai->id,
            'nama'      => 'required|string|max:100',
            'jabatan'   => 'nullable|string|max:100',
            'bidang_id' => 'nullable|exists:bidang,id',
            'is_active' => 'required|boolean',
        ]);

        $pegawai->update([
            'nip'          => $request->nip,
            'nama'         => $request->nama,
            'jabatan'      => $request->jabatan,
            'bidang_id'    => $request->bidang_id,
            'is_active'    => $request->is_active,
            'updated_date' => now(),
            'updated_id'   => Auth::id(),
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }


    // ==========================
    // Soft delete pegawai
    // ==========================
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $pegawai->update([
            'deleted_date' => now(),
            'deleted_id'   => Auth::id(),
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
