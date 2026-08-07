<?php

namespace App\Http\Controllers;

use App\Models\PublicDocument;
use Illuminate\Http\Request;

class PpidController extends Controller
{
    public function index(Request $request)
    {
        $query = PublicDocument::where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->orderByDesc('year')->paginate(12);

        return view('ppid.index', compact('documents'));
    }

    public function show(string $slug)
    {
        $document = PublicDocument::where('slug', $slug)->firstOrFail();
        return view('ppid.show', compact('document'));
    }

    public function download(string $slug)
    {
        $document = PublicDocument::where('slug', $slug)->firstOrFail();
        $document->incrementDownloadCount();

        return response()->download(storage_path('app/public/' . $document->file_path));
    }
}
