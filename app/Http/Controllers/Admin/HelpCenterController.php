<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccountRecoveryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HelpCenterController extends Controller
{
    // LIST PERMINTAAN
    public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;
    $search  = $request->search;

    $requests = AccountRecoveryRequest::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        })
        ->latest()
        ->paginate($perPage)
        ->appends($request->query());

    return view('admin.help.index', compact('requests'));
}


    // DETAIL
    public function show(AccountRecoveryRequest $help)
{
    return view('admin.help.show', compact('help'));
}

    // RESET BLOKIR USER
    

public function unblock(AccountRecoveryRequest $help)
{
    $user = User::where('email', $help->email)->first();

    if ($user) {
        $user->update([
            'is_active' => true,
            'failed_login_attempts' => 0,
        ]);
    }

    $help->update([
        'status'     => 'approved', // ✅ sesuai ENUM
        'admin_note' => 'Akun dibuka oleh admin',
        'handled_by' => auth()->id(),
        'handled_at' => now(),
    ]);

    return redirect()
        ->route('admin.help.index')
        ->with('success', 'Akun berhasil dibuka & permintaan disetujui.');
}

}

