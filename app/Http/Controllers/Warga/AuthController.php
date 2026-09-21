<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\WargaUser;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('warga.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('warga')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('warga.dashboard'));
        }

        return back()->withErrors([
            'nik' => 'NIK atau password yang Anda masukkan salah.',
        ])->onlyInput('nik');
    }

    public function registerForm()
    {
        return view('warga.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:warga_users,nik'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:warga_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Find matching resident if exists
        $matchingResident = Resident::all()->first(function ($r) use ($validated) {
            return $r->nik === $validated['nik'];
        });

        $warga = WargaUser::create([
            'nik' => $validated['nik'],
            'name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'resident_id' => $matchingResident?->id,
            'is_verified' => $matchingResident !== null,
            'verified_at' => $matchingResident ? now() : null,
            'is_active' => true,
        ]);

        Auth::guard('warga')->login($warga);

        return redirect()->route('warga.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Portal Warga Mandiri.');
    }

    public function logout(Request $request)
    {
        Auth::guard('warga')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
