@extends('layouts.app')

@section('title', 'Pendaftaran Akun Warga Mandiri')
@section('description', 'Pendaftaran akun baru Portal Layanan Mandiri Digital Desa/Kalurahan menggunakan NIK E-KTP.')

@section('content')
<div class="min-h-[80vh] py-12 lg:py-16 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center">
    <div class="container-sid">
        <div class="max-w-lg mx-auto bg-white dark:bg-slate-800 rounded-3xl p-8 lg:p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-700/80">
            
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg shadow-blue-500/25">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pendaftaran Akun Warga</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Daftarkan NIK E-KTP Anda untuk menikmati kemudahan pengajuan surat administrasi desa online
                </p>
            </div>

            <form action="{{ route('warga.register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nomor Induk Kependudukan (NIK 16 Digit)*
                    </label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        placeholder="340407xxxxxxxxxx"
                        maxlength="16"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-mono font-bold focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nik') border-red-500 @enderror"
                    >
                    @error('nik')
                    <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nama Lengkap (Sesuai KTP)*
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Masukkan nama lengkap Anda..."
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('full_name') border-red-500 @enderror"
                    >
                    @error('full_name')
                    <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp*
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="081234567890"
                            required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('phone') border-red-500 @enderror"
                        >
                        @error('phone')
                        <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Email (Opsional)
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                        <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kata Sandi (Minimal 8 Karakter)*
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                    <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Ulangi Kata Sandi*
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black shadow-lg shadow-blue-500/25 transition-all mt-2">
                    Daftar Akun Warga Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700/80 text-center text-xs text-slate-500 dark:text-slate-400">
                Sudah memiliki akun?
                <a href="{{ route('warga.login') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline ml-1">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
