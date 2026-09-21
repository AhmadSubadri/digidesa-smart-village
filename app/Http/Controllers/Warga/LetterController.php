<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use App\Models\LetterRequest;
use App\Models\LetterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $warga = Auth::guard('warga')->user();
        
        $query = LetterRequest::with(['letterType', 'resident'])
            ->where('warga_user_id', $warga->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhereHas('letterType', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('warga.surat.index', compact('requests', 'warga'));
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
            'notes' => ['nullable', 'string', 'max:500'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'purpose.required' => 'Keperluan permohonan surat wajib diisi.',
            'attachments.*.max' => 'Ukuran setiap berkas maksimal 5MB.',
            'attachments.*.mimes' => 'Format berkas harus berupa JPG, PNG, atau PDF.',
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('letter_attachments/' . date('Y/m'), 'public');
                $attachmentPaths[] = [
                    'name' => $originalName,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                ];
            }
        }

        $letterReq = LetterRequest::create([
            'letter_type_id' => $letterType->id,
            'warga_user_id' => $warga->id,
            'resident_id' => $warga->resident_id,
            'status' => 'submitted',
            'form_data' => [
                'purpose' => $validated['purpose'],
                'applicant_name' => $warga->full_name,
                'nik' => $warga->nik,
                'phone' => $warga->phone,
            ],
            'notes' => $request->input('notes'),
            'attachments' => $attachmentPaths,
        ]);

        // Create log entry
        LetterLog::create([
            'letter_request_id' => $letterReq->id,
            'action' => 'Permohonan surat berhasil diajukan oleh pemohon',
            'old_status' => null,
            'new_status' => 'submitted',
            'notes' => 'Menunggu verifikasi berkas oleh petugas pelayanan desa.',
            'created_at' => now(),
        ]);

        return redirect()->route('warga.surat.show', $letterReq->id)
            ->with('success', 'Permohonan surat berhasil dikirim! Nomor Tiket: ' . $letterReq->request_number);
    }

    public function show(int $id)
    {
        $warga = Auth::guard('warga')->user();
        $letterRequest = LetterRequest::with(['letterType', 'resident', 'logs' => function ($q) {
                $q->orderBy('created_at', 'asc');
            }])
            ->where('warga_user_id', $warga->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('warga.surat.show', compact('letterRequest', 'warga'));
    }

    public function download(int $id)
    {
        $warga = Auth::guard('warga')->user();
        $letterRequest = LetterRequest::where('warga_user_id', $warga->id)
            ->where('id', $id)
            ->firstOrFail();

        if (empty($letterRequest->pdf_path) || !Storage::disk('public')->exists($letterRequest->pdf_path)) {
            return back()->with('error', 'Dokumen surat resmi belum tersedia atau belum selesai diterbitkan.');
        }

        return Storage::disk('public')->download(
            $letterRequest->pdf_path,
            'Surat-' . ($letterRequest->letterType?->code ?? 'Keterangan') . '-' . $letterRequest->request_number . '.pdf'
        );
    }

    public function cancel(int $id)
    {
        $warga = Auth::guard('warga')->user();
        $letterRequest = LetterRequest::where('warga_user_id', $warga->id)
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($letterRequest->status, ['submitted', 'pending'])) {
            return back()->with('error', 'Permohonan tidak dapat dibatalkan karena sudah dalam proses verifikasi/penerbitan.');
        }

        $letterRequest->update([
            'status' => 'cancelled',
        ]);

        LetterLog::create([
            'letter_request_id' => $letterRequest->id,
            'action' => 'Permohonan dibatalkan oleh pemohon',
            'old_status' => $letterRequest->status,
            'new_status' => 'cancelled',
            'notes' => 'Dibatalkan langsung melalui portal warga mandiri.',
            'created_at' => now(),
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Permohonan surat berhasil dibatalkan.');
    }
}

