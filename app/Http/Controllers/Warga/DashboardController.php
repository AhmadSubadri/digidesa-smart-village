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
        $warga = Auth::guard('warga')->user();

        $letterRequests = LetterRequest::with('letterType')
            ->where('warga_user_id', $warga->id)
            ->orderByDesc('created_at')
            ->get();

        $letterTypes = LetterType::where('is_active', true)->orderBy('sort_order')->get();

        $stats = [
            'total' => $letterRequests->count(),
            'pending' => $letterRequests->where('status', 'pending')->count(),
            'approved' => $letterRequests->where('status', 'approved')->count(),
            'completed' => $letterRequests->where('status', 'completed')->count(),
        ];

        return view('warga.dashboard', compact('warga', 'letterRequests', 'letterTypes', 'stats'));
    }

    public function profil()
    {
        $warga = Auth::guard('warga')->user();
        return view('warga.profil', compact('warga'));
    }

    public function updateProfil(Request $request)
    {
        $warga = Auth::guard('warga')->user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:20'],
            'email'     => ['nullable', 'email', 'max:255'],
        ]);

        $warga->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
