@extends('layouts.app')

@section('title', 'Profil Akun Warga')
@section('description', 'Kelola informasi profil dan data kontak akun portal warga mandiri.')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-white tracking-tight">Profil & Informasi Warga</h1>
                <div class="flex items-center gap-2 text-xs text-blue-200/80 mt-1.5 font-medium">
                    <a href="{{ route('warga.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Profil Akun</span>
                </div>
            </div>
            <a href="{{ route('warga.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-sm border border-white/15 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]">
    <div class="container-sid">

        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-300 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="text-sm font-medium">{{ session('success') }}</div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: KTP / Identity Summary Card --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
                    <div class="text-center pb-6 border-b border-slate-100 dark:border-slate-700/80">
                        <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-black text-3xl shadow-lg shadow-blue-500/20 mb-3.5">
                            {{ strtoupper(substr($warga->name ?? 'W', 0, 1)) }}
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $warga->name }}</h2>
                        <span class="inline-flex items-center gap-1 mt-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Terverifikasi SID
                        </span>
                    </div>

                    {{-- Resident Master Details --}}
                    <div class="py-5 space-y-3.5 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">NIK:</span>
                            <span class="font-mono font-bold text-slate-800 dark:text-slate-100">{{ $warga->nik }}</span>
                        </div>
                        @if($warga->resident?->kk_number)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">No. Kartu Keluarga:</span>
                            <span class="font-mono font-bold text-slate-800 dark:text-slate-100">{{ $warga->resident->kk_number }}</span>
                        </div>
                        @endif
                        @if($warga->resident?->gender)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Jenis Kelamin:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">{{ $warga->resident->gender === 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                        </div>
                        @endif
                        @if($warga->resident?->padukuhan)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Padukuhan / Dusun:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">{{ $warga->resident->padukuhan->name }}</span>
                        </div>
                        @endif
                        @if($warga->resident?->rt_id || $warga->resident?->rw_id)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">RT / RW:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">
                                RT {{ $warga->resident->rt?->number ?? '-' }} / RW {{ $warga->resident->rw?->number ?? '-' }}
                            </span>
                        </div>
                        @endif
                        @if($warga->resident?->religion)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Agama:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100 capitalize">{{ $warga->resident->religion }}</span>
                        </div>
                        @endif
                        @if($warga->resident?->occupation)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Pekerjaan:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">{{ $warga->resident->occupation }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="p-4 rounded-2xl bg-blue-50/70 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/50 text-blue-800 dark:text-blue-300 text-[11px] leading-relaxed">
                        💡 <strong>Catatan Kependudukan:</strong> Perubahan data NIK, Nama KTP, dan Alamat Domisili harus melalui loket pelayanan administrasi kantor Kalurahan/Desa.
                    </div>
                </div>
            </div>

            {{-- Right Column: Update Contact Information Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
                    <div class="border-b border-slate-100 dark:border-slate-700/80 pb-5 mb-6">
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Perbarui Informasi Kontak</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Pastikan nomor WhatsApp dan Email aktif untuk menerima notifikasi status pengajuan surat.
                        </p>
                    </div>

                    <form action="{{ route('warga.profil.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Nama Lengkap Akun*
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $warga->name) }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap..."
                            >
                            @error('name')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone / WhatsApp --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Nomor WhatsApp / Telepon Aktif*
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-slate-400 text-sm font-mono font-bold">🇮🇩 +62</span>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $warga->phone) }}"
                                    required
                                    class="w-full pl-20 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('phone') border-red-500 @enderror"
                                    placeholder="81234567890"
                                >
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Nomor ini akan digunakan untuk konfirmasi dokumen & notifikasi permohonan.</span>
                            @error('phone')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Alamat Email (Opsional)
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $warga->email) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                                placeholder="nama@email.com"
                            >
                            @error('email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-end gap-3">
                            <a href="{{ route('warga.dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-500/20 transition-all">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
