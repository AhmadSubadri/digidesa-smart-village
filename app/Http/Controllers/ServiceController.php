<?php

namespace App\Http\Controllers;

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

    public function verifikasi(string $token)
    {
        // Public QR Code letter validation page
        return view('services.verifikasi', compact('token'));
    }
}
