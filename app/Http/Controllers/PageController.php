<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    // Public: tampilkan halaman
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $items = json_decode($page->content, true) ?? [];

        return view('pages.show', compact('page', 'items'));
    }

    // Admin: list semua halaman
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    // Form create
    public function create()
    {
        return view('admin.pages.create');
    }

    // Simpan halaman baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'required|string',
        ]);

        $items = $this->parseContentToItems($request->content);

        Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => json_encode($items, JSON_PRETTY_PRINT)
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page berhasil dibuat!');
    }

    // Edit page
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    // Update page
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $items = $this->parseContentToItems($request->content);

        $page->update([
            'title' => $request->title,
            'content' => json_encode($items, JSON_PRETTY_PRINT)
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated!');
    }

    // Helper: convert teks ke array items
    private function parseContentToItems($content)
    {
        $lines = preg_split('/\r\n|\r|\n/', $content);
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

        return $items;
    }
}
