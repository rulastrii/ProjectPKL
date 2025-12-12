<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bidang;
use Illuminate\Support\Facades\Auth;

class BidangController extends Controller
{
    // Tampilkan daftar bidang
    public function index(Request $request)
    {
        $search   = $request->search;
        $is_active = $request->is_active;
        $per_page = $request->per_page ?? 10;

        $bidangs = Bidang::whereNull('deleted_date')
            ->when($search, fn($q) => $q->where('nama', 'like', "%$search%")
                                        ->orWhere('kode', 'like', "%$search%"))
            ->when($is_active !== null, fn($q) => $q->where('is_active', $is_active))
            ->paginate($per_page)
            ->appends($request->query());

        return view('admin.bidang.index', compact('bidangs'));
    }

    // Menampilkan detail bidang
    public function show($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('admin.bidang.show', compact('bidang'));
    }

    // Form tambah bidang
    public function create()
    {
        return view('admin.bidang.create');
    }

    // Simpan bidang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'nullable|string|max:20',
        ]);

        Bidang::create([
            'nama'         => $request->nama,
            'kode'         => $request->kode,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil ditambahkan.');
    }

    // Form edit bidang
    public function edit($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('admin.bidang.edit', compact('bidang'));
    }

    // Update bidang
    public function update(Request $request, $id)
    {
        $bidang = Bidang::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        $bidang->nama = $request->nama;
        $bidang->kode = $request->kode;
        $bidang->is_active = $request->is_active;
        $bidang->updated_date = now();
        $bidang->updated_id = Auth::id();
        $bidang->save();

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil diperbarui.');
    }

    // Hapus bidang (soft delete)
    public function destroy($id)
    {
        $bidang = Bidang::findOrFail($id);
        $bidang->deleted_date = now();
        $bidang->deleted_id = Auth::id();
        $bidang->save();

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil dihapus.');
    }
}
