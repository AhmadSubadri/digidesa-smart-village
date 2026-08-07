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
     QUICK LINKS SECTION
============================================================ --}}
<section class="py-10 relative" aria-labelledby="quick-links-title">
    {{-- Floating Card Effect --}}
    <div class="container-sid">
        <div class="bg-white rounded-2xl shadow-xl -mt-12 relative z-10 p-6 md:p-8 border border-gray-100">
            <h2 id="quick-links-title" class="sr-only">Akses Cepat Layanan</h2>
            <div class="quick-links-grid stagger-children">
                @forelse($quickLinks as $link)
                <a href="{{ $link->url }}"
                   class="quick-link-card"
                   id="quick-link-{{ $loop->index }}"
                   @if(str_starts_with($link->url, 'http')) target="_blank" rel="noopener" @endif>
                    <div class="quick-link-icon" style="background-color: {{ $link->color ?? '#EFF6FF' }}20;">
                        {{-- Render Heroicon by name --}}
                        <x-dynamic-component :component="$link->icon ?? 'heroicon-o-link'" class="w-6 h-6" :style="'color: ' . ($link->color ?? '#2563EB')" />
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-gray-800 mb-0.5">{{ $link->title }}</div>
                        @if($link->description)
                        <div class="text-xs text-gray-500 leading-snug line-clamp-2">{{ $link->description }}</div>
                        @endif
                    </div>
                </a>
                @empty
                {{-- Fallback Quick Links --}}
                @foreach([
                    ['title' => 'Surat Keterangan', 'icon' => '📄', 'color' => '#2563EB', 'url' => '/layanan/surat'],
                    ['title' => 'Data Penduduk', 'icon' => '👥', 'color' => '#7C3AED', 'url' => '/statistik'],
                    ['title' => 'APBKal', 'icon' => '💰', 'color' => '#16A34A', 'url' => '/transparansi/apbkal'],
                    ['title' => 'Pengaduan', 'icon' => '📢', 'color' => '#DC2626', 'url' => '/pengaduan'],
                    ['title' => 'Galeri', 'icon' => '🖼️', 'color' => '#D97706', 'url' => '/galeri'],
                    ['title' => 'Agenda', 'icon' => '📅', 'color' => '#0891B2', 'url' => '/agenda'],
                    ['title' => 'PPID', 'icon' => '📁', 'color' => '#65A30D', 'url' => '/ppid'],
                    ['title' => 'Peta Desa', 'icon' => '🗺️', 'color' => '#E11D48', 'url' => '/peta'],
                ] as $item)
                <a href="{{ $item['url'] }}" class="quick-link-card">
                    <div class="quick-link-icon text-2xl">{{ $item['icon'] }}</div>
                    <div class="font-semibold text-sm text-gray-800">{{ $item['title'] }}</div>
                </a>
                @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     VILLAGE STATS
