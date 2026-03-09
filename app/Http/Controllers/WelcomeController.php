<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Page;

class WelcomeController extends Controller
{
    public function index()
    {
        // =======================
        // FEEDBACK
        // =======================
        $feedbacks = Feedback::where('status', 'aktif')
            ->latest()
            ->get();

        // =======================
        // PAGES
        // =======================
        $syaratMagangPage = Page::where('slug', 'syarat-magang')->first();
        $aboutPage        = Page::where('slug', 'about')->first();
        $faqPage          = Page::where('slug', 'faqs')->first();

        // default
        $syaratMagangPage = $syaratMagangPage ?? (object)['content' => ''];
        $aboutPage        = $aboutPage ?? (object)['content' => ''];
        $faqPage          = $faqPage ?? (object)['content' => ''];

        // =======================
        // SYARAT MAGANG
        // =======================
        $syaratMagangItems = $this->parseContent($syaratMagangPage->content);

        // =======================
        // ABOUT
        // =======================
        $aboutFeatures = $this->parseContent($aboutPage->content);

        $aboutSection = [
            'subtitle'    => 'About SIPEMANG',
            'title'       => 'Sistem Informasi Pengajuan PKL & Magang DKIS Kota Cirebon',
            'description' => 'Sistem informasi ini memudahkan siswa dan mahasiswa mengajukan PKL dan Magang secara online.',
            'features'    => $aboutFeatures
        ];

        // =======================
        // FAQ
        // =======================
        $faqItems = $this->parseContent($faqPage->content);

        return view('welcome', compact(
            'feedbacks',
            'syaratMagangItems',
            'aboutSection',
            'faqItems'
        ));
    }

    // =======================
    // PARSER UNIVERSAL (AMAN)
    // =======================
    private function parseContent($content)
    {
        if (!$content) return [];

        // jika JSON
        $json = json_decode($content);

        if (json_last_error() === JSON_ERROR_NONE) {
            return collect($json)->toArray(); // aman (array/object OK)
        }

        // fallback teks biasa
        $lines = preg_split('/\r\n|\r|\n/', $content);
        $items = [];

        for ($i = 0; $i < count($lines); $i += 2) {
            if (!empty(trim($lines[$i]))) {
                $items[] = [
                    'icon'  => 'fas fa-circle',
                    'title' => trim($lines[$i]),
                    'desc'  => $lines[$i + 1] ?? '',
                    'link'  => '#'
                ];
            }
        }

        return $items;
    }
}