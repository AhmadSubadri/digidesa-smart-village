<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('announcements.index', compact('announcements'));
    }

    public function show(int $id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.show', compact('announcement'));
    }

    public function ticker()
    {
        $items = Announcement::ticker()->limit(8)->get(['id', 'title']);
        return response()->json($items);
    }
}