============================================================ --}}
<section class="section-py bg-grid" aria-labelledby="stats-title">
    <div class="container-sid">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-header-label">Data Kalurahan</div>
                <h2 id="stats-title" class="section-title">Condongcatur dalam Angka</h2>
                <p class="section-subtitle">Data statistik terkini Kalurahan Condongcatur</p>
            </div>
            <a href="{{ route('statistik.kependudukan') }}" class="btn btn-outline hidden sm:flex shrink-0">
                Lihat Detail
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
            {{-- Penduduk --}}
            <div class="stat-card reveal" id="stat-penduduk">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="{{ str_replace('.', '', $stats['population']) ?? 28394 }}">0</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Jiwa Penduduk</div>
                <div class="text-xs text-gray-400 mt-0.5">Data {{ date('Y') }}</div>
            </div>

            {{-- KK --}}
            <div class="stat-card reveal" id="stat-kk" style="animation-delay: 0.1s">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="{{ str_replace('.', '', $stats['families']) ?? 9800 }}">0</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Kepala Keluarga</div>
                <div class="text-xs text-gray-400 mt-0.5">Terdaftar aktif</div>
            </div>

            {{-- Padukuhan --}}
            <div class="stat-card reveal" id="stat-padukuhan" style="animation-delay: 0.2s">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="{{ $stats['padukuhan'] ?? 18 }}">0</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Padukuhan</div>
                <div class="text-xs text-gray-400 mt-0.5">Wilayah administratif</div>
            </div>

            {{-- IDM --}}
            <div class="stat-card reveal" id="stat-idm" style="animation-delay: 0.3s">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="stat-number">{{ $idmScore ? number_format($idmScore->total_score, 4) : '0.8756' }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Skor IDM {{ $idmScore?->year ?? date('Y') }}</div>
                <div class="mt-1">
                    <span class="badge badge-success text-xs">
                        {{ ucfirst($idmScore?->status ?? 'mandiri') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURED NEWS SECTION
============================================================ --}}
<section class="section-py" aria-labelledby="news-title">
    <div class="container-sid">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-header-label">Informasi Terkini</div>
                <h2 id="news-title" class="section-title">Berita & Artikel</h2>
                <p class="section-subtitle">Informasi terbaru seputar kegiatan dan pembangunan kalurahan</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline hidden sm:flex shrink-0">
                Semua Berita
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if($featuredArticles->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Featured Hero Article --}}
            @php $hero = $featuredArticles->first(); @endphp
            <div class="lg:row-span-2 reveal reveal-left">
                <a href="{{ route('berita.show', $hero->slug) }}" class="news-card group h-full" id="featured-article-{{ $hero->id }}">
                    <div class="relative" style="padding-top: 60%;">
                        <img
                            src="{{ $hero->featured_image ? Storage::url($hero->featured_image) : 'https://picsum.photos/800/500?random=1' }}"
                            alt="{{ $hero->title }}"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            @if($hero->category)
                            <span class="badge mb-2" style="background-color: {{ $hero->category->color ?? '#2563EB' }}25; color: {{ $hero->category->color ?? '#2563EB' }}">
                                {{ $hero->category->name }}
                            </span>
                            @endif
                            <h3 class="text-white font-bold text-xl leading-tight mb-2">{{ $hero->title }}</h3>
                            <div class="flex items-center gap-3 text-white/70 text-xs">
                                <span>{{ $hero->published_at?->diffForHumans() }}</span>
                                <span>•</span>
                                <span>{{ $hero->reading_time }} menit baca</span>
                                <span>•</span>
                                <span>{{ number_format($hero->view_count) }} dilihat</span>
                            </div>
                        </div>
                        @if($hero->is_featured)
                        <div class="absolute top-4 left-4 glass text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Pilihan Redaksi
                        </div>
                        @endif
                    </div>
                </a>
            </div>

            {{-- 2 Secondary Articles --}}
            <div class="space-y-4">
                @foreach($featuredArticles->skip(1)->take(2) as $article)
                <a href="{{ route('berita.show', $article->slug) }}" class="news-card flex-row group" id="article-{{ $article->id }}" style="flex-direction: row; padding: 0;">
                    <div class="w-36 shrink-0 h-full">
                        <img
                            src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://picsum.photos/300/200?random=' . $loop->index }}"
                            alt="{{ $article->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            style="aspect-ratio: 4/3;"
                            loading="lazy"
                        >
                    </div>
                    <div class="news-card-body">
                        @if($article->category)
                        <span class="news-card-category" style="background-color: {{ $article->category->color ?? '#2563EB' }}20; color: {{ $article->category->color ?? '#2563EB' }}">
                            {{ $article->category->name }}
                        </span>
                        @endif
                        <h3 class="news-card-title">{{ $article->title }}</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs mt-auto pt-2">
                            <span>{{ $article->published_at?->diffForHumans() }}</span>
                            <span>•</span>
                            <span>{{ $article->reading_time }} mnt</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Latest Articles Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 stagger-children">
            @foreach($latestArticles->take(6) as $article)
            <a href="{{ route('berita.show', $article->slug) }}" class="news-card group" id="latest-article-{{ $article->id }}">
                <div class="news-card-img-wrap">
                    <img
                        src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://picsum.photos/600/400?random=' . $loop->index + 10 }}"
                        alt="{{ $article->title }}"
                        class="news-card-img"
                        loading="lazy"
                    >
                </div>
                <div class="news-card-body">
                    @if($article->category)
                    <span class="news-card-category" style="background-color: {{ $article->category->color ?? '#2563EB' }}20; color: {{ $article->category->color ?? '#2563EB' }}">
                        {{ $article->category->name }}
                    </span>
                    @endif
                    <h3 class="news-card-title">{{ $article->title }}</h3>
                    <p class="news-card-excerpt">{{ $article->excerpt }}</p>
                    <div class="news-card-meta">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $article->published_at?->format('d M Y') }}</span>
                        <span class="ml-auto">{{ $article->reading_time }} mnt baca</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('berita.index') }}" class="btn btn-outline">
                Semua Berita
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     UPCOMING EVENTS + ANNOUNCEMENTS (2-col)
============================================================ --}}
<section class="section-py bg-gradient-to-br from-blue-950 to-blue-900" aria-labelledby="events-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Events Column --}}
            <div class="reveal reveal-left">
                <div class="section-header-label text-blue-300">Jadwal Kegiatan</div>
                <h2 id="events-title" class="section-title text-white mb-6">Agenda Mendatang</h2>

                <div class="space-y-3">
                    @forelse($upcomingEvents as $event)
                    <a href="{{ route('agenda.show', $event->slug) }}"
                       class="flex gap-4 glass rounded-xl p-4 hover:bg-white/15 transition-all group"
                       id="event-{{ $event->id }}">
                        {{-- Date Box --}}
                        <div class="shrink-0 w-14 text-center">
                            <div class="bg-amber-400 text-amber-900 font-black text-xl leading-none rounded-t-lg py-1">
                                {{ $event->start_datetime->format('d') }}
                            </div>
                            <div class="bg-amber-500/30 text-amber-200 text-xs font-semibold rounded-b-lg py-1">
                                {{ $event->start_datetime->translatedFormat('M') }}
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-tight group-hover:text-amber-300 transition-colors line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-blue-300 text-xs mt-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $event->start_datetime->format('H:i') }} WIB</span>
                                @if($event->location)
                                <span>•</span>
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="truncate">{{ $event->location }}</span>
                                @endif
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-blue-400 shrink-0 mt-1 group-hover:text-amber-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="glass rounded-xl p-8 text-center text-blue-300">
                        <svg class="w-12 h-12 mx-auto mb-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm">Belum ada agenda mendatang</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('agenda.index') }}" class="btn btn-secondary text-sm">
                        Lihat Semua Agenda
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            {{-- Announcements Column --}}
            <div class="reveal reveal-right">
                <div class="section-header-label text-blue-300">Informasi Resmi</div>
                <h2 class="section-title text-white mb-6">Pengumuman</h2>

                <div class="space-y-3">
                    @forelse($pinnedAnnouncements as $ann)
                    <a href="{{ route('pengumuman.show', $ann->id) }}"
                       class="flex gap-3 glass rounded-xl p-4 hover:bg-white/15 transition-all group"
                       id="announcement-{{ $ann->id }}">
                        <div class="shrink-0 w-8 h-8 rounded-lg flex items-center justify-center mt-0.5
                            {{ $ann->priority === 'urgent' ? 'bg-red-500/30 text-red-300' : ($ann->priority === 'important' ? 'bg-amber-500/30 text-amber-300' : 'bg-blue-500/30 text-blue-300') }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($ann->priority === 'urgent')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-snug line-clamp-2 group-hover:text-amber-300 transition-colors">
                                {{ $ann->title }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                @if($ann->priority === 'urgent')
                                <span class="badge badge-danger text-xs">Urgent</span>
                                @elseif($ann->priority === 'important')
                                <span class="badge badge-warning text-xs">Penting</span>
                                @endif
                                <span class="text-blue-400 text-xs">{{ $ann->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-blue-400 shrink-0 mt-1 group-hover:text-amber-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="glass rounded-xl p-8 text-center text-blue-300">
                        <p class="text-sm">Belum ada pengumuman terbaru</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary text-sm">
                        Lihat Semua Pengumuman
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     GALLERY SECTION
============================================================ --}}
@if($latestAlbums->isNotEmpty())
<section class="section-py" aria-labelledby="gallery-title">
    <div class="container-sid">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-header-label">Dokumentasi</div>
                <h2 id="gallery-title" class="section-title">Galeri Kegiatan</h2>
                <p class="section-subtitle">Momen berkesan kegiatan Kalurahan Condongcatur</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="btn btn-outline hidden sm:flex shrink-0">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
            @foreach($latestAlbums as $album)
            <a href="{{ route('galeri.show', $album->slug) }}"
               class="group relative overflow-hidden rounded-2xl aspect-square"
               id="album-{{ $album->id }}">
                <img
                    src="{{ $album->cover_image ? Storage::url($album->cover_image) : 'https://picsum.photos/400/400?random=' . $loop->index + 20 }}"
                    alt="{{ $album->title }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    loading="lazy"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <p class="text-white font-semibold text-sm line-clamp-2">{{ $album->title }}</p>
                    <p class="text-white/70 text-xs mt-0.5">{{ $album->media_count ?? '—' }} foto</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     VILLAGE LEADERSHIP
============================================================ --}}
<section class="section-py bg-gradient-to-br from-slate-50 to-blue-50" aria-labelledby="officials-title">
    <div class="container-sid">
        <div class="text-center mb-10">
            <div class="section-header-label justify-center">Kepemimpinan</div>
            <h2 id="officials-title" class="section-title">Pimpinan & Perangkat Kalurahan</h2>
            <p class="section-subtitle">Melayani warga Condongcatur dengan penuh dedikasi</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 stagger-children">
            @forelse($officials as $official)
            <div class="text-center group reveal" id="official-{{ $official->id }}">
                <div class="relative w-24 h-24 mx-auto mb-3">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-100 to-blue-200">
                        <img
                            src="{{ $official->photo_path ? Storage::url($official->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($official->name) . '&background=1B4F8A&color=fff&size=200&bold=true' }}"
                            alt="{{ $official->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                    </div>
                    @if($loop->first)
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-amber-400 rounded-full flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    @endif
                </div>
                <h3 class="font-semibold text-sm text-gray-800 leading-tight">{{ $official->name }}</h3>
                <p class="text-xs text-blue-600 font-medium mt-0.5 leading-snug">{{ $official->position }}</p>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-8">
                Data perangkat belum tersedia.
            </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('pemerintahan.perangkat') }}" class="btn btn-outline" id="btn-all-officials">
                Lihat Semua Perangkat
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     APBKal HIGHLIGHT
============================================================ --}}
@if($budget)
<section class="section-py" aria-labelledby="budget-title">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="reveal reveal-left">
                <div class="section-header-label">Transparansi Anggaran</div>
                <h2 id="budget-title" class="section-title">APBKal {{ $budget->fiscal_year }}</h2>
                <p class="text-gray-500 mt-2 mb-6">Pengelolaan Anggaran Pendapatan dan Belanja Kalurahan secara transparan dan akuntabel.</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Total Pendapatan</div>
                        <div class="text-xl font-black text-green-700">
                            Rp {{ number_format($budget->total_income / 1000000, 0, ',', '.') }}Jt
                        </div>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">Total Belanja</div>
                        <div class="text-xl font-black text-blue-700">
                            Rp {{ number_format($budget->total_expense / 1000000, 0, ',', '.') }}Jt
                        </div>
                    </div>
                </div>

                {{-- Realisasi Progress --}}
                @if($budget->total_income > 0)
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                        <span>Realisasi Pendapatan</span>
                        <span class="font-semibold text-green-600">{{ number_format(($budget->realized_income ?? 0) / $budget->total_income * 100, 1) }}%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full transition-all duration-1000"
                             style="width: {{ min(100, ($budget->realized_income ?? 0) / $budget->total_income * 100) }}%"></div>
                    </div>
                </div>
                @endif

                <a href="{{ route('transparansi.apbkal') }}" class="btn btn-primary" id="btn-apbkal">
                    Detail APBKal
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Chart Placeholder --}}
            <div class="reveal reveal-right">
                <div class="bg-gradient-to-br from-blue-900 to-blue-950 rounded-2xl p-6 text-white">
                    <h3 class="font-bold mb-4">Komposisi Belanja</h3>
                    <div id="budget-donut-chart"></div>
                    <div class="space-y-2 mt-4">
                        @php
                            $expenseCategories = [
                                ['name' => 'Penyelenggaraan Pemerintahan', 'pct' => 26, 'color' => '#3B82F6'],
                                ['name' => 'Pembangunan', 'pct' => 38, 'color' => '#10B981'],
                                ['name' => 'Pemberdayaan Masyarakat', 'pct' => 21, 'color' => '#F59E0B'],
                                ['name' => 'Penanggulangan Bencana', 'pct' => 15, 'color' => '#EF4444'],
                            ];
                        @endphp
                        @foreach($expenseCategories as $cat)
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $cat['color'] }}"></div>
                            <div class="flex-1 text-xs text-blue-200">{{ $cat['name'] }}</div>
                            <div class="text-xs font-bold text-white">{{ $cat['pct'] }}%</div>
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
     FAQ SECTION
