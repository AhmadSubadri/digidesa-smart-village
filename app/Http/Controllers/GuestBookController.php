<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index()
    {
        $guests = GuestBook::where('is_public', true)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('guestbook.index', compact('guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        GuestBook::create(array_merge($validated, [
            'is_public' => true,
            'visited_at' => now(),
        ]));

        return back()->with('success', 'Terima kasih telah mengisi Buku Tamu Kalurahan Condongcatur!');
    }
}
