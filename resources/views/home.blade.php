@extends('layouts.app')

@section('title', 'Beranda')
@section('description', 'Website Resmi Kalurahan Condongcatur — Pusat informasi, layanan publik, data kependudukan, dan transparansi pemerintahan kalurahan.')

@section('content')

{{-- ============================================================
     HERO SECTION (Swiper Slider)
============================================================ --}}
<section class="hero-section" aria-label="Hero Banner" id="hero">
    <div class="swiper hero-swiper h-full">
        <div class="swiper-wrapper">

            @forelse($banners as $banner)
            <div class="swiper-slide">
                <div class="hero-slide overlay-{{ $banner->text_position ?? 'left' }} h-full">
                    {{-- Background Image --}}
                    <img
                        src="{{ $banner->image_path ? Storage::url($banner->image_path) : asset('images/hero-default.jpg') }}"
                        alt="{{ $banner->title }}"
                        class="hero-img"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        onerror="this.src='https://picsum.photos/1920/1080?random={{ $loop->index }}'"
                    >

                    {{-- Content --}}
                    <div class="hero-content">
                        <div class="container-sid w-full">
                            <div class="max-w-2xl {{ $banner->text_position === 'right' ? 'ml-auto text-right' : ($banner->text_position === 'center' ? 'mx-auto text-center' : '') }}">
                                <span class="inline-flex items-center gap-2 glass text-white/90 text-xs font-semibold px-3 py-1.5 rounded-full mb-4 animate-fade-in-up">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-ping"></span>
                                    Kalurahan Condongcatur
                                </span>
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4 animate-fade-in-up" style="animation-delay: 0.1s">
                                    {{ $banner->title }}
                                </h1>
                                @if($banner->subtitle)
                                <p class="text-lg text-white/80 leading-relaxed mb-8 animate-fade-in-up" style="animation-delay: 0.2s">
                                    {{ $banner->subtitle }}
                                </p>
                                @endif
                                <div class="flex flex-wrap gap-3 animate-fade-in-up {{ $banner->text_position === 'center' ? 'justify-center' : ($banner->text_position === 'right' ? 'justify-end' : '') }}" style="animation-delay: 0.3s">
                                    @if($banner->cta_text)
                                    <a href="{{ $banner->cta_url ?? '#' }}" class="btn btn-primary" id="hero-cta-{{ $loop->index }}">
                                        {{ $banner->cta_text }}
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                    @endif
                                    @if($banner->cta_secondary_text)
                                    <a href="{{ $banner->cta_secondary_url ?? '#' }}" class="btn btn-secondary" id="hero-cta2-{{ $loop->index }}">
                                        {{ $banner->cta_secondary_text }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            {{-- Fallback Slide --}}
            <div class="swiper-slide">
                <div class="hero-slide overlay-left h-full" style="background: linear-gradient(135deg, #1B4F8A 0%, #1565C0 50%, #0EA5E9 100%);">
                    <div class="hero-content">
                        <div class="container-sid w-full">
                            <div class="max-w-2xl">
                                <span class="inline-flex items-center gap-2 glass text-white/90 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-ping"></span>
                                    {{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Desa') }}
                                </span>
                                <h1 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4">
                                    Selamat Datang di Portal Digital<br>
                                    <span style="color: #F39C12;">{{ \App\Services\SettingService::getValue('village_name', 'Smart Village') }}</span>
                                </h1>
                                <p class="text-xl text-white/80 leading-relaxed mb-8">
                                    Melayani dengan hati, membangun bersama warga untuk desa yang lebih maju, transparan, dan sejahtera.
                                </p>
                                <div class="flex gap-3">
                                    <a href="{{ route('layanan.index') }}" class="btn btn-primary" id="hero-cta-layanan">
                                        Layanan Mandiri
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                    <a href="{{ route('profil.visi-misi') }}" class="btn btn-secondary" id="hero-cta-profil">
                                        Profil Kalurahan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Navigation --}}
        <div class="swiper-pagination hero-pagination !bottom-8"></div>
        <div class="swiper-button-prev hero-prev !hidden md:!flex"></div>
        <div class="swiper-button-next hero-next !hidden md:!flex"></div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 right-8 z-10 hidden md:flex flex-col items-center gap-2 text-white/60">
            <span class="text-xs font-medium tracking-widest uppercase rotate-90 origin-center">Scroll</span>
            <div class="w-px h-12 bg-white/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-4 bg-white/70 animate-bounce"></div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     QUICK LINKS SECTION (Ultra-Clean High Contrast Floating Grid)
============================================================ --}}
<section class="py-6 relative z-30 -mt-14 sm:-mt-16" aria-labelledby="quick-links-title">
    <div class="container-sid">
        {{-- High Contrast Card Container --}}
        <div class="card-box-light rounded-3xl p-5 sm:p-6">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                    <h2 id="quick-links-title" class="text-main-title text-xs font-black uppercase tracking-widest">Layanan & Akses Cepat Digital</h2>
                </div>
                <span class="text-[11px] font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-slate-800 px-3 py-1 rounded-full border border-blue-200/80 dark:border-slate-700">8 Layanan Utama</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-3.5">
                @foreach([
                    ['title' => 'Surat Online', 'desc' => 'Layanan Surat', 'icon' => '📄', 'badge_bg' => 'bg-blue-50 text-blue-600 border border-blue-100 dark:bg-blue-950/60 dark:text-blue-400 dark:border-blue-900', 'url' => '/layanan/surat'],
                    ['title' => 'Penduduk', 'desc' => 'Data Kependudukan', 'icon' => '👥', 'badge_bg' => 'bg-purple-50 text-purple-600 border border-purple-100 dark:bg-purple-950/60 dark:text-purple-400 dark:border-purple-900', 'url' => '/statistik'],
                    ['title' => 'APBDes', 'desc' => 'Transparansi', 'icon' => '💰', 'badge_bg' => 'bg-emerald-50 text-emerald-600 border border-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-400 dark:border-emerald-900', 'url' => '/transparansi/apbkal'],
                    ['title' => 'Pengaduan', 'desc' => 'Lapor Masalah', 'icon' => '📢', 'badge_bg' => 'bg-rose-50 text-rose-600 border border-rose-100 dark:bg-rose-950/60 dark:text-rose-400 dark:border-rose-900', 'url' => '/pengaduan'],
                    ['title' => 'Galeri Foto', 'desc' => 'Dokumentasi', 'icon' => '🖼️', 'badge_bg' => 'bg-amber-50 text-amber-600 border border-amber-100 dark:bg-amber-950/60 dark:text-amber-400 dark:border-amber-900', 'url' => '/galeri'],
                    ['title' => 'Agenda Desa', 'desc' => 'Jadwal Acara', 'icon' => '📅', 'badge_bg' => 'bg-cyan-50 text-cyan-600 border border-cyan-100 dark:bg-cyan-950/60 dark:text-cyan-400 dark:border-cyan-900', 'url' => '/agenda'],
                    ['title' => 'PPID Berkas', 'desc' => 'Unduh Dokumen', 'icon' => '📁', 'badge_bg' => 'bg-lime-50 text-lime-600 border border-lime-100 dark:bg-lime-950/60 dark:text-lime-400 dark:border-lime-900', 'url' => '/ppid'],
                    ['title' => 'Peta Wilayah', 'desc' => 'Peta Interaktif', 'icon' => '🗺️', 'badge_bg' => 'bg-fuchsia-50 text-fuchsia-600 border border-fuchsia-100 dark:bg-fuchsia-950/60 dark:text-fuchsia-400 dark:border-fuchsia-900', 'url' => '/peta'],
                ] as $item)
                <a href="{{ $item['url'] }}" class="card-inner-light group flex flex-col items-center text-center p-3 sm:p-3.5 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-11 h-11 rounded-2xl {{ $item['badge_bg'] }} flex items-center justify-center text-xl mb-2 shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        {{ $item['icon'] }}
                    </div>
                    <div class="text-main-title font-extrabold text-[12px] group-hover:text-blue-600 transition-colors line-clamp-1">
                        {{ $item['title'] }}
                    </div>
                    <div class="text-muted-desc text-[10px] font-medium mt-0.5 line-clamp-1">
                        {{ $item['desc'] }}
                    </div>
                </a>
                @endforeach
            </div>
        {{-- ============================================================
     VILLAGE STATS (Data Kalurahan dalam Angka)
============================================================ --}}
<section class="section-py bg-grid relative overflow-hidden" aria-labelledby="stats-title">
    <div class="container-sid relative z-10">
        <div class="section-header mb-8">
            <div class="section-header-left">
                <div class="section-header-label text-blue-600 dark:text-blue-400 font-extrabold text-xs uppercase tracking-widest">Data Statistik Desa</div>
                <h2 id="stats-title" class="section-title text-main-title">
                    {{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Desa') }} dalam Angka
                </h2>
                <p class="section-subtitle text-muted-desc">Data indikator & statistik demografi kependudukan terkini</p>
            </div>
            <a href="{{ route('statistik.kependudukan') }}" class="btn btn-outline hidden sm:flex shrink-0 font-extrabold">
                Lihat Detail Statistik
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 stagger-children">
            {{-- Penduduk --}}
            <div class="card-box-light rounded-3xl p-5 sm:p-6 reveal hover:-translate-y-1.5 transition-all duration-300 text-center" id="stat-penduduk">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="stat-number text-main-title font-black text-3xl sm:text-4xl tracking-tight" data-count="{{ str_replace('.', '', $stats['population']) ?? 28394 }}">0</div>
                <div class="text-main-title font-extrabold text-xs sm:text-sm mt-1.5">Jiwa Penduduk</div>
                <div class="text-muted-desc text-[11px] font-semibold mt-0.5">Terdaftar Aktif {{ date('Y') }}</div>
            </div>

            {{-- KK --}}
            <div class="card-box-light rounded-3xl p-5 sm:p-6 reveal hover:-translate-y-1.5 transition-all duration-300 text-center" id="stat-kk" style="animation-delay: 0.1s">
                <div class="w-14 h-14 bg-purple-100 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-900 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="stat-number text-main-title font-black text-3xl sm:text-4xl tracking-tight" data-count="{{ str_replace('.', '', $stats['families']) ?? 9800 }}">0</div>
                <div class="text-main-title font-extrabold text-xs sm:text-sm mt-1.5">Kepala Keluarga</div>
                <div class="text-muted-desc text-[11px] font-semibold mt-0.5">Kartu Keluarga (KK)</div>
            </div>

            {{-- Padukuhan --}}
            <div class="card-box-light rounded-3xl p-5 sm:p-6 reveal hover:-translate-y-1.5 transition-all duration-300 text-center" id="stat-padukuhan" style="animation-delay: 0.2s">
                <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
                <div class="stat-number text-main-title font-black text-3xl sm:text-4xl tracking-tight" data-count="{{ $stats['padukuhan'] ?? 18 }}">0</div>
                <div class="text-main-title font-extrabold text-xs sm:text-sm mt-1.5">Wilayah RT / RW</div>
                <div class="text-muted-desc text-[11px] font-semibold mt-0.5">Wilayah Administratif</div>
            </div>

            {{-- IDM --}}
            <div class="card-box-light rounded-3xl p-5 sm:p-6 reveal hover:-translate-y-1.5 transition-all duration-300 text-center" id="stat-idm" style="animation-delay: 0.3s">
                <div class="w-14 h-14 bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-900 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="stat-number text-main-title font-black text-3xl sm:text-4xl tracking-tight">{{ $idmScore ? number_format($idmScore->total_score, 4) : '0.8756' }}</div>
                <div class="text-main-title font-extrabold text-xs sm:text-sm mt-1.5">Skor IDM {{ $idmScore?->year ?? date('Y') }}</div>
                <div class="mt-1.5">
                    <span class="bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 font-extrabold text-[10px] px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                        Desa {{ ucfirst($idmScore?->status ?? 'Mandiri') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURED NEWS SECTION (Informasi Terkini)
============================================================ --}}
<section class="section-py" aria-labelledby="news-title">
    <div class="container-sid">
        <div class="section-header mb-8">
            <div class="section-header-left">
                <div class="section-header-label text-blue-600 dark:text-blue-400 font-extrabold text-xs uppercase tracking-widest">Informasi Terkini</div>
                <h2 id="news-title" class="section-title text-main-title">Berita & Publikasi Desa</h2>
                <p class="section-subtitle text-muted-desc">Kabar terbaru, artikel pembangunan, dan informasi resmi pemerintahan desa</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline hidden sm:flex shrink-0 font-extrabold">
                Lihat Semua Berita
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if($featuredArticles->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Featured Hero Article Card --}}
            @php $hero = $featuredArticles->first(); @endphp
            <div class="lg:row-span-2 reveal reveal-left">
                <a href="{{ route('berita.show', $hero->slug) }}" class="group block relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 dark:border-slate-800 h-full min-h-[380px]" id="featured-article-{{ $hero->id }}">
                    <img
                        src="{{ $hero->featured_image ? Storage::url($hero->featured_image) : 'https://picsum.photos/800/500?random=1' }}"
                        alt="{{ $hero->title }}"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                        @if($hero->category)
                        <span class="inline-block bg-blue-600 text-white font-extrabold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full mb-3 shadow-md">
                            {{ $hero->category->name }}
                        </span>
                        @endif
                        <h3 class="text-white font-black text-xl sm:text-2xl leading-snug mb-3 group-hover:text-amber-300 transition-colors drop-shadow-md">
                            {{ $hero->title }}
                        </h3>
                        <div class="flex items-center gap-3 text-slate-300 text-xs font-medium">
                            <span>📅 {{ $hero->published_at?->diffForHumans() }}</span>
                            <span>•</span>
                            <span>⏱️ {{ $hero->reading_time }} mnt baca</span>
                            <span>•</span>
                            <span>👁️ {{ number_format($hero->view_count) }}x</span>
                        </div>
                    </div>
                    @if($hero->is_featured)
                    <div class="absolute top-4 left-4 bg-amber-400 text-amber-950 font-black text-xs px-3 py-1.5 rounded-full flex items-center gap-1 shadow-lg">
                        ⭐ Pilihan Redaksi
                    </div>
                    @endif
                </a>
            </div>

            {{-- 2 Secondary Articles Cards --}}
            <div class="space-y-4">
                @foreach($featuredArticles->skip(1)->take(2) as $article)
                <a href="{{ route('berita.show', $article->slug) }}" class="card-box-light rounded-2xl p-4 flex gap-4 group hover:-translate-y-1 transition-all duration-300" id="article-{{ $article->id }}">
                    <div class="w-32 sm:w-40 shrink-0 h-28 rounded-xl overflow-hidden relative">
                        <img
                            src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://picsum.photos/300/200?random=' . $loop->index }}"
                            alt="{{ $article->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        >
                    </div>
                    <div class="flex flex-col justify-between flex-1 min-w-0">
                        <div>
                            @if($article->category)
                            <span class="inline-block bg-blue-50 dark:bg-slate-800 text-blue-700 dark:text-blue-300 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-md border border-blue-100 dark:border-slate-700 mb-1.5">
                                {{ $article->category->name }}
                            </span>
                            @endif
                            <h3 class="text-main-title font-bold text-sm sm:text-base leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h3>
                        </div>
                        <div class="flex items-center gap-2 text-muted-desc text-[11px] font-medium pt-2 border-t border-slate-100 dark:border-slate-800/80">
                            <span>📅 {{ $article->published_at?->diffForHumans() }}</span>
                            <span>•</span>
                            <span>⏱️ {{ $article->reading_time }} mnt</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Latest Articles Grid (3 Cards) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
            @foreach($latestArticles->take(6) as $article)
            <a href="{{ route('berita.show', $article->slug) }}" class="card-box-light rounded-2xl overflow-hidden group hover:-translate-y-2 transition-all duration-300 flex flex-col h-full" id="latest-article-{{ $article->id }}">
                <div class="aspect-video overflow-hidden relative">
                    <img
                        src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://picsum.photos/600/400?random=' . $loop->index + 10 }}"
                        alt="{{ $article->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    >
                </div>
                <div class="p-5 flex flex-col flex-1">
                    @if($article->category)
                    <span class="inline-block bg-blue-50 dark:bg-slate-800 text-blue-700 dark:text-blue-300 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md border border-blue-100 dark:border-slate-700 mb-2 w-fit">
                        {{ $article->category->name }}
                    </span>
                    @endif
                    <h3 class="text-main-title font-bold text-base leading-snug mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>
                    <p class="text-muted-desc text-xs line-clamp-2 mb-4 flex-1">
                        {{ $article->excerpt }}
                    </p>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] text-muted-desc font-medium">
                        <span>📅 {{ $article->published_at?->format('d M Y') }}</span>
                        <span>⏱️ {{ $article->reading_time }} mnt baca</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('berita.index') }}" class="btn btn-outline w-full font-bold">
                Lihat Semua Berita
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     UPCOMING EVENTS + ANNOUNCEMENTS (2-Col Modern Dark Container)
============================================================ --}}
<section class="section-py bg-slate-900 dark:bg-slate-950 text-white rounded-3xl my-8 p-6 sm:p-10 border border-slate-800 shadow-2xl" aria-labelledby="events-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Events Column --}}
            <div class="reveal reveal-left">
                <div class="text-amber-400 font-extrabold text-xs uppercase tracking-widest mb-1">Jadwal & Acara</div>
                <h2 id="events-title" class="text-white font-black text-2xl sm:text-3xl mb-6">Agenda Mendatang</h2>

                <div class="space-y-3.5">
                    @forelse($upcomingEvents as $event)
                    <a href="{{ route('agenda.show', $event->slug) }}"
                       class="flex gap-4 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/80 rounded-2xl p-4 transition-all duration-300 group hover:-translate-y-1 shadow-md"
                       id="event-{{ $event->id }}">
                        {{-- Date Box --}}
                        <div class="shrink-0 w-14 text-center">
                            <div class="bg-gradient-to-r from-amber-400 to-amber-500 text-amber-950 font-black text-xl leading-none rounded-t-xl py-1.5 shadow-sm">
                                {{ $event->start_datetime->format('d') }}
                            </div>
                            <div class="bg-amber-500/20 text-amber-300 text-xs font-extrabold rounded-b-xl py-1 border-t border-amber-500/30">
                                {{ $event->start_datetime->translatedFormat('M') }}
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-bold text-sm sm:text-base leading-snug group-hover:text-amber-300 transition-colors line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-blue-200 text-xs font-semibold mt-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $event->start_datetime->format('H:i') }} WIB</span>
                                @if($event->location)
                                <span>•</span>
                                <svg class="w-3.5 h-3.5 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="truncate">{{ $event->location }}</span>
                                @endif
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-blue-400 shrink-0 my-auto group-hover:text-amber-300 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="bg-slate-800/60 rounded-2xl p-8 text-center text-blue-200 border border-slate-700/60">
                        <svg class="w-12 h-12 mx-auto mb-3 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm font-semibold">Belum ada agenda mendatang</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    <a href="{{ route('agenda.index') }}" class="btn btn-secondary text-xs font-extrabold border-slate-700 hover:border-amber-400 text-white">
                        Lihat Semua Agenda
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            {{-- Announcements Column --}}
            <div class="reveal reveal-right">
                <div class="text-amber-400 font-extrabold text-xs uppercase tracking-widest mb-1">Informasi Resmi</div>
                <h2 class="text-white font-black text-2xl sm:text-3xl mb-6">Pengumuman Edaran</h2>

                <div class="space-y-3.5">
                    @forelse($pinnedAnnouncements as $ann)
                    <a href="{{ route('pengumuman.show', $ann->id) }}"
                       class="flex gap-4 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/80 rounded-2xl p-4 transition-all duration-300 group hover:-translate-y-1 shadow-md"
                       id="announcement-{{ $ann->id }}">
                        <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center mt-0.5
                            {{ $ann->priority === 'urgent' ? 'bg-red-500/20 text-red-300 border border-red-500/40' : ($ann->priority === 'important' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-blue-500/20 text-blue-300 border border-blue-500/40') }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($ann->priority === 'urgent')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-bold text-sm sm:text-base leading-snug line-clamp-2 group-hover:text-amber-300 transition-colors">
                                {{ $ann->title }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                @if($ann->priority === 'urgent')
                                <span class="bg-red-500/20 text-red-300 font-extrabold text-[10px] px-2.5 py-0.5 rounded-full border border-red-500/40">Urgent</span>
                                @elseif($ann->priority === 'important')
                                <span class="bg-amber-500/20 text-amber-300 font-extrabold text-[10px] px-2.5 py-0.5 rounded-full border border-amber-500/40">Penting</span>
                                @endif
                                <span class="text-blue-300 text-xs font-medium">🕒 {{ $ann->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-blue-400 shrink-0 my-auto group-hover:text-amber-300 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="bg-slate-800/60 rounded-2xl p-8 text-center text-blue-200 border border-slate-700/60">
                        <p class="text-sm font-semibold">Belum ada pengumuman terbaru</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary text-xs font-extrabold border-slate-700 hover:border-amber-400 text-white">
                        Lihat Semua Pengumuman
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     GALLERY SECTION (Galeri Kegiatan)
============================================================ --}}
@if($latestAlbums->isNotEmpty())
<section class="section-py" aria-labelledby="gallery-title">
    <div class="container-sid">
        <div class="section-header mb-8">
            <div class="section-header-left">
                <div class="section-header-label text-blue-600 dark:text-blue-400 font-extrabold text-xs uppercase tracking-widest">Dokumentasi</div>
                <h2 id="gallery-title" class="section-title text-main-title">Galeri & Visual Kegiatan</h2>
                <p class="section-subtitle text-muted-desc">Dokumentasi momen kegiatan dan program kerja desa</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="btn btn-outline hidden sm:flex shrink-0 font-extrabold">
                Lihat Semua Galeri
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 stagger-children">
            @foreach($latestAlbums as $album)
            <a href="{{ route('galeri.show', $album->slug) }}"
               class="group relative overflow-hidden rounded-3xl aspect-square border border-slate-200/80 dark:border-slate-800 shadow-xl"
               id="album-{{ $album->id }}">
                <img
                    src="{{ $album->cover_image ? Storage::url($album->cover_image) : 'https://picsum.photos/400/400?random=' . $loop->index + 20 }}"
                    alt="{{ $album->title }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    loading="lazy"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent opacity-80 group-hover:opacity-95 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-5">
                    <p class="text-white font-bold text-sm sm:text-base line-clamp-2 leading-snug drop-shadow-md group-hover:text-amber-300 transition-colors">{{ $album->title }}</p>
                    <p class="text-amber-300 text-xs font-semibold mt-1 flex items-center gap-1">
                        🖼️ <span>{{ $album->media_count ?? '—' }} Foto</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     VILLAGE LEADERSHIP (Pimpinan & Perangkat Desa)
============================================================ --}}
<section class="section-py relative overflow-hidden" aria-labelledby="officials-title">
    <div class="container-sid">
        {{-- Section Header --}}
        <div class="text-center mb-10">
            <div class="section-header-label">Kepemimpinan</div>
            <h2 id="officials-title" class="section-title text-main-title">Pimpinan & Perangkat Desa</h2>
            <p class="section-subtitle text-muted-desc max-w-xl mx-auto">Aparatur pemerintahan {{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Desa') }} yang melayani warga dengan dedikasi & profesionalisme</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5 stagger-children">
            @forelse($officials as $official)
            <div class="card-box-light rounded-2xl p-4 text-center group reveal hover:-translate-y-2 transition-all duration-300 shadow-sm hover:shadow-xl" id="official-{{ $official->id }}">
                <div class="relative w-24 h-24 mx-auto mb-3">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 to-slate-100 border-2 border-blue-500/30 dark:border-blue-400/30 shadow-md">
                        <img
                            src="{{ $official->photo_path ? Storage::url($official->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($official->name) . '&background=1B4F8A&color=fff&size=200&bold=true' }}"
                            alt="{{ $official->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                    </div>
                    @if($loop->first)
                    <div class="absolute -top-1.5 -right-1.5 w-7 h-7 bg-amber-400 text-amber-950 rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-900 font-bold text-xs">
                        ⭐
                    </div>
                    @endif
                </div>
                <h3 class="text-main-title font-extrabold text-xs sm:text-sm leading-tight line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $official->name }}</h3>
                <p class="official-badge font-extrabold text-[11px] mt-1.5 leading-snug px-2.5 py-0.5 rounded-full inline-block">{{ $official->position }}</p>
            </div>
            @empty
            <div class="col-span-full text-center text-muted-desc py-8 font-medium">
                Data perangkat desa belum tersedia.
            </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('pemerintahan.perangkat') }}" class="btn btn-outline font-extrabold" id="btn-all-officials">
                Lihat Semua Perangkat Desa
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     APBDes HIGHLIGHT (Transparansi Anggaran)
============================================================ --}}
@if($budget)
<section class="section-py bg-grid" aria-labelledby="budget-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div class="reveal reveal-left">
                <div class="section-header-label">Transparansi Anggaran</div>
                <h2 id="budget-title" class="section-title text-main-title">APBDes Tahun {{ $budget->fiscal_year }}</h2>
                <p class="text-muted-desc mt-2 mb-6 font-medium">Pengelolaan Anggaran Pendapatan dan Belanja Desa secara terbuka, transparan, dan akuntabel.</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-5 budget-income-box rounded-2xl shadow-sm">
                        <div class="text-[11px] font-black budget-label uppercase tracking-wider mb-1">Total Pendapatan</div>
                        <div class="text-xl sm:text-2xl font-black budget-value">
                            Rp {{ number_format($budget->total_income / 1000000, 0, ',', '.') }}Jt
                        </div>
                    </div>
                    <div class="p-5 budget-expense-box rounded-2xl shadow-sm">
                        <div class="text-[11px] font-black budget-label uppercase tracking-wider mb-1">Total Belanja</div>
                        <div class="text-xl sm:text-2xl font-black budget-value">
                            Rp {{ number_format($budget->total_expense / 1000000, 0, ',', '.') }}Jt
                        </div>
                    </div>
                </div>

                {{-- Realisasi Progress Bar --}}
                @if($budget->total_income > 0)
                <div class="mb-6 card-box-light rounded-2xl p-4">
                    <div class="flex justify-between text-xs font-bold text-main-title mb-2">
                        <span>Realisasi Pendapatan Desa</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-black text-sm">{{ number_format(($budget->realized_income ?? 0) / $budget->total_income * 100, 1) }}%</span>
                    </div>
                    <div class="h-3.5 progress-track rounded-full overflow-hidden p-0.5 border border-slate-200 dark:border-slate-700">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-1000 shadow-sm"
                             style="width: {{ min(100, ($budget->realized_income ?? 0) / $budget->total_income * 100) }}%"></div>
                    </div>
                </div>
                @endif

                <a href="{{ route('transparansi.apbkal') }}" class="btn btn-primary font-extrabold shadow-lg shadow-blue-500/20" id="btn-apbkal">
                    Detail Laporan APBDes
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Donut Chart Box (Light & Dark Adaptive) --}}
            <div class="reveal reveal-right">
                <div class="card-box-light rounded-3xl p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="font-extrabold text-base text-main-title">Komposisi Alokasi Belanja</h3>
                        <span class="text-[11px] font-bold official-badge px-3 py-1 rounded-full">TA {{ $budget->fiscal_year }}</span>
                    </div>
                    <div id="budget-donut-chart"></div>
                    <div class="space-y-3 mt-6">
                        @php
                            $expenseCategories = [
                                ['name' => 'Penyelenggaraan Pemerintahan', 'pct' => 26, 'color' => '#2563EB'],
                                ['name' => 'Pembangunan Fisik & Infrastruktur', 'pct' => 38, 'color' => '#059669'],
                                ['name' => 'Pemberdayaan Masyarakat', 'pct' => 21, 'color' => '#D97706'],
                                ['name' => 'Penanggulangan Bencana', 'pct' => 15, 'color' => '#DC2626'],
                            ];
                        @endphp
                        @foreach($expenseCategories as $cat)
                        <div class="flex items-center gap-3 p-2.5 rounded-xl budget-cat-item">
                            <div class="w-3.5 h-3.5 rounded-full shrink-0 shadow-sm" style="background-color: {{ $cat['color'] }}"></div>
                            <div class="flex-1 text-xs font-bold text-sub-title line-clamp-1">{{ $cat['name'] }}</div>
                            <div class="text-xs font-black text-main-title">{{ $cat['pct'] }}%</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     FAQ SECTION (Pusat Bantuan Warga)
