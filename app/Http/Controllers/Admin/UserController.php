<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\AdminCreateUserVerification;
use App\Notifications\AdminGuruStatusNotification;
use App\Models\User;
use App\Models\Role;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\ProfileGuru;

class UserController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request) {
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


    public function show($id) {
        $user = User::with(['role', 'creator.role', 'updater.role', 'deleter.role'])->findOrFail($id);
        return response()->json($user);
    }

    // =====================
    // CREATE
    // =====================
    public function create() {
        return view('admin.users.create');
    }

    // =====================
    // STORE (ADMIN CREATE USER)
    // =====================
    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        // SIMPAN PASSWORD ASLI (UNTUK EMAIL)
        $plainPassword = $request->password;

        // BUAT USER
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $plainPassword, // akan di-hash oleh mutator
            'role_id'      => (int) $request->role_id,
            'force_change_password' => true, // wajib ganti password pertama kali
            'created_date' => now(),
            'created_id'   => Auth::id(),
            'is_active'    => true,
        ]);

        // HUBUNGKAN DENGAN PENGAJUAN MAGANG (JIKA ADA)
        PengajuanMagangMahasiswa::where('email_mahasiswa', $user->email)
            ->where('status', 'diterima')
            ->update([
                'user_id'   => $user->id,
                'is_active' => true,
        ]);

        // ==========================
        // LOGIKA EMAIL
        // ==========================

        // ROLE YANG PASSWORD-NYA DIKIRIM VIA EMAIL
        $rolesWithPassword = [2, 4, 5];
        // 4 = PKL
        // 5 = Magang
        // 2 = Pembimbing (sesuaikan jika beda)

        $passwordForEmail = in_array((int) $user->role_id, $rolesWithPassword)
            ? $plainPassword
            : null;

        // KIRIM EMAIL VERIFIKASI
        $user->notify(
            new AdminCreateUserVerification($passwordForEmail)
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan & email verifikasi dikirim.');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id) {
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
    public function destroy($id) {
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
    public function sendVerify(User $user) {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User sudah terverifikasi.');
        }

        // kirim ulang email versi ADMIN (tanpa password)
        $user->notify(new AdminCreateUserVerification(null));

        return back()->with('success', 'Email verifikasi berhasil dikirim.');
    }

    public function approveGuru(User $user) {
        DB::transaction(function () use ($user) {
            // Aktifkan akun user
            $user->is_active = true;
            $user->save();

            // Aktifkan profile guru
            $profile = ProfileGuru::where('user_id', $user->id)->first();
            if ($profile) {
                $profile->is_active = true;
                $profile->save();
            }
        });

        $user->notify(new AdminGuruStatusNotification('approved'));

        return back()->with('success', 'Guru telah di-approve dan notifikasi email dikirim.');
    }

    public function rejectGuru(Request $request, User $user) {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($user, $request) {
            // Nonaktifkan akun user dan simpan alasan
            $user->update([
                'is_active'     => false,
                'reject_reason' => $request->reason,
            ]);

            // Nonaktifkan profile guru jika ada
            $profile = ProfileGuru::where('user_id', $user->id)->first();
            if ($profile) {
                $profile->is_active = false;
                $profile->save();
            }
        });

        $user->notify(new AdminGuruStatusNotification('rejected', $request->reason));

        return back()->with('success', 'Guru ditolak dan notifikasi email dikirim.');
    }

    public function showChangePasswordForm() {
        return view('auth.change-password');
    }


    public function updatePassword(Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->password = $request->password; // pastikan password di-hash
        $user->force_change_password = false; // sudah ganti password
        $user->save();

        auth()->logout(); // logout user setelah ganti password

        return redirect()->route('login') // arahkan ke halaman login
            ->with('success', 'Password berhasil diubah. Silakan login menggunakan password baru.');
    }

}