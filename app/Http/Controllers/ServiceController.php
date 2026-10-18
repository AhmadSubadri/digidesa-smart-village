<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Models\LetterType;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $letterTypes = LetterType::where('is_active', true)->orderBy('sort_order')->get();
        return view('services.index', compact('letterTypes'));
    }

    public function surat()
    {
        $letterTypes = LetterType::where('is_active', true)->orderBy('sort_order')->get();
        return view('services.surat', compact('letterTypes'));
    }

    /**
     * Halaman publik verifikasi keabsahan dokumen / surat resmi ber-QR Code (Anti-Tamper).
     */
    public function verifikasi(string $token)
    {
        $letter = LetterRequest::with(['letterType', 'resident', 'signedBy'])
            ->where('qr_code_token', $token)
            ->orWhere('request_number', $token)
            ->orWhere('letter_number', urldecode($token))
            ->first();

        if ($letter) {
            $nik = $letter->nik;
            $maskedNik = strlen($nik) >= 16 
                ? substr($nik, 0, 6) . '******' . substr($nik, -4) 
                : $nik;

            $fingerprint = strtoupper(hash('sha256', ($letter->letter_number ?? '') . ($letter->completed_at ?? '') . ($letter->qr_code_token ?? '')));

            return view('services.verifikasi', [
                'isValid' => true,
                'letter' => $letter,
                'token' => $token,
                'maskedNik' => $maskedNik,
                'fingerprint' => $fingerprint,
            ]);
        }

        return view('services.verifikasi', [
            'isValid' => false,
            'letter' => null,
            'token' => $token,
        ]);
    }
}