============================================================ --}}
@if($faqs->isNotEmpty())
<section class="section-py" aria-labelledby="faq-title">
    <div class="container-sid">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <div class="section-header-label">Pusat Bantuan</div>
                <h2 id="faq-title" class="section-title text-main-title">Pertanyaan Sering Diajukan (FAQ)</h2>
                <p class="section-subtitle text-muted-desc">Jawaban resmi atas pertanyaan umum mengenai permohonan surat & layanan mandiri</p>
            </div>

            <div class="card-box-light rounded-3xl p-6 sm:p-8 space-y-3.5" x-data="{ open: 0 }">
                @foreach($faqs as $i => $faq)
                <div class="faq-item-box rounded-2xl overflow-hidden transition-all" id="faq-{{ $faq->id }}">
                    <button
                        class="w-full flex items-center justify-between p-4.5 sm:p-5 text-left transition-colors"
                        @click="open = open === {{ $i }} ? -1 : {{ $i }}"
                        :aria-expanded="open === {{ $i }}"
                    >
                        <span class="text-main-title font-extrabold text-sm sm:text-base pr-4 leading-snug">{{ $faq->question }}</span>
                        <div class="w-8 h-8 rounded-full official-badge flex items-center justify-center shrink-0">
                            <svg
                                class="w-4 h-4 text-blue-600 dark:text-blue-400 transition-transform duration-300"
                                :class="{ 'rotate-180': open === {{ $i }} }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div
                        x-show="open === {{ $i }}"
                        x-collapse
                        class="px-5 pb-5 text-sub-title text-xs sm:text-sm leading-relaxed faq-answer-box pt-4">
                        {!! $faq->answer !!}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('kontak') }}" class="btn btn-outline font-extrabold" id="btn-more-help">
                    Punya Pertanyaan Lain? Hubungi Layanan Warga
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     PORTAL WARGA CTA BANNER (Urus Dokumen 24/7)
============================================================ --}}
<section class="relative py-16 sm:py-20 overflow-hidden rounded-3xl my-8 bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 text-white shadow-2xl" aria-labelledby="cta-title">
    <div class="absolute inset-0 bg-grid opacity-20"></div>

    {{-- Decorative Blur Shapes --}}
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

    <div class="container-sid relative z-10 text-center">
        <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-4 py-1.5 rounded-full mb-6 border border-white/30 backdrop-blur-sm shadow-md">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-ping"></span>
            Layanan Portal Mandiri 24/7
        </div>
        <h2 id="cta-title" class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-4 drop-shadow-md">
            Urus Dokumen & Surat dari Mana Saja
        </h2>
        <p class="text-blue-100 text-base sm:text-lg max-w-2xl mx-auto mb-8 font-medium">
            Ajukan permohonan surat keterangan, lacak status proses permohonan, dan unduh dokumen resmi dari portal layanan mandiri warga.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('warga.register') }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-amber-950 font-black text-sm px-7 py-3.5 rounded-xl shadow-xl hover:scale-105 transition-all flex items-center gap-2" id="btn-register-warga">
                Daftar Portal Warga — Gratis
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </a>
            <a href="{{ route('layanan.index') }}" class="bg-white/15 hover:bg-white/25 text-white font-extrabold text-sm px-7 py-3.5 rounded-xl border border-white/30 backdrop-blur-md transition-all" id="btn-learn-layanan">
                Pelajari Katalog Layanan
            </a>
        </div>

        {{-- Feature badges --}}
        <div class="flex flex-wrap justify-center gap-2.5 mt-8">
            @foreach(['Surat Online', 'Tracking Realtime', 'Download PDF Berbintang', 'Notifikasi WhatsApp', 'Enkripsi Data'] as $feat)
            <span class="bg-white/15 text-white font-semibold text-xs px-3.5 py-1.5 rounded-full border border-white/20 backdrop-blur-sm">
                ✓ {{ $feat }}
            </span>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ============================================================
