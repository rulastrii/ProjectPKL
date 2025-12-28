<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\Feedback;


class FeedbackController extends Controller
{
    
    // Menampilkan list feedback (Magang hanya lihat sendiri)
    public function index(Request $request) {
        $user = Auth::user();
        $query = Feedback::where('user_id', $user->id);

        if ($request->has('search') && $request->search != '') {
            $query->where('feedback', 'like', '%'.$request->search.'%');
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->get(); // Tanpa paginate

        // Ambil foto dari profile
        foreach ($feedbacks as $fb) {
            $profile = SiswaProfile::where('user_id', $fb->user_id)->first();
            $fb->foto = $profile?->foto ?? null;
        }

        return view('magang.feedback.index', compact('feedbacks'));
    }


    // Menyimpan feedback baru
    public function store(Request $request) {
        $user = Auth::user();

        $request->validate([
            'feedback' => 'required|string',
            'bintang' => 'required|integer|min:0|max:5',
        ]);

        // Ambil foto
        $foto = $user->foto;

        // Jika role siswa (role_id = 5), ambil foto dari siswa_profile
        if ($user->role_id == 5) {
            $profile = SiswaProfile::where('user_id', $user->id)->first();
            if ($profile && $profile->foto) {
                $foto = $profile->foto;
            }
        }

        Feedback::create([
            'user_id' => $user->id,
            'nama_user' => $user->name,
            'role_name' => $user->role->name ?? 'magang',
            'feedback' => $request->feedback,
            'foto' => $foto,
            'bintang' => $request->bintang,
            'status' => 'aktif',
        ]);

        return redirect()->route('magang.feedback.index')
                         ->with('success', 'Feedback berhasil ditambahkan!');
    }

    // Update feedback sendiri
    public function update(Request $request, $id) {
        $user = Auth::user();
        $feedback = Feedback::findOrFail($id);

        if ($feedback->user_id !== $user->id) {
            return redirect()->route('magang.feedback.index')
                             ->with('error', 'Unauthorized');
        }

        $request->validate([
            'feedback' => 'required|string',
            'bintang' => 'required|integer|min:0|max:5',
        ]);

        $feedback->update([
            'feedback' => $request->feedback,
            'bintang' => $request->bintang,
        ]);

        return redirect()->route('magang.feedback.index')
                         ->with('success', 'Feedback berhasil diupdate!');
    }

    // Toggle status feedback (aktif/non-aktif)
    public function toggleStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

}