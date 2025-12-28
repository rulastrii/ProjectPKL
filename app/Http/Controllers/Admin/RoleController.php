<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Tampilkan daftar roles
    public function index(Request $request) {
        $search   = $request->search;
        $per_page = $request->per_page ?? 10;

        $roles = Role::when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
                })
                ->orderBy('id', 'asc')
                ->paginate($per_page)
                ->appends($request->query()); // agar parameter tetap ada saat pindah halaman

        return view('admin.roles.index', compact('roles'));
    }


    // Menampilkan form tambah role
    public function create() {
        return view('admin.roles.create');
    }

    // Simpan role baru
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    // Form edit role
    public function edit($id) {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    // Update role
    public function update(Request $request, $id) {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    // Hapus role
    public function destroy($id) {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

}