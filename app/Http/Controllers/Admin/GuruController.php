<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileGuru;

class GuruController extends Controller
{
    /**
     * List semua guru
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;

        $gurus = ProfileGuru::active()
            ->with('user')
            ->when($request->search, function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                  ->orWhere('email_resmi', 'like', '%'.$request->search.'%')
                  ->orWhere('nip', 'like', '%'.$request->search.'%');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Detail guru
     */
    public function show($id)
    {
        $guru = ProfileGuru::with('user')->findOrFail($id);

        return view('admin.guru.show', compact('guru'));
    }
}
