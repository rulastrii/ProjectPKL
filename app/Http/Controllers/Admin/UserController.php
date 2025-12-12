<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index(Request $request)
{
    $search   = $request->search;
    $role     = $request->role;
    $per_page = $request->per_page ?? 10;

    $users = User::whereNull('deleted_date')
        ->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        })
        ->when($role, function ($q) use ($role) {
            $q->where('role_id', $role);
        })
        ->paginate($per_page)
        ->appends($request->query()); // agar parameter tetap ada saat pindah halaman

    $roles = Role::all();

    return view('admin.users.index', compact('users','roles'));
}

public function show($id)
{
    $user = User::with(['role', 'creator.role', 'updater.role', 'deleter.role'])->findOrFail($id);
    return response()->json($user);
}


    // Form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password, // hash otomatis via mutator
            'role_id'      => $request->role_id,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
            'is_active'=> 'required|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = $request->password; // hash otomatis via mutator
        }
        $user->role_id = $request->role_id;
        $user->is_active = $request->is_active;
        $user->updated_date = now();
        $user->updated_id = Auth::id();
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user (soft delete)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->deleted_date = now();
        $user->deleted_id = Auth::id();
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
