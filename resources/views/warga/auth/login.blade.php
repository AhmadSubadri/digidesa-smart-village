@extends('layouts.app')

@section('title', 'Masuk Portal Warga')
@section('description', 'Halaman masuk Portal Warga Kalurahan Condongcatur menggunakan NIK.')

@section('content')
<div class="min-h-screen py-20 bg-slate-50 flex items-center justify-center">
    <div class="container-sid">
        <div class="max-w-md mx-auto bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-blue-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900">Masuk Portal Warga</h1>
                <p class="text-xs text-gray-500 mt-1">Masukkan NIK dan kata sandi Anda untuk mengakses layanan digital</p>
            </div>

            @if(session('error'))
            <div class="p-4 bg-red-50 text-red-600 rounded-xl text-xs font-semibold mb-6">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('warga.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor Induk Kependudukan (NIK)</label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        placeholder="16 digit NIK E-KTP"
                        maxlength="16"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600 font-mono @error('nik') border-red-500 @enderror"
                    >
                    @error('nik')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kata Sandi</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                    >
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        Ingat Saya
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 text-sm">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
                Belum punya akun warga?
                <a href="{{ route('warga.register') }}" class="font-bold text-blue-600 hover:underline ml-1">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