// HERO SWIPER
// ============================================================
const heroSwiper = new Swiper('.hero-swiper', {
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
    navigation: {
        nextEl: '.hero-next',
        prevEl: '.hero-prev',
    },
});

// ============================================================
// COUNTER ANIMATION
// ============================================================
function animateCounter(el) {
    const target = parseInt(el.dataset.count) || 0;
    if (target === 0) return;

    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        el.textContent = Math.floor(current).toLocaleString('id-ID');
    }, 16);
}

// ============================================================
// SCROLL REVEAL
// ============================================================
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');

            // Trigger counter if stat card
            const countEl = entry.target.querySelector('[data-count]');
            if (countEl) animateCounter(countEl);

            // Trigger stagger children
            if (entry.target.classList.contains('stagger-children')) {
                entry.target.classList.add('visible');
            }

            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.reveal, .stagger-children').forEach(el => {
    revealObserver.observe(el);
});

// ============================================================
// SEARCH BAR (Global)
// ============================================================
let searchTimeout;
const searchInput = document.getElementById('global-search');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(async () => {
            const q = this.value.trim();
            if (q.length < 2) return;

            try {
                const res = await fetch(`/api/search?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                // TODO: render results
            } catch (e) {}
        }, 400);
    });
}
</script>
@endpush