============================================================ --}}
@if($faqs->isNotEmpty())
<section class="section-py bg-gradient-to-br from-slate-50 to-blue-50" aria-labelledby="faq-title">
    <div class="container-sid">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <div class="section-header-label justify-center">Bantuan</div>
                <h2 id="faq-title" class="section-title">Pertanyaan Umum</h2>
                <p class="section-subtitle">Jawaban atas pertanyaan yang sering diajukan warga</p>
            </div>

            <div class="space-y-3" x-data="{ open: 0 }">
                @foreach($faqs as $i => $faq)
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm"
                     id="faq-{{ $faq->id }}">
                    <button
                        class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors"
                        @click="open = open === {{ $i }} ? -1 : {{ $i }}"
                        :aria-expanded="open === {{ $i }}"
                    >
                        <span class="font-semibold text-gray-800 pr-4 text-sm">{{ $faq->question }}</span>
                        <svg
                            class="w-5 h-5 text-blue-600 shrink-0 transition-transform duration-300"
                            :class="{ 'rotate-180': open === {{ $i }} }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        x-show="open === {{ $i }}"
                        x-collapse
                        class="px-5 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                        {!! $faq->answer !!}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('kontak') }}" class="btn btn-outline" id="btn-more-help">
                    Punya Pertanyaan Lain? Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     PORTAL WARGA CTA
