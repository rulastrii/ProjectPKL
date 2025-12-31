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
            ->orderByDesc('created_at')
            ->get();

        // =======================
        // PAGES
        // =======================
        $syaratMagangPage = Page::where('slug', 'syarat-magang')->first();
        $aboutPage        = Page::where('slug', 'about')->first();
        $faqPage          = Page::where('slug', 'faqs')->first();

        // Default jika tidak ada
        if (!$syaratMagangPage) $syaratMagangPage = (object)['title' => 'Syarat Magang', 'content' => ''];
        if (!$aboutPage)        $aboutPage        = (object)['title' => 'About', 'content' => ''];
        if (!$faqPage)          $faqPage          = (object)['title' => 'FAQs', 'content' => ''];

        // =======================
        // SYARAT MAGANG
        // =======================
        $syaratMagangItems = [];

        if ($syaratMagangPage->content) {
            $decoded = json_decode($syaratMagangPage->content, true);

            if (is_array($decoded)) {
                $syaratMagangItems = $decoded;
            } else {
                $lines = preg_split('/\r\n|\r|\n/', $syaratMagangPage->content);
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

                $syaratMagangItems = $items;
            }
        }

        // =======================
        // ABOUT SECTION (FIX UTAMA)
        // =======================
        $aboutSection = [
            'subtitle'    => 'About SIPEMANG',
            'title'       => 'Sistem Informasi Pengajuan PKL & Magang DKIS Kota Cirebon',
            'description' => 'Sistem informasi ini memudahkan siswa dan mahasiswa mengajukan PKL dan Magang secara online.',
            'features'    => []
        ];

        if ($aboutPage->content) {

            // ✅ Jika JSON
            if ($this->isJson($aboutPage->content)) {
                $decoded = json_decode($aboutPage->content, true);

                if (is_array($decoded)) {
                    $aboutSection['features'] = $decoded;
                }
            }
            // ✅ Jika TEXT BIASA
            else {
                $lines = preg_split('/\r\n|\r|\n/', $aboutPage->content);
                $items = [];

                for ($i = 0; $i < count($lines); $i += 2) {
                    if (!empty(trim($lines[$i]))) {
                        $items[] = [
                            'icon'  => 'fas fa-check-circle',
                            'title' => trim($lines[$i]),
                            'desc'  => $lines[$i + 1] ?? ''
                        ];
                    }
                }

                $aboutSection['features'] = $items;
            }
        }

        // =======================
        // FAQ
        // =======================
        $faqItems = json_decode($faqPage->content, true) ?? [];

        return view('welcome', compact(
            'feedbacks',
            'syaratMagangPage',
            'syaratMagangItems',
            'aboutPage',
            'aboutSection', // ⬅️ PENTING
            'faqPage',
            'faqItems'
        ));
    }

    // =======================
    // SEARCH
    // =======================
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $pages = Page::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get();

        $results = $pages->map(function ($page) {

            $excerpt = '';

            if ($this->isJson($page->content)) {
                $json = json_decode($page->content, true);

                if (is_array($json)) {
                    $excerpt = collect($json)
                        ->pluck('title')
                        ->filter()
                        ->implode(', ');
                }
            } else {
                $excerpt = strip_tags($page->content);
            }

            return [
                'title'   => $page->title,
                'excerpt' => substr($excerpt, 0, 80),
                'link'    => url('/#' . $page->slug),
            ];
        });

        return response()->json($results);
    }

    // =======================
    // HELPER JSON
    // =======================
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
