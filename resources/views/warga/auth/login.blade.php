@extends('layouts.app')

@section('title', 'Masuk Portal Warga Mandiri')
@section('description', 'Halaman masuk Portal Layanan Mandiri Digital Desa/Kalurahan menggunakan NIK E-KTP.')

@section('content')
<div class="min-h-[75vh] py-12 lg:py-16 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center">
    <div class="container-sid">
        <div class="max-w-md mx-auto bg-white dark:bg-slate-800 rounded-3xl p-8 lg:p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-700/80">
            
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg shadow-blue-500/25">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Portal Warga Mandiri</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Masuk dengan NIK dan kata sandi Anda untuk mengajukan surat dan melacak dokumen
                </p>
            </div>

            @if(session('error'))
            <div class="p-4 bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-2xl text-xs font-semibold mb-6 flex items-center gap-2.5">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <form action="{{ route('warga.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nomor Induk Kependudukan (NIK)*
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            name="nik"
                            value="{{ old('nik') }}"
                            placeholder="16 digit NIK E-KTP"
                            maxlength="16"
                            required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-mono font-bold focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nik') border-red-500 @enderror"
                        >
                    </div>
                    @error('nik')
                    <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kata Sandi*
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div class="flex items-center justify-between text-xs py-1">
                    <label class="flex items-center gap-2 text-slate-600 dark:text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black shadow-lg shadow-blue-500/25 transition-all">
                    Masuk ke Portal Warga
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700/80 text-center text-xs text-slate-500 dark:text-slate-400">
                Belum memiliki akun warga?
                <a href="{{ route('warga.register') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline ml-1">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
