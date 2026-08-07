<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $recentComplaints = Complaint::where('is_public', true)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('complaint.index', compact('recentComplaints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'reporter_name' => ['required', 'string', 'max:255'],
            'reporter_phone' => ['required', 'string', 'max:20'],
            'category' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_anonymous' => ['nullable', 'boolean'],
        ]);

        $complaint = Complaint::create(array_merge($validated, [
            'status' => 'pending',
            'is_public' => true,
        ]));

        return back()->with('success', 'Pengaduan Anda berhasil dikirim! Nomor Tiket: ' . $complaint->ticket_number);
    }

    public function tracking(Request $request)
    {
        $ticket = $request->get('ticket');
        $complaint = null;

        if ($ticket) {
            $complaint = Complaint::where('ticket_number', $ticket)->first();
        }

        return view('complaint.tracking', compact('complaint', 'ticket'));
    }

    public function trackingDetail(string $ticket)
    {
        $complaint = Complaint::where('ticket_number', $ticket)->firstOrFail();
        return view('complaint.tracking', compact('complaint', 'ticket'));
    }
}