============================================================ --}}
<section class="relative py-20 overflow-hidden" aria-labelledby="cta-title">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900"></div>
    <div class="absolute inset-0 bg-grid opacity-20"></div>

    {{-- Decorative Shapes --}}
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>

    <div class="container-sid relative z-10 text-center">
        <div class="inline-flex items-center gap-2 glass text-white/90 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
            </svg>
            Layanan 24/7 Online
        </div>
        <h2 id="cta-title" class="text-4xl md:text-5xl font-extrabold text-white mb-4">
            Urus Dokumen dari<br>Mana Saja
        </h2>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto mb-8">
            Ajukan permohonan surat keterangan, lacak status permohonan, dan unduh dokumen digital langsung dari portal warga Condongcatur.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('warga.register') }}" class="btn btn-accent text-base px-6 py-3" id="btn-register-warga">
                Daftar Sekarang — Gratis
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </a>
            <a href="{{ route('layanan.index') }}" class="btn btn-secondary text-base px-6 py-3" id="btn-learn-layanan">
                Pelajari Layanan
            </a>
        </div>

        {{-- Feature badges --}}
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            @foreach(['Surat Keterangan Online', 'Tracking Status', 'Download PDF', 'Notifikasi WhatsApp', 'Keamanan Data'] as $feat)
            <span class="glass text-white/80 text-xs px-3 py-1.5 rounded-full">
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
