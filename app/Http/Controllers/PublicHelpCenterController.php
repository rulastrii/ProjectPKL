<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountRecoveryRequest;

class PublicHelpCenterController extends Controller
{
    // tampilkan halaman pusat bantuan
    public function index()
    {
        return view('help-center.index');
    }

    // simpan permintaan
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email',
            'reason' => 'required|min:10',
        ]);

        AccountRecoveryRequest::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'reason' => $request->reason,
        ]);

        return back()->with(
            'success',
            'Permintaan berhasil dikirim. Tim akan menghubungi Anda.'
        );
    }
}
