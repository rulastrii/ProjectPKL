<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\Feedback;
use App\Models\Sertifikat;

class FeedbackController extends Controller
{
    /**
     * Index feedback (magang)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        /** ================= CEK BOLEH FEEDBACK ================= */
        $siswa = SiswaProfile::where('user_id', $user->id)->first();

        // default tidak boleh
        $bolehFeedback = false;

        if ($siswa) {
            // CUKUP CEK ADA SERTIFIKAT
            $bolehFeedback = Sertifikat::where('siswa_id', $siswa->id)->exists();
        }

        /** ================= DATA FEEDBACK ================= */
        $query = Feedback::where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('feedback', 'like', '%' . $request->search . '%');
        }

        $feedbacks = $query->orderByDesc('created_at')->get();

        /** ================= FOTO ================= */
        foreach ($feedbacks as $fb) {
            $profile = SiswaProfile::where('user_id', $fb->user_id)->first();
            $fb->foto = $profile?->foto;
        }

        return view('magang.feedback.index', compact('feedbacks', 'bolehFeedback'));
    }

    /**
     * Simpan feedback
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        /** ================= VALIDASI BOLEH FEEDBACK ================= */
        $siswa = SiswaProfile::where('user_id', $user->id)->first();

        if (
            !$siswa ||
            !Sertifikat::where('siswa_id', $siswa->id)->exists()
        ) {
            abort(403, 'Feedback hanya dapat diisi setelah sertifikat diterbitkan.');
        }

        $request->validate([
            'feedback' => 'required|string',
            'bintang'  => 'required|integer|min:0|max:5',
        ]);

        /** ================= FOTO ================= */
        $foto = $siswa->foto ?? null;

        Feedback::create([
            'user_id'   => $user->id,
            'nama_user' => $user->name,
            'role_name' => $user->role->name ?? 'magang',
            'feedback'  => $request->feedback,
            'foto'      => $foto,
            'bintang'   => $request->bintang,
            'status'    => 'aktif',
        ]);

        return redirect()
            ->route('magang.feedback.index')
            ->with('success', 'Feedback berhasil ditambahkan!');
    }

    /**
     * Update feedback
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $feedback = Feedback::findOrFail($id);

        if ($feedback->user_id !== $user->id) {
            abort(403, 'Tidak memiliki akses.');
        }

        $request->validate([
            'feedback' => 'required|string',
            'bintang'  => 'required|integer|min:0|max:5',
        ]);

        $feedback->update([
            'feedback' => $request->feedback,
            'bintang'  => $request->bintang,
        ]);

        return redirect()
            ->route('magang.feedback.index')
            ->with('success', 'Feedback berhasil diperbarui!');
    }

}
