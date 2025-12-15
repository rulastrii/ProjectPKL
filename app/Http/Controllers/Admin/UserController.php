<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AdminCreateUserVerification;

class UserController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request)
{
    $search   = $request->search;
    $role     = $request->role;
    $verified = $request->verified;
    $per_page = $request->per_page ?? 10;

    $users = User::whereNull('deleted_date')
        ->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%$search%")
                   ->orWhere('email', 'like', "%$search%");
            });
        })
        ->when($role, function ($q) use ($role) {
            $q->where('role_id', $role);
        })
        ->when($verified !== null && $verified !== '', function ($q) use ($verified) {
            if ($verified == '1') {
                $q->whereNotNull('email_verified_at');
            } else {
                $q->whereNull('email_verified_at');
            }
        })
        ->paginate($per_page)
        ->appends($request->query());

    $roles = Role::all();

    return view('admin.users.index', compact('users','roles'));
}


    public function show($id)
    {
        $user = User::with(['role', 'creator.role', 'updater.role', 'deleter.role'])->findOrFail($id);
        return response()->json($user);
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        return view('admin.users.create');
    }

    // =====================
    // STORE (ADMIN CREATE USER)
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        // simpan password asli untuk email
        $plainPassword = $request->password;

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $plainPassword, // di-hash via mutator
            'role_id'      => (int) $request->role_id,
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        // kirim email versi ADMIN
        $user->notify(new AdminCreateUserVerification($plainPassword));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan & email verifikasi dikirim.');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'role_id'   => 'nullable|exists:roles,id',
            'is_active' => 'required|boolean',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->role_id      = $request->role_id;
        $user->is_active    = $request->is_active;
        $user->updated_date = now();
        $user->updated_id   = Auth::id();
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    // =====================
    // DELETE (SOFT)
    // =====================
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->deleted_date = now();
        $user->deleted_id   = Auth::id();
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    // =====================
    // KIRIM ULANG VERIFIKASI
    // =====================
    public function sendVerify(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User sudah terverifikasi.');
        }

        // kirim ulang email versi ADMIN (tanpa password)
        $user->notify(new AdminCreateUserVerification(null));

        return back()->with('success', 'Email verifikasi berhasil dikirim.');
    }
}
