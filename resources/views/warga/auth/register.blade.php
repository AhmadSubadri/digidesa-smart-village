@extends('layouts.app')

@section('title', 'Pendaftaran Akun Warga')
@section('description', 'Pendaftaran akun baru Portal Warga Condongcatur menggunakan NIK.')

@section('content')
<div class="min-h-screen py-20 bg-slate-50 flex items-center justify-center">
    <div class="container-sid">
        <div class="max-w-lg mx-auto bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-extrabold text-gray-900">Pendaftaran Akun Warga</h1>
                <p class="text-xs text-gray-500 mt-1">Daftarkan NIK Anda untuk mengakses fasilitas layanan mandiri online</p>
            </div>

            <form action="{{ route('warga.register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NIK (16 Digit)*</label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        placeholder="340407xxxxxxxxxx"
                        maxlength="16"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600 font-mono @error('nik') border-red-500 @enderror"
                    >
                    @error('nik')<span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap (Sesuai KTP)*</label>
                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Nama Lengkap"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                    >
                    @error('full_name')<span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor WhatsApp*</label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="081234567890"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email (Opsional)</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@contoh.com"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kata Sandi (Minimal 8 karakter)*</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Kata Sandi*</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600"
                    >
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 text-sm mt-4">
                    Daftar Akun Warga
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-gray-500">
                Sudah memiliki akun?
                <a href="{{ route('warga.login') }}" class="font-bold text-blue-600 hover:underline ml-1">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
