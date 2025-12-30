<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Page;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil feedback aktif terbaru
        $feedbacks = Feedback::where('status', 'aktif')
                             ->orderByDesc('created_at')
                             ->get();

        // Ambil halaman
        $syaratMagangPage = Page::where('slug', 'syarat-magang')->first();
        $aboutPage = Page::where('slug', 'about')->first();
        $faqPage = Page::where('slug', 'faqs')->first();

        // Konten default jika halaman tidak ditemukan
        if (!$syaratMagangPage) $syaratMagangPage = (object)['title'=>'Syarat Magang','content'=>''];
        if (!$aboutPage) $aboutPage = (object)['title'=>'About','content'=>''];
        if (!$faqPage) $faqPage = (object)['title'=>'FAQs','content'=>''];

        // Decode JSON
        $syaratMagangItems = [];
        if ($syaratMagangPage->content) {
            $decoded = json_decode($syaratMagangPage->content, true);
            if (is_array($decoded)) {
                $syaratMagangItems = $decoded;
            } else {
                $lines = preg_split('/\r\n|\r|\n/', $syaratMagangPage->content);
                $items = [];
                $i = 0;
                while ($i < count($lines)) {
                    if (trim($lines[$i]) !== '') {
                        $title = trim($lines[$i]);
                        $desc = isset($lines[$i+1]) ? trim($lines[$i+1]) : '';
                        $items[] = [
                            'icon' => 'fas fa-circle',
                            'title' => $title,
                            'desc' => $desc,
                            'link' => '#'
                        ];
                        $i += 2;
                    } else {
                        $i++;
                    }
                }
                $syaratMagangItems = $items;
            }
        }

        $aboutItems = json_decode($aboutPage->content, true) ?? [];
        $faqItems = json_decode($faqPage->content, true) ?? [];

        return view('welcome', compact(
            'feedbacks',
            'syaratMagangPage', 'syaratMagangItems',
            'aboutPage', 'aboutItems',
            'faqPage', 'faqItems'
        ));
    }
}
