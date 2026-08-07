<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('gallery.index', compact('albums'));
    }

    public function show(string $slug)
    {
        $album = Album::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('gallery.show', compact('album'));
    }
}
