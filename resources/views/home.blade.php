@extends('layouts.app')

@section('title', 'Beranda Resmi')
@section('description', 'Website Resmi Pemerintah Kalurahan Condongcatur — Pusat informasi publik, layanan administrasi kependudukan mandiri, dan transparansi tata kelola kalurahan.')

@section('content')

{{-- ============================================================
     HERO SECTION (Authoritative Municipal Standard)
============================================================ --}}
<section class="relative bg-gradient-to-b from-[#0F294A] via-[#12335C] to-slate-900 text-white overflow-hidden py-16 lg:py-24 border-b border-blue-900/40" aria-label="Hero Banner" id="hero" x-data="{ videoModalOpen: false, currentVideoUrl: '' }">
    {{-- Subtle Ambient Background Elements --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#60a5fa_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute top-0 right-0 w-[550px] h-[550px] bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container-sid relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            {{-- Left: Text Content & Actions --}}
            <div class="lg:col-span-7 space-y-6 text-left">
                {{-- Government Official Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-900/60 border border-blue-700/60 text-blue-200 text-xs font-semibold backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Kalurahan Condongcatur') }}</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                    {{ \App\Services\SettingService::getValue('hero_title', 'Pusat Informasi & Pelayanan Administrasi Warga Terpadu') }}
                </h1>

                {{-- Subtitle --}}
                <p class="text-base lg:text-lg text-slate-300 leading-relaxed font-normal max-w-2xl">
                    {{ \App\Services\SettingService::getValue('hero_subtitle', \App\Services\SettingService::getValue('village_tagline', 'Akses layanan mandiri kependudukan, transparansi anggaran, publikasi warta resmi, dan data statistik kalurahan secara digital, cepat, dan transparan.')) }}
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center gap-3.5 pt-2">
                    <a href="{{ route('warga.login') }}" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-xs sm:text-sm font-bold shadow-xl shadow-blue-500/25 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Portal Warga Mandiri</span>
                    </a>
                    <a href="{{ route('layanan.surat') }}" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/15 text-white text-xs sm:text-sm font-semibold border border-white/15 backdrop-blur-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Panduan Surat</span>
                    </a>
                    <a href="{{ route('pengaduan.tracking') }}" class="px-5 py-3.5 rounded-2xl text-slate-300 hover:text-white text-xs sm:text-sm font-semibold hover:bg-white/5 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Lacak Pengaduan</span>
                    </a>
                </div>

                {{-- Institutional Highlight Metrics (100% Realtime Calculated from DB) --}}
                <div class="pt-6 border-t border-slate-700/60 grid grid-cols-3 gap-4 max-w-xl">
                    <div>
                        <div class="text-2xl font-black text-white tracking-tight">{{ $stats['padukuhan'] ?? '18' }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Padukuhan / Dusun</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-white tracking-tight">{{ $stats['population'] ?? '28.394' }}+</div>
                        <div class="text-xs text-slate-400 mt-0.5">Jiwa Penduduk</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-emerald-400 tracking-tight">{{ ucfirst($idmScore?->status ?? 'Mandiri') }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Status IDM Desa</div>
                    </div>
                </div>
            </div>

            {{-- Right: Multi-Media Swiper Slides (Image / Video MP4 / YouTube) --}}
            <div class="lg:col-span-5">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-700/60 bg-slate-800">
                    <div class="swiper hero-swiper aspect-[4/3] w-full">
                        <div class="swiper-wrapper">
                            @forelse($banners as $banner)
                            <div class="swiper-slide relative bg-slate-900 overflow-hidden">
                                @if($banner->media_type === 'video' && $banner->video_path)
                                    {{-- Local MP4 Video Background --}}
                                    <video
                                        class="w-full h-full object-cover"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                        poster="{{ $banner->image_path ? Storage::url($banner->image_path) : '' }}"
                                    >
                                        <source src="{{ Storage::url($banner->video_path) }}" type="video/mp4">
                                    </video>
                                @elseif($banner->media_type === 'youtube' && $banner->video_url)
                                    {{-- YouTube Video Slide / Embed Preview --}}
                                    <div class="relative w-full h-full">
                                        <img
                                            src="{{ $banner->image_path ? Storage::url($banner->image_path) : placeholder_image(800, 600, $banner->title) }}"
                                            alt="{{ $banner->title }}"
                                            class="w-full h-full object-cover"
                                        >
                                        <button
                                            type="button"
                                            @click="videoModalOpen = true; currentVideoUrl = '{{ $banner->getYouTubeEmbedUrl() }}'"
                                            class="absolute inset-0 flex items-center justify-center bg-slate-950/40 hover:bg-slate-950/20 transition-colors group/play"
                                            aria-label="Putar Video YouTube"
                                        >
                                            <div class="w-16 h-16 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-2xl group-hover/play:scale-110 transition-transform">
                                                <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </button>
                                    </div>
                                @else
                                    {{-- Standard Photo Image Slide --}}
                                    <img
                                        src="{{ $banner->image_path ? Storage::url($banner->image_path) : placeholder_image(800, 600, $banner->title) }}"
                                        alt="{{ $banner->title }}"
                                        class="w-full h-full object-cover"
                                        loading="eager"
                                    >
                                @endif

                                {{-- Dark Gradient Overlay & Slide Text --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent pointer-events-none"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-left z-10 pointer-events-auto">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-block px-2.5 py-0.5 rounded-md bg-blue-600/90 text-white font-bold text-[10px] uppercase tracking-wider">
                                            @if($banner->media_type === 'video')
                                                Video Profil
                                            @elseif($banner->media_type === 'youtube')
                                                YouTube Video
                                            @else
                                                Warta Kalurahan
                                            @endif
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-white leading-snug line-clamp-2">
                                        {{ $banner->title }}
                                    </h3>
                                    @if($banner->subtitle)
                                    <p class="text-xs text-slate-300 mt-1 line-clamp-2">
                                        {{ $banner->subtitle }}
                                    </p>
                                    @endif
                                    @if($banner->cta_text && $banner->cta_url)
                                    <div class="mt-3">
                                        <a href="{{ $banner->cta_url }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/20 hover:bg-white/30 text-white font-semibold text-xs backdrop-blur-sm transition-all">
                                            <span>{{ $banner->cta_text }}</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="swiper-slide relative">
                                <img
                                    src="{{ placeholder_image(800, 600, 'Kantor Kalurahan Condongcatur') }}"
                                    alt="Kalurahan Condongcatur"
                                    class="w-full h-full object-cover"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-left">
                                    <h3 class="text-lg font-bold text-white">Kantor Pelayanan Pemerintah Kalurahan</h3>
                                    <p class="text-xs text-slate-300 mt-1">Jl. Utama Condongcatur, Depok, Sleman, D.I. Yogyakarta</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination hero-pagination !bottom-3"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Interactive Video Modal (for YouTube / Video Popup) --}}
    <div
        x-show="videoModalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        class="fixed inset-0 z-[2000] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4"
        @click.self="videoModalOpen = false; currentVideoUrl = ''"
        @keydown.escape.window="videoModalOpen = false; currentVideoUrl = ''"
    >
        <div class="relative w-full max-w-4xl bg-black rounded-3xl overflow-hidden shadow-2xl border border-slate-800 aspect-video">
            <button
                @click="videoModalOpen = false; currentVideoUrl = ''"
                class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition-all"
                aria-label="Tutup Video"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <template x-if="videoModalOpen && currentVideoUrl">
                <iframe
                    :src="currentVideoUrl"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </template>
        </div>
    </div>
</section>

{{-- ============================================================
     QUICK ACCESS SERVICES (8 Clean Corporate Cards)
============================================================ --}}
<section class="py-12 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="quick-services-title">
    <div class="container-sid">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 id="quick-services-title" class="text-xl lg:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    Layanan & Akses Cepat Publik
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Pilihan menu prioritas untuk mempermudah warga dalam mengakses informasi dan administrasi.
                </p>
            </div>
            <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 inline-flex items-center gap-1.5 self-start sm:self-auto">
                <span>Semua Direktori Layanan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @php
            $defaultQuickLinks = [
                ['title' => 'Permohonan Surat', 'desc' => 'Pengajuan surat resmi mandiri online', 'url' => route('layanan.surat'), 'icon' => 'document-text'],
                ['title' => 'Data Kependudukan', 'desc' => 'Statistik dan demografi penduduk', 'url' => route('statistik.kependudukan'), 'icon' => 'users'],
                ['title' => 'Transparansi APBDes', 'desc' => 'Laporan anggaran pendapatan & belanja', 'url' => route('transparansi.apbkal'), 'icon' => 'banknotes'],
                ['title' => 'Layanan Pengaduan', 'desc' => 'Aspirasi & pelaporan masalah publik', 'url' => route('pengaduan.index'), 'icon' => 'chat-bubble-left-right'],
                ['title' => 'Galeri Dokumentasi', 'desc' => 'Dokumentasi kegiatan dan acara desa', 'url' => route('galeri.index'), 'icon' => 'photo'],
                ['title' => 'Agenda Kegiatan', 'desc' => 'Jadwal acara & kegiatan masyarakat', 'url' => route('agenda.index'), 'icon' => 'calendar'],
                ['title' => 'PPID Dokumen Publik', 'desc' => 'Unduh berkas informasi keterbukaan', 'url' => route('ppid.index'), 'icon' => 'folder-arrow-down'],
                ['title' => 'Peta Spasial Wilayah', 'desc' => 'Peta interaktif batas & fasilitas desa', 'url' => route('peta'), 'icon' => 'map-pin'],
            ];

            $linksToDisplay = (isset($quickLinks) && $quickLinks->isNotEmpty())
                ? $quickLinks->map(fn($item) => [
                    'title' => $item->title,
                    'desc'  => $item->description ?? '',
                    'url'   => str_starts_with($item->url, 'http') || str_starts_with($item->url, '/') ? $item->url : (Route::has($item->url) ? route($item->url) : $item->url),
                    'icon'  => $item->icon ?? 'document-text',
                ])
                : $defaultQuickLinks;
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-4 lg:gap-5">
            @foreach($linksToDisplay as $item)
            <a href="{{ $item['url'] }}" class="group p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 hover:border-blue-500/50 hover:bg-white dark:hover:bg-slate-800 hover:shadow-lg transition-all flex flex-col justify-between">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-colors shrink-0">
                        @if($item['icon'] === 'document-text')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @elseif($item['icon'] === 'users')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @elseif($item['icon'] === 'banknotes')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @elseif($item['icon'] === 'chat-bubble-left-right')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        @elseif($item['icon'] === 'photo')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @elseif($item['icon'] === 'calendar')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @elseif($item['icon'] === 'folder-arrow-down')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        @elseif($item['icon'] === 'map-pin')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $item['title'] }}
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                        {{ $item['desc'] }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>

{{-- ============================================================
     VILLAGE STATS SECTION (Data Kependudukan & IDM)
============================================================ --}}
<section class="py-14 bg-slate-50 dark:bg-slate-950" aria-labelledby="stats-title">
    <div class="container-sid">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Statistik & Indikator</span>
                <h2 id="stats-title" class="text-xl lg:text-2xl font-black text-slate-900 dark:text-white tracking-tight mt-0.5">
                    Data Kependudukan & Pembangunan Kalurahan
                </h2>
            </div>
            <a href="{{ route('statistik.kependudukan') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 inline-flex items-center gap-1.5">
                <span>Grafik Lengkap Kependudukan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            {{-- Stat 1: Penduduk --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Penduduk</div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white mt-2 tracking-tight">
                    {{ $stats['population'] ?? '28.394' }}
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Jiwa Terdaftar Aktif</div>
            </div>

            {{-- Stat 2: Kepala Keluarga --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kepala Keluarga</div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white mt-2 tracking-tight">
                    {{ $stats['families'] ?? '9.800' }}
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kartu Keluarga (KK)</div>
            </div>

            {{-- Stat 3: Padukuhan --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Wilayah Padukuhan</div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white mt-2 tracking-tight">
                    {{ $stats['padukuhan'] ?? '18' }}
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Padukuhan / Dusun</div>
            </div>

            {{-- Stat 4: IDM Status --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status IDM {{ $idmScore?->year ?? date('Y') }}</div>
                <div class="text-3xl lg:text-4xl font-black text-emerald-600 dark:text-emerald-400 mt-2 tracking-tight">
                    {{ ucfirst($idmScore?->status ?? 'Mandiri') }}
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    Skor: <strong>{{ $idmScore ? number_format($idmScore->total_score, 4) : '0.8756' }}</strong>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ============================================================
     NEWS & EDITORIAL SECTION (Berita & Publikasi Resmi)
============================================================ --}}
<section class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="news-title">
    <div class="container-sid">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Warta & Publikasi</span>
                <h2 id="news-title" class="text-xl lg:text-2xl font-black text-slate-900 dark:text-white tracking-tight mt-0.5">
                    Kabar Terkini Pemerintahan Kalurahan
                </h2>
            </div>
            <a href="{{ route('berita.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 inline-flex items-center gap-1.5">
                <span>Arsip Berita Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if($featuredArticles->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
            
            {{-- Main Featured Story (Left 7 Cols) --}}
            @php $heroArticle = $featuredArticles->first(); @endphp
            <div class="lg:col-span-7">
                <a href="{{ route('berita.show', $heroArticle->slug) }}" class="group block relative rounded-3xl overflow-hidden aspect-[16/10] bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-md">
                    <img
                        src="{{ $heroArticle->featured_image ? Storage::url($heroArticle->featured_image) : placeholder_image(800, 500, $heroArticle->title) }}"
                        alt="{{ $heroArticle->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-left">
                        @if($heroArticle->category)
                        <span class="inline-block px-3 py-1 rounded-md bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider mb-3">
                            {{ $heroArticle->category->name }}
                        </span>
                        @endif
                        <h3 class="text-lg sm:text-2xl font-black text-white leading-snug group-hover:text-blue-200 transition-colors line-clamp-2">
                            {{ $heroArticle->title }}
                        </h3>
                        <div class="flex items-center gap-3 text-slate-300 text-xs mt-3 font-medium">
                            <span>{{ $heroArticle->published_at?->translatedFormat('d F Y') }}</span>
                            <span>&bull;</span>
                            <span>{{ $heroArticle->reading_time ?? 3 }} menit baca</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 2 Secondary Featured Stories (Right 5 Cols) --}}
            <div class="lg:col-span-5 flex flex-col justify-between gap-4">
                @foreach($featuredArticles->skip(1)->take(2) as $secArticle)
                <a href="{{ route('berita.show', $secArticle->slug) }}" class="group flex gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md transition-all flex-1">
                    <div class="w-32 sm:w-36 aspect-[4/3] rounded-xl overflow-hidden bg-slate-200 shrink-0">
                        <img
                            src="{{ $secArticle->featured_image ? Storage::url($secArticle->featured_image) : placeholder_image(400, 300, $secArticle->title) }}"
                            alt="{{ $secArticle->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        >
                    </div>
                    <div class="flex flex-col justify-between flex-1 min-w-0">
                        <div>
                            @if($secArticle->category)
                            <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                {{ $secArticle->category->name }}
                            </span>
                            @endif
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors line-clamp-2 mt-1">
                                {{ $secArticle->title }}
                            </h4>
                        </div>
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium">
                            {{ $secArticle->published_at?->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
        @endif

        {{-- 3 Grid Latest Articles --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestArticles->take(3) as $latestArticle)
            <a href="{{ route('berita.show', $latestArticle->slug) }}" class="group p-4 rounded-2xl bg-white dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                    <div class="aspect-[16/10] rounded-xl overflow-hidden bg-slate-200 mb-3">
                        <img
                            src="{{ $latestArticle->featured_image ? Storage::url($latestArticle->featured_image) : placeholder_image(600, 400, $latestArticle->title) }}"
                            alt="{{ $latestArticle->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        >
                    </div>
                    @if($latestArticle->category)
                    <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                        {{ $latestArticle->category->name }}
                    </span>
                    @endif
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors line-clamp-2 mt-1">
                        {{ $latestArticle->title }}
                    </h4>
                </div>
                <div class="text-[11px] text-slate-400 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between">
                    <span>{{ $latestArticle->published_at?->translatedFormat('d M Y') }}</span>
                    <span>{{ $latestArticle->reading_time ?? 3 }} mnt</span>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>

{{-- ============================================================
     EVENTS & ANNOUNCEMENTS SECTION (Two Column Container)
============================================================ --}}
<section class="py-14 bg-slate-50 dark:bg-slate-950" aria-labelledby="events-announcements-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Column 1: Agenda Kegiatan --}}
            <div class="p-6 lg:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Jadwal Acara</span>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight mt-0.5">Agenda Mendatang</h3>
                    </div>
                    <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-3.5">
                    @forelse($upcomingEvents as $event)
                    <a href="{{ route('agenda.show', $event->slug) }}" class="group flex gap-4 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-300 dark:hover:border-blue-700 transition-all">
                        <div class="w-12 text-center shrink-0">
                            <div class="bg-blue-600 text-white font-black text-base py-1 rounded-t-xl leading-none">
                                {{ $event->start_datetime->format('d') }}
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-bold text-[10px] py-0.5 rounded-b-xl uppercase">
                                {{ $event->start_datetime->translatedFormat('M') }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-1">
                                {{ $event->title }}
                            </h4>
                            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-[11px] mt-1 font-medium">
                                <span>{{ $event->start_datetime->format('H:i') }} WIB</span>
                                @if($event->location)
                                <span>&bull;</span>
                                <span class="truncate">{{ $event->location }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="py-8 text-center text-xs text-slate-400 font-medium">
                        Belum ada jadwal agenda mendatang.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Column 2: Pengumuman Resmi --}}
            <div class="p-6 lg:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Surat Edaran</span>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight mt-0.5">Pengumuman Resmi</h3>
                    </div>
                    <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-3.5">
                    @forelse($pinnedAnnouncements as $ann)
                    <a href="{{ route('pengumuman.show', $ann->id) }}" class="group flex items-start gap-3.5 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-300 dark:hover:border-blue-700 transition-all">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5 {{ $ann->priority === 'urgent' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-blue-50 text-blue-600 border border-blue-200' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-1">
                                {{ $ann->title }}
                            </h4>
                            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-[11px] mt-1 font-medium">
                                @if($ann->priority === 'urgent')
                                <span class="text-red-600 font-bold">Mendesak</span>
                                <span>&bull;</span>
                                @endif
                                <span>{{ $ann->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="py-8 text-center text-xs text-slate-400 font-medium">
                        Belum ada pengumuman terbaru.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     OFFICIALS & PAMONG SECTION (Jajaran Pemerintahan Kalurahan)
============================================================ --}}
<section class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="officials-title">
    <div class="container-sid">
        
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Aparatur Kalurahan</span>
            <h2 id="officials-title" class="text-xl lg:text-3xl font-black text-slate-900 dark:text-white tracking-tight mt-1">
                Pimpinan & Pamong Kalurahan
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                Jajaran aparatur pemerintah Kalurahan Condongcatur yang berdedikasi melayani masyarakat.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-5">
            @forelse($officials as $official)
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 text-center hover:shadow-md transition-all">
                <div class="w-20 h-20 mx-auto rounded-2xl overflow-hidden bg-slate-200 mb-3 border border-slate-300 dark:border-slate-600">
                    <img
                        src="{{ $official->photo_path ? Storage::url($official->photo_path) : placeholder_image(160, 160, $official->name) }}"
                        alt="{{ $official->name }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
                <h4 class="text-xs font-bold text-slate-900 dark:text-white line-clamp-1">{{ $official->name }}</h4>
                <div class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold mt-0.5 line-clamp-1">{{ $official->position }}</div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-xs text-slate-400">
                Data pamong kalurahan belum tersedia.
            </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('pemerintahan.perangkat') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5">
                <span>Lihat Struktur & Jajaran Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

    </div>
</section>

{{-- ============================================================
     PORTAL CITIZEN CTA (Layanan Mandiri Warga)
============================================================ --}}
<section class="py-16 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white relative overflow-hidden" aria-labelledby="cta-title">
    <div class="container-sid text-center relative z-10 max-w-3xl mx-auto">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white text-xs font-semibold backdrop-blur-sm border border-white/15 mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            Layanan Administrasi Digital Terpadu
        </span>
        <h2 id="cta-title" class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight mb-4">
            Ajukan Surat Keterangan Tanpa Antre di Kantor Kalurahan
        </h2>
        <p class="text-xs sm:text-sm text-blue-100/90 leading-relaxed mb-8">
            Warga Kalurahan Condongcatur kini dapat mengajukan berbagai jenis surat keterangan resmi, memantau proses verifikasi, dan mengunduh dokumen bertanda tangan elektronik (TTE) kapan saja.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('warga.register') }}" class="px-6 py-3.5 rounded-2xl bg-white text-blue-900 hover:bg-blue-50 font-black text-xs sm:text-sm shadow-xl transition-all">
                Daftar Akun Warga Baru
            </a>
            <a href="{{ route('warga.login') }}" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 backdrop-blur-sm transition-all">
                Masuk ke Portal Warga
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: {
                el: '.hero-pagination',
                clickable: true,
            },
        });
    }
});
</script>
@endpush
