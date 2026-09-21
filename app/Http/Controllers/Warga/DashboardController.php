<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\WargaUser $warga */
        $warga = Auth::guard('warga')->user();
        if ($warga) {
            $warga->load(['resident.padukuhan', 'resident.rt', 'resident.rw']);
        }

        $letterRequests = LetterRequest::with('letterType')
            ->where('warga_user_id', $warga->id)
            ->orderByDesc('created_at')
            ->get();

        $letterTypes = LetterType::where('is_active', true)->orderBy('sort_order')->get();

        $stats = [
            'total' => $letterRequests->count(),
            'pending' => $letterRequests->whereIn('status', ['submitted', 'pending', 'verifying', 'processing', 'waiting_signature'])->count(),
            'approved' => $letterRequests->whereIn('status', ['approved', 'waiting_signature'])->count(),
            'completed' => $letterRequests->where('status', 'completed')->count(),
            'rejected' => $letterRequests->whereIn('status', ['rejected', 'revision', 'cancelled'])->count(),
        ];

        return view('warga.dashboard', compact('warga', 'letterRequests', 'letterTypes', 'stats'));
    }

    public function profil()
    {
        /** @var \App\Models\WargaUser $warga */
        $warga = Auth::guard('warga')->user();
        if ($warga) {
            $warga->load(['resident.padukuhan', 'resident.rt', 'resident.rw']);
        }

        return view('warga.profil', compact('warga'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\WargaUser $warga */
        $warga = Auth::guard('warga')->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
        ]);

        $warga->update([
            'name'  => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
        ]);

        return back()->with('success', 'Data kontak profil berhasil diperbarui!');
    }
}

