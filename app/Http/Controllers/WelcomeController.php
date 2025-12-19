<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class WelcomeController extends Controller
{
    /**
     * Tampilkan halaman welcome dengan testimonial feedback
     */
    public function index()
    {
        // Ambil feedback aktif terbaru dari tabel feedback
        $feedbacks = Feedback::where('status', 'aktif')
                             ->orderByDesc('created_at')
                             ->get();

        // Kirim ke view
        return view('welcome', compact('feedbacks'));
    }
}
