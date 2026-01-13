<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruProfile;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;

        $gurus = GuruProfile::with('user')
            ->when($request->search, function ($q) use ($request) {
                $q->where('sekolah', 'like', '%'.$request->search.'%')
                  ->orWhere('nip', 'like', '%'.$request->search.'%')
                  ->orWhereHas('user', function ($u) use ($request) {
                      $u->where('name', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%');
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function show($id)
    {
        $guru = GuruProfile::with('user')->findOrFail($id);

        return view('admin.guru.show', compact('guru'));
    }
}
