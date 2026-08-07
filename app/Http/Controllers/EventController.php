<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('is_published', true)
            ->orderBy('start_datetime')
            ->paginate(12);

        return view('events.index', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $upcoming = Event::where('is_published', true)
            ->where('id', '!=', $event->id)
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime')
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'upcoming'));
    }
}
