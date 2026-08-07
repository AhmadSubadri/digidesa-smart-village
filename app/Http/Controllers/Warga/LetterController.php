<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index()
    {
        $warga = Auth::guard('warga')->user();
        $requests = LetterRequest::with('letterType')
            ->where('warga_user_id', $warga->id)
            ->orderByDesc('created_at')
            ->get();

        return view('warga.surat.index', compact('requests'));
    }

    public function create()
    {
        $letterTypes = LetterType::where('is_active', true)->orderBy('sort_order')->get();
        return view('warga.surat.create', compact('letterTypes'));
    }

    public function form(string $code)
    {
        $letterType = LetterType::where('code', $code)->where('is_active', true)->firstOrFail();
        $warga = Auth::guard('warga')->user();

        return view('warga.surat.form', compact('letterType', 'warga'));
    }

    public function store(Request $request, string $code)
    {
        $letterType = LetterType::where('code', $code)->firstOrFail();
        $warga = Auth::guard('warga')->user();

        $validated = $request->validate([
            'purpose' => ['required', 'string', 'max:500'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('letter_attachments', 'public');
            }
        }

        $letterReq = LetterRequest::create([
            'letter_type_id' => $letterType->id,
            'warga_user_id' => $warga->id,
            'nik' => $warga->nik,
            'applicant_name' => $warga->full_name,
            'purpose' => $validated['purpose'],
            'attachments' => $attachmentPaths,
            'status' => 'pending',
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Permohonan surat berhasil dikirim! Nomor Tiket: ' . $letterReq->request_number);
    }

    public function show(int $id)
    {
        $warga = Auth::guard('warga')->user();
        $letterRequest = LetterRequest::with('letterType')
            ->where('warga_user_id', $warga->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('warga.surat.show', compact('letterRequest'));
    }
}
