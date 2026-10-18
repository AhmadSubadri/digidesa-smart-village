@extends('layouts.app')

@section('title', 'Beranda Resmi')
@section('description', 'Website Resmi Pemerintah Desa — Pusat informasi publik, layanan administrasi kependudukan mandiri, dan transparansi tata kelola desa.')

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
                    <span>{{ setting('village_name', 'Pemerintah Desa') }}</span>
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
                                        poster="{{ storage_or_placeholder($banner->image_path, 800, 600, $banner->title) }}"
                                    >
                                        <source src="{{ Storage::url($banner->video_path) }}" type="video/mp4">
                                    </video>
                                @elseif($banner->media_type === 'youtube' && $banner->video_url)
                                    {{-- YouTube Video Slide / Embed Preview --}}
                                    <div class="relative w-full h-full">
                                        <img
                                            src="{{ storage_or_placeholder($banner->image_path, 800, 600, $banner->title) }}"
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
                                        src="{{ storage_or_placeholder($banner->image_path, 800, 600, $banner->title) }}"
                                        alt="{{ $banner->title }}"
                                        class="w-full h-full object-cover"
                                        loading="eager"
                                    >
                                @endif

                                {{-- Dark Gradient Overlay & Slide Text --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent pointer-events-none"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-left z-10 pointer-events-auto">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-block px-2.5 py-0.5 rounded-md bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider shadow-sm">
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
                                    <p class="text-xs text-slate-200 mt-1 line-clamp-2 font-medium">
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
                                    src="{{ placeholder_image(800, 600, 'Kantor Pemerintah Desa') }}"
                                    alt="Kantor Desa"
                                    class="w-full h-full object-cover"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-left">
                                    <h3 class="text-lg font-bold text-white">Kantor Pelayanan Pemerintah Desa</h3>
                                    <p class="text-xs text-slate-200 mt-1">{{ setting('contact_address', 'Jl. Raya Kantor Pemerintah Desa') }}</p>
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
     SUPER-APP QUICK ACTION LAUNCHER (Mobile & Desktop App-Grid)
============================================================ --}}
<section class="-mt-8 lg:-mt-12 relative z-20 mb-12" aria-labelledby="quick-services-title">
    <div class="container-sid">
        
        {{-- Elevated Super-App Glass Container --}}
        <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-900/5 dark:shadow-none">
            
            {{-- Header Row --}}
            <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-6 rounded-full bg-gradient-to-b from-blue-600 to-indigo-600"></div>
                    <div>
                        <h2 id="quick-services-title" class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                            Layanan Mandiri & Akses Cepat Warga
                        </h2>
                        <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400">
                            Pilih menu layanan digital terpadu {{ setting('village_name', 'desa') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('layanan.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-50 dark:bg-slate-800 hover:bg-blue-100 dark:hover:bg-slate-700 text-blue-700 dark:text-blue-300 text-xs font-bold transition-all shrink-0">
                    <span>Semua Layanan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @php
                $defaultQuickLinks = [
                    ['title' => 'Surat Mandiri', 'desc' => 'Buat surat online', 'url' => route('layanan.surat'), 'icon' => 'document-text', 'bg' => 'from-blue-500 to-indigo-600', 'shadow' => 'shadow-blue-500/25'],
                    ['title' => 'Kependudukan', 'desc' => 'Data statistik warga', 'url' => route('statistik.kependudukan'), 'icon' => 'users', 'bg' => 'from-emerald-500 to-teal-600', 'shadow' => 'shadow-emerald-500/25'],
                    ['title' => 'APBDes / APBKal', 'desc' => 'Transparansi anggaran', 'url' => route('transparansi.apbkal'), 'icon' => 'banknotes', 'bg' => 'from-amber-500 to-orange-600', 'shadow' => 'shadow-amber-500/25'],
                    ['title' => 'Pengaduan', 'desc' => 'Aspirasi & lapor', 'url' => route('pengaduan.index'), 'icon' => 'chat-bubble-left-right', 'bg' => 'from-rose-500 to-red-600', 'shadow' => 'shadow-rose-500/25'],
                    ['title' => 'Galeri Foto', 'desc' => 'Dokumentasi acara', 'url' => route('galeri.index'), 'icon' => 'photo', 'bg' => 'from-purple-500 to-indigo-600', 'shadow' => 'shadow-purple-500/25'],
                    ['title' => 'Agenda Desa', 'desc' => 'Jadwal kegiatan', 'url' => route('agenda.index'), 'icon' => 'calendar', 'bg' => 'from-sky-500 to-blue-600', 'shadow' => 'shadow-sky-500/25'],
                    ['title' => 'PPID Dokumen', 'desc' => 'Berkas publik resmi', 'url' => route('ppid.index'), 'icon' => 'folder-arrow-down', 'bg' => 'from-slate-700 to-slate-900', 'shadow' => 'shadow-slate-500/25'],
                    ['title' => 'Peta Spasial', 'desc' => 'Peta wilayah desa', 'url' => route('peta'), 'icon' => 'map-pin', 'bg' => 'from-teal-500 to-cyan-600', 'shadow' => 'shadow-teal-500/25'],
                ];

                $linksToDisplay = (isset($quickLinks) && $quickLinks->isNotEmpty())
                    ? $quickLinks->map(function($item, $index) use ($defaultQuickLinks) {
                        $fallback = $defaultQuickLinks[$index % count($defaultQuickLinks)];
                        return [
                            'title'  => $item->title,
                            'desc'   => $item->description ?? $fallback['desc'],
                            'url'    => str_starts_with($item->url, 'http') || str_starts_with($item->url, '/') ? $item->url : (Route::has($item->url) ? route($item->url) : $item->url),
                            'icon'   => $item->icon ?? $fallback['icon'],
                            'bg'     => $fallback['bg'],
                            'shadow' => $fallback['shadow'],
                        ];
                    })
                    : $defaultQuickLinks;
            @endphp

            {{-- 8-App Mobile Launcher Grid --}}
            <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4 lg:gap-5">
                @foreach($linksToDisplay as $item)
                <a href="{{ $item['url'] }}" class="group flex flex-col items-center text-center p-2 sm:p-2.5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-all duration-200">
                    
                    {{-- App-Style Icon Squircle with Micro-Animation --}}
                    <div class="w-13 h-13 sm:w-15 sm:h-15 w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-br {{ $item['bg'] }} text-white flex items-center justify-center shadow-lg {{ $item['shadow'] }} group-hover:scale-110 group-hover:-translate-y-1.5 transition-all duration-300 shrink-0">
                        @php
                            $iconName = strtolower($item['icon'] ?? '');
                        @endphp
                        @if(str_contains($iconName, 'document') || str_contains($iconName, 'surat') || str_contains($iconName, 'text'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @elseif(str_contains($iconName, 'user') || str_contains($iconName, 'penduduk') || str_contains($iconName, 'people'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @elseif(str_contains($iconName, 'banknote') || str_contains($iconName, 'money') || str_contains($iconName, 'apb') || str_contains($iconName, 'currency'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @elseif(str_contains($iconName, 'megaphone') || str_contains($iconName, 'chat') || str_contains($iconName, 'pengaduan') || str_contains($iconName, 'bubble'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        @elseif(str_contains($iconName, 'photo') || str_contains($iconName, 'image') || str_contains($iconName, 'galeri') || str_contains($iconName, 'picture'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @elseif(str_contains($iconName, 'calendar') || str_contains($iconName, 'agenda') || str_contains($iconName, 'event') || str_contains($iconName, 'clock'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @elseif(str_contains($iconName, 'folder') || str_contains($iconName, 'ppid') || str_contains($iconName, 'download') || str_contains($iconName, 'archive'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        @elseif(str_contains($iconName, 'map') || str_contains($iconName, 'pin') || str_contains($iconName, 'location') || str_contains($iconName, 'peta'))
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @else
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="mt-2 text-center w-full">
                        <span class="text-xs sm:text-xs font-bold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-1 block transition-colors">
                            {{ $item['title'] }}
                        </span>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 line-clamp-1 hidden sm:block mt-0.5">
                            {{ $item['desc'] }}
                        </span>
                    </div>

                </a>
                @endforeach
            </div>

        </div>

    </div>
</section>

{{-- ============================================================
     VILLAGE STATS & INDICATORS DASHBOARD (Data Kependudukan & IDM)
============================================================ --}}
<section class="py-16 bg-slate-50/80 dark:bg-slate-950 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="stats-title">
    <div class="container-sid">
        
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/80 text-blue-700 dark:text-blue-300 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                    Transparansi Data Desa
                </span>
                <h2 id="stats-title" class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Statistik & Indikator Pembangunan Kalurahan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1">
                    Ringkasan data agregat kependudukan dan status capaian kemandirian {{ setting('village_name', 'desa') }} secara berkala.
                </p>
            </div>
            <div class="flex items-center gap-2.5 self-start sm:self-auto shrink-0">
                <a href="{{ route('statistik.kependudukan') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/20 transition-all">
                    <span>Grafik Kependudukan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </a>
            </div>
        </div>

        {{-- 4 Primary Metric Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            {{-- Stat 1: Total Penduduk --}}
            <div class="relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Penduduk</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $stats['population'] ?? '28.394' }}
                </div>
                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Aktif
                    </span>
                    <span>• Jiwa Terdaftar Resmi</span>
                </div>
            </div>

            {{-- Stat 2: Kepala Keluarga (KK) --}}
            <div class="relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kepala Keluarga</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $stats['families'] ?? '9.800' }}
                </div>
                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>Kartu Keluarga (KK)</span>
                </div>
            </div>

            {{-- Stat 3: Wilayah Padukuhan --}}
            <div class="relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Wilayah Kewilayahan</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $stats['padukuhan'] ?? '18' }}
                </div>
                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>Padukuhan • Luas {{ $stats['area'] ?? '948,6' }} Ha</span>
                </div>
            </div>

            {{-- Stat 4: Status IDM --}}
            <div class="relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status IDM {{ $idmScore?->year ?? date('Y') }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight flex items-center gap-2">
                    <span>{{ ucfirst($idmScore?->status ?? 'Mandiri') }}</span>
                </div>
                <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>Skor Indeks:</span>
                    <strong class="text-slate-900 dark:text-white font-bold">{{ $idmScore ? number_format($idmScore->total_score, 4) : '0.8756' }}</strong>
                </div>
            </div>

        </div>

        {{-- 2-Column Insight Visual Widget (Demografi Gender + IDM 3 Pilar) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Kolom Kiri (7 Cols): Komposisi Gender & Piramida Ringkas --}}
            <div class="lg:col-span-6 p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <span class="text-[11px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Demografi Penduduk</span>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight mt-0.5">
                                Komposisi Gender Penduduk
                            </h3>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold">
                            Total: {{ $stats['population'] ?? '28.394' }} Jiwa
                        </span>
                    </div>

                    {{-- Visual Progress Distribution Bar --}}
                    <div class="space-y-3 pt-2">
                        <div class="h-4 w-full rounded-full overflow-hidden flex bg-slate-100 dark:bg-slate-800 p-0.5 shadow-inner">
                            <div class="h-full rounded-l-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-500" style="width: {{ $stats['male_pct'] ?? 49.7 }}%"></div>
                            <div class="h-full rounded-r-full bg-gradient-to-r from-pink-500 to-rose-500 transition-all duration-500" style="width: {{ $stats['female_pct'] ?? 50.3 }}%"></div>
                        </div>

                        {{-- Metric Breakdown --}}
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-2xl bg-blue-50/60 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/50">
                                <div class="flex items-center gap-2 text-blue-700 dark:text-blue-300 text-xs font-bold">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>Laki-Laki</span>
                                </div>
                                <div class="text-xl font-black text-slate-900 dark:text-white mt-1.5">
                                    {{ $stats['male'] ?? '14.120' }} <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                                </div>
                                <div class="text-xs text-blue-600 dark:text-blue-400 font-bold mt-0.5">
                                    {{ $stats['male_pct'] ?? 49.7 }}% dari total
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-rose-50/60 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/50">
                                <div class="flex items-center gap-2 text-rose-700 dark:text-rose-300 text-xs font-bold">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                    <span>Perempuan</span>
                                </div>
                                <div class="text-xl font-black text-slate-900 dark:text-white mt-1.5">
                                    {{ $stats['female'] ?? '14.274' }} <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                                </div>
                                <div class="text-xs text-rose-600 dark:text-rose-400 font-bold mt-0.5">
                                    {{ $stats['female_pct'] ?? 50.3 }}% dari total
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400">Pembaruan data sensus semester berjalan</span>
                    <a href="{{ route('statistik.kependudukan') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        <span>Piramida Penduduk</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan (6 Cols): 3 Pilar Utama Indeks Desa Membangun (IDM) --}}
            <div class="lg:col-span-6 p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Kemandirian Kalurahan</span>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight mt-0.5">
                                3 Pilar Indeks Desa Membangun (IDM)
                            </h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-xs font-black">
                            {{ ucfirst($idmScore?->status ?? 'Mandiri') }}
                        </span>
                    </div>

                    {{-- 3 IDM Pillar Bars --}}
                    <div class="space-y-3.5 pt-1">
                        
                        {{-- IKS (Sosial) --}}
                        <div>
                            <div class="flex justify-between text-xs font-bold mb-1.5">
                                <span class="text-slate-800 dark:text-slate-200">Indeks Ketahanan Sosial (IKS)</span>
                                <span class="text-blue-600 dark:text-blue-400">{{ $idmScore ? number_format($idmScore->iks_score ?? 0.9200, 4) : '0.9200' }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ ($idmScore->iks_score ?? 0.92) * 100 }}%"></div>
                            </div>
                        </div>

                        {{-- IKE (Ekonomi) --}}
                        <div>
                            <div class="flex justify-between text-xs font-bold mb-1.5">
                                <span class="text-slate-800 dark:text-slate-200">Indeks Ketahanan Ekonomi (IKE)</span>
                                <span class="text-amber-600 dark:text-amber-400">{{ $idmScore ? number_format($idmScore->ike_score ?? 0.8100, 4) : '0.8100' }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ ($idmScore->ike_score ?? 0.81) * 100 }}%"></div>
                            </div>
                        </div>

                        {{-- IKL (Lingkungan) --}}
                        <div>
                            <div class="flex justify-between text-xs font-bold mb-1.5">
                                <span class="text-slate-800 dark:text-slate-200">Indeks Ketahanan Lingkungan (IKL)</span>
                                <span class="text-emerald-600 dark:text-emerald-400">{{ $idmScore ? number_format($idmScore->ikl_score ?? 0.8967, 4) : '0.8967' }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ ($idmScore->ikl_score ?? 0.8967) * 100 }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400">Kementerian Desa PDTT RI</span>
                    <a href="{{ route('statistik.idm') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                        <span>Lihat Rincian IDM</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ============================================================
     NEWS & EDITORIAL SECTION (Berita & Publikasi Resmi)
============================================================ --}}
<section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="news-title">
    <div class="container-sid">
        
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                    Warta & Publikasi
                </span>
                <h2 id="news-title" class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Kabar Terkini Pemerintahan Kalurahan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Informasi resmi, liputan kegiatan pembangunan, dan berita seputar {{ setting('village_name', 'desa') }}.
                </p>
            </div>
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/50 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 text-xs font-bold transition-all shrink-0">
                <span>Arsip Berita Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($featuredArticles->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
            
            {{-- Main Featured Story (Left 7 Cols) --}}
            @php $heroArticle = $featuredArticles->first(); @endphp
            <div class="lg:col-span-7">
                <a href="{{ route('berita.show', $heroArticle->slug) }}" class="group block relative rounded-3xl overflow-hidden aspect-[16/10] bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-300">
                    <img
                        src="{{ storage_or_placeholder($heroArticle->featured_image, 900, 560, $heroArticle->title) }}"
                        alt="{{ $heroArticle->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-left">
                        @if($heroArticle->category)
                        <span class="inline-block px-3 py-1 rounded-lg bg-blue-600 text-white font-bold text-[11px] uppercase tracking-wider mb-3 shadow-sm">
                            {{ $heroArticle->category->name }}
                        </span>
                        @endif
                        <h3 class="text-lg sm:text-2xl font-black text-white leading-snug group-hover:text-blue-200 transition-colors line-clamp-2">
                            {{ $heroArticle->title }}
                        </h3>
                        <div class="flex items-center gap-3 text-slate-300 text-xs mt-3 font-medium">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $heroArticle->published_at?->translatedFormat('d F Y') }}
                            </span>
                            <span>&bull;</span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $heroArticle->reading_time ?? 3 }} menit baca
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 2 Secondary Featured Stories (Right 5 Cols) --}}
            <div class="lg:col-span-5 flex flex-col justify-between gap-4">
                @foreach($featuredArticles->skip(1)->take(2) as $secArticle)
                <a href="{{ route('berita.show', $secArticle->slug) }}" class="group flex gap-4 p-4 rounded-3xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 hover:bg-white dark:hover:bg-slate-800 hover:shadow-lg transition-all flex-1">
                    <div class="w-32 sm:w-36 aspect-[4/3] rounded-2xl overflow-hidden bg-slate-200 shrink-0">
                        <img
                            src="{{ storage_or_placeholder($secArticle->featured_image, 400, 300, $secArticle->title) }}"
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
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium flex items-center gap-1.5">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $secArticle->published_at?->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
        @endif

        {{-- Latest Articles Grid (3 Cards) --}}
        @if($latestArticles->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestArticles->take(3) as $latestArticle)
            <a href="{{ route('berita.show', $latestArticle->slug) }}" class="group p-4 rounded-3xl bg-white dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 hover:shadow-xl transition-all flex flex-col justify-between">
                <div>
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-200 mb-3.5">
                        <img
                            src="{{ storage_or_placeholder($latestArticle->featured_image, 600, 400, $latestArticle->title) }}"
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
                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between">
                    <span>{{ $latestArticle->published_at?->translatedFormat('d M Y') }}</span>
                    <span>{{ $latestArticle->reading_time ?? 3 }} mnt baca</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center rounded-3xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 text-xs text-slate-400 font-medium">
            Belum ada warta atau berita publikasi terbaru.
        </div>
        @endif

    </div>
</section>

{{-- ============================================================
     EVENTS & ANNOUNCEMENTS SECTION (Two Column Container)
============================================================ --}}
<section class="py-16 bg-slate-50/80 dark:bg-slate-950 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="events-announcements-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Column 1: Agenda Kegiatan --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="text-[11px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Jadwal Acara</span>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight">Agenda Mendatang</h3>
                            </div>
                        </div>
                        <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($upcomingEvents as $event)
                        <a href="{{ route('agenda.show', $event->slug) }}" class="group flex gap-4 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-white dark:hover:bg-slate-800 transition-all">
                            <div class="w-13 text-center shrink-0 rounded-2xl overflow-hidden border border-blue-200 dark:border-blue-800 shadow-sm">
                                <div class="bg-gradient-to-b from-blue-600 to-indigo-700 text-white font-black text-base py-1 leading-none">
                                    {{ $event->start_datetime->format('d') }}
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-bold text-[10px] py-1 uppercase tracking-wider">
                                    {{ $event->start_datetime->translatedFormat('M') }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $event->title }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-2 text-slate-500 dark:text-slate-400 text-[11px] mt-1.5 font-medium">
                                    <span class="flex items-center gap-1 text-slate-600 dark:text-slate-300">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $event->start_datetime->format('H:i') }} WIB
                                    </span>
                                    @if($event->location)
                                    <span>&bull;</span>
                                    <span class="truncate flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        {{ $event->location }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="py-10 text-center text-xs text-slate-400 font-medium">
                            Belum ada jadwal agenda mendatang.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Column 2: Pengumuman Resmi --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            </div>
                            <div>
                                <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Surat Edaran</span>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight">Pengumuman Resmi</h3>
                            </div>
                        </div>
                        <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($pinnedAnnouncements as $ann)
                        <a href="{{ route('pengumuman.show', $ann->id) }}" class="group flex items-start gap-3.5 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 hover:border-amber-300 dark:hover:border-amber-700 hover:bg-white dark:hover:bg-slate-800 transition-all">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5 {{ $ann->priority === 'urgent' ? 'bg-red-100 text-red-600 dark:bg-red-950 dark:text-red-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-950 dark:text-blue-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors line-clamp-1">
                                    {{ $ann->title }}
                                </h4>
                                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-[11px] mt-1 font-medium">
                                    @if($ann->priority === 'urgent')
                                    <span class="inline-flex items-center gap-1 text-red-600 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                                        Mendesak
                                    </span>
                                    <span>&bull;</span>
                                    @endif
                                    <span>{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="py-10 text-center text-xs text-slate-400 font-medium">
                            Belum ada pengumuman terbaru.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     TRANSPARANSI APBKAL (Anggaran Pendapatan & Belanja Kalurahan)
============================================================ --}}
<section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="apbkal-title">
    <div class="container-sid">
        
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
            {{-- Background decorative elements --}}
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                {{-- Header --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8 pb-6 border-b border-white/10">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-2 border border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Transparansi Anggaran Publik
                        </span>
                        <h2 id="apbkal-title" class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight">
                            APBKal {{ $budget?->fiscal_year ?? date('Y') }} — Akuntabel & Terbuka
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1">
                            Laporan realisasi dan alokasi Anggaran Pendapatan & Belanja {{ setting('village_name', setting('site_name', 'Pemerintah Desa')) }}.
                        </p>
                    </div>
                    <a href="{{ route('transparansi.apbkal') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white text-slate-950 hover:bg-blue-50 text-xs font-black shadow-lg transition-all self-start lg:self-auto shrink-0">
                        <span>Rincian Lengkap APBKal</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- 3 Summary Metric Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    {{-- Pendapatan --}}
                    <div class="p-5 sm:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Pendapatan Kalurahan</span>
                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-black text-white">
                            Rp {{ number_format($budget?->total_income ?? 8450000000, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 mt-1">Target Pendapatan Bersih TA {{ $budget?->fiscal_year ?? date('Y') }}</div>
                    </div>

                    {{-- Belanja --}}
                    <div class="p-5 sm:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Belanja Kalurahan</span>
                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-black text-white">
                            Rp {{ number_format($budget?->total_expense ?? 8210000000, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 mt-1">Alokasi Penyelenggaraan & Pembangunan</div>
                    </div>

                    {{-- Pembiayaan --}}
                    <div class="p-5 sm:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <span class="text-xs font-bold text-sky-400 uppercase tracking-wider">Pembiayaan Netto</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-black text-white">
                            Rp {{ number_format($budget?->total_financing ?? 240000000, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 mt-1">Sisa Lebih Perhitungan Anggaran (SiLPA)</div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

{{-- ============================================================
     OFFICIALS & PAMONG SECTION (Jajaran Pemerintahan Kalurahan)
============================================================ --}}
<section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800" aria-labelledby="officials-title">
    <div class="container-sid">
        
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-wider mb-2">
                <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                Aparatur Kalurahan
            </span>
            <h2 id="officials-title" class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                Pimpinan & Pamong Kalurahan
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                Jajaran aparatur pemerintah {{ setting('village_name', 'desa') }} yang berdedikasi melayani seluruh lapisan masyarakat.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-5">
            @forelse($officials as $official)
            <div class="group p-4 rounded-3xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 text-center hover:bg-white dark:hover:bg-slate-800 hover:shadow-xl transition-all duration-300">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl overflow-hidden bg-slate-200 mb-3.5 border-2 border-slate-100 dark:border-slate-700 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                    <img
                        src="{{ storage_or_placeholder($official->photo_path, 200, 200, $official->name) }}"
                        alt="{{ $official->name }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
                <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $official->name }}</h4>
                <div class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold mt-0.5 line-clamp-1">{{ $official->position }}</div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-xs text-slate-400">
                Data pamong kalurahan belum tersedia.
            </div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('pemerintahan.perangkat') }}" class="px-6 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-2 shadow-sm">
                <span>Lihat Struktur & Jajaran Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</section>

{{-- ============================================================
     PORTAL CITIZEN CTA (Layanan Mandiri Warga)
============================================================ --}}
<section class="py-20 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-white relative overflow-hidden border-t border-slate-800" aria-labelledby="cta-title">
    {{-- Decorative Glow Background --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container-sid text-center relative z-10 max-w-3xl mx-auto">
        
        {{-- Pill Badge --}}
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/15 text-blue-200 text-xs font-bold backdrop-blur-md border border-blue-400/25 mb-5 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Layanan Administrasi Digital Terpadu
        </span>

        {{-- Heading --}}
        <h2 id="cta-title" class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight mb-4">
            Ajukan Surat Keterangan Tanpa Antre di Kantor Kalurahan
        </h2>

        {{-- Subtitle --}}
        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-8 max-w-2xl mx-auto font-medium">
            Warga {{ setting('village_name', 'desa') }} kini dapat mengajukan surat keterangan resmi secara daring, memantau proses verifikasi secara real-time, dan mengunduh berkas bertanda tangan elektronik (TTE) resmi kapan saja.
        </p>

        {{-- High Contrast Action Buttons --}}
        <div class="flex flex-wrap items-center justify-center gap-4 mb-10">
            <a href="{{ route('warga.register') }}" class="px-8 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-blue-600/30 transition-all hover:scale-105 border border-blue-400/30 inline-flex items-center gap-2">
                <span>Daftar Akun Warga Baru</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('warga.login') }}" class="px-8 py-3.5 rounded-2xl bg-slate-800/80 hover:bg-slate-700/80 text-white font-bold text-xs sm:text-sm border border-slate-600/60 backdrop-blur-md transition-all hover:scale-105 inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span>Masuk ke Portal Warga</span>
            </a>
        </div>

        {{-- Trust Feature Indicators --}}
        <div class="grid grid-cols-3 gap-3 pt-6 border-t border-white/10 text-center max-w-xl mx-auto">
            <div class="flex flex-col items-center">
                <div class="text-emerald-400 text-sm font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Layanan 24 Jam</span>
                </div>
                <span class="text-[10px] text-slate-400 mt-0.5">Pengajuan kapan saja</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-blue-400 text-sm font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>TTE Resmi</span>
                </div>
                <span class="text-[10px] text-slate-400 mt-0.5">Tanda tangan tersertifikasi</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-amber-400 text-sm font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>100% Bebas Biaya</span>
                </div>
                <span class="text-[10px] text-slate-400 mt-0.5">Tanpa pungutan liar</span>
            </div>
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
