@extends('layouts.app')

@section('title', 'Katalog Layanan Surat Keterangan Online')
@section('description', 'Pilih dan ajukan permohonan surat keterangan desa / kalurahan secara mandiri.')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-white tracking-tight">Katalog Surat Keterangan Online</h1>
                <div class="flex items-center gap-2 text-xs text-blue-200/80 mt-1.5 font-medium">
                    <a href="{{ route('warga.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Ajukan Surat</span>
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

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]" x-data="{ search: '' }">
    <div class="container-sid">

        {{-- Top Info & Search Box --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Pilih Dokumen Surat yang Ingin Diajukan</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Setiap jenis surat memiliki persyaratan lampiran dokumen yang berbeda. Pastikan Anda telah menyiapkan foto/scan berkas persyaratan (KTP, KK, Bukti Terkait) sebelum mengajukan.
                </p>
            </div>
            <div class="w-full md:w-72 shrink-0">
                <div class="relative">
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari jenis surat..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Letter Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($letterTypes as $type)
            <div
                x-show="search === '' || '{{ strtolower($type->name . ' ' . $type->code . ' ' . $type->description) }}'.includes(search.toLowerCase())"
                class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-700/80 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all flex flex-col justify-between group"
            >
                <div>
                    {{-- Header Badges --}}
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 font-mono font-black text-xs">
                            {{ $type->code }}
                        </span>
                        <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                            <span>⏱️</span>
                            <span>{{ $type->estimated_days ?? 1 }} Hari Kerja</span>
                        </div>
                    </div>

                    {{-- Title & Description --}}
                    <h3 class="text-base font-black text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $type->name }}
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                        {{ $type->description ?? 'Layanan penerbitan surat keterangan resmi dari pemerintah desa/kalurahan.' }}
                    </p>

                    {{-- Requirements List Preview --}}
                    @if(is_array($type->requirements) && count($type->requirements) > 0)
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/80">
                        <div class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Syarat Berkas Lampiran:
                        </div>
                        <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-400">
                            @foreach($type->requirements as $req)
                            @php $label = is_array($req) ? ($req['label'] ?? 'Dokumen Pendukung') : $req; @endphp
                            <li class="flex items-start gap-2">
                                <span class="text-blue-500 font-bold shrink-0">&bull;</span>
                                <span class="line-clamp-1">{{ $label }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                {{-- Action Button --}}
                <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700/80">
                    <a href="{{ route('warga.surat.form', $type->code) }}" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 group-hover:scale-[1.02] transition-all">
                        <span>Isi Formulir Permohonan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-xs text-slate-400">
                Belum ada jenis surat yang tersedia saat ini.
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
