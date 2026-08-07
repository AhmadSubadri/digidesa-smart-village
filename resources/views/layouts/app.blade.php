<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', config('app.name', 'SID Condongcatur')) — Kalurahan Condongcatur</title>
    <meta name="description" content="@yield('description', 'Website Resmi Kalurahan Condongcatur, Kapanewon Depok, Sleman, D.I. Yogyakarta. Sistem Informasi Kalurahan untuk pelayanan publik, informasi desa, dan data kependudukan.')">
    <meta name="keywords" content="@yield('keywords', 'Condongcatur, Desa Condongcatur, Kalurahan Condongcatur, Depok Sleman, Sistem Informasi Desa, SID')">
    <meta name="author" content="Kalurahan Condongcatur">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name', 'SID Condongcatur'))">
    <meta property="og:description" content="@yield('og_description', 'Website Resmi Kalurahan Condongcatur')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Kalurahan Condongcatur">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SID Condongcatur')">
    <meta name="twitter:description" content="@yield('description', 'Website Resmi Kalurahan Condongcatur')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {
        "{{ '@' }}context": "https://schema.org",
        "{{ '@' }}type": "GovernmentOrganization",
        "name": "Kalurahan Condongcatur",
        "url": "{{ config('app.url') }}",
        "address": {
            "{{ '@' }}type": "PostalAddress",
            "streetAddress": "Jl. Manggis No. 1",
            "addressLocality": "Condongcatur",
            "addressRegion": "Sleman",
            "addressCountry": "ID"
        },
        "telephone": "(0274) 881094",
        "email": "condongcatur1946@gmail.com"
    }
    </script>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    {{-- Preconnect for Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Extra Head --}}
    @stack('head')

    {{-- Alpine.js CDN (as fallback) --}}
    {{-- @vite already bundles Alpine via resources/js/app.js --}}
</head>

<body
    x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        mobileMenuOpen: false,
        scrolled: false,
        init() {
            this.applyTheme();
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 80;
            });
        },
        toggleDark() {
            this.darkMode = !this.darkMode;
            this.applyTheme();
        },
        applyTheme() {
            document.documentElement.setAttribute('data-theme', this.darkMode ? 'dark' : 'light');
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        }
    }"
    class="min-h-screen"
>

    {{-- ===================================================
         RUNNING TEXT TICKER
    ==================================================== --}}
    <div class="ticker-wrap" id="ticker-bar">
        <span class="ticker-label pl-4">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
            PENGUMUMAN
        </span>
        <div class="pl-36 overflow-hidden flex-1">
            <div class="ticker-track" id="ticker-track">
                @php
                    $tickerItems = \App\Models\Announcement::ticker()->orderByDesc('updated_at')->limit(8)->get();
                @endphp
                @if($tickerItems->isEmpty())
                    <span class="ticker-item">Selamat datang di Website Resmi Kalurahan Condongcatur</span>
                    <span class="ticker-item">Melayani dengan Hati, Membangun Bersama Warga</span>
                    <span class="ticker-item">Kalurahan Condongcatur, Kapanewon Depok, Sleman, D.I. Yogyakarta</span>
                    {{-- Duplicate for seamless loop --}}
                    <span class="ticker-item">Selamat datang di Website Resmi Kalurahan Condongcatur</span>
                    <span class="ticker-item">Melayani dengan Hati, Membangun Bersama Warga</span>
                    <span class="ticker-item">Kalurahan Condongcatur, Kapanewon Depok, Sleman, D.I. Yogyakarta</span>
                @else
                    @foreach($tickerItems as $item)
                        <span class="ticker-item">{{ $item->title }}</span>
                    @endforeach
                    @foreach($tickerItems as $item)
                        <span class="ticker-item">{{ $item->title }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ===================================================
         NAVBAR
    ==================================================== --}}
    <nav
        class="navbar"
        :class="{ 'scrolled': scrolled }"
        aria-label="Navigasi Utama"
    >
        <div class="container-sid">
            <div class="flex items-center justify-between py-3">

                {{-- Brand --}}
                <a href="{{ route('home') }}" class="navbar-brand" aria-label="Beranda Kalurahan Condongcatur">
                    <img src="{{ asset('images/logo-condongcatur.png') }}"
                         alt="Logo Condongcatur"
                         class="navbar-logo"
                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><rect width=%2240%22 height=%2240%22 rx=%228%22 fill=%22%231B4F8A%22/><text x=%2220%22 y=%2226%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2214%22 font-weight=%22bold%22>KC</text></svg>'">
                    <div>
                        <div class="navbar-name" :class="scrolled ? 'text-blue-900' : 'text-white'">
                            Kalurahan Condongcatur
                        </div>
                        <div class="navbar-tagline" :class="scrolled ? 'text-gray-500' : 'text-blue-100'">
                            Kapanewon Depok, Sleman
                        </div>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-1">
                    @php
                        $navLinks = [
                            ['label' => 'Beranda', 'route' => 'home', 'children' => []],
                            ['label' => 'Profil', 'route' => '#', 'children' => [
                                ['label' => 'Visi & Misi', 'route' => 'profil.visi-misi'],
                                ['label' => 'Sejarah Desa', 'route' => 'profil.sejarah'],
                                ['label' => 'Geografis & Peta', 'route' => 'profil.geografis'],
                                ['label' => 'Demografi', 'route' => 'profil.demografi'],
                            ]],
                            ['label' => 'Pemerintahan', 'route' => '#', 'children' => [
                                ['label' => 'Struktur Organisasi', 'route' => 'pemerintahan.struktur'],
                                ['label' => 'Perangkat Kalurahan', 'route' => 'pemerintahan.perangkat'],
                                ['label' => 'Lembaga Desa', 'route' => 'pemerintahan.lembaga'],
                            ]],
                            ['label' => 'Informasi', 'route' => '#', 'children' => [
                                ['label' => 'Berita & Artikel', 'route' => 'berita.index'],
                                ['label' => 'Agenda Kegiatan', 'route' => 'agenda.index'],
                                ['label' => 'Pengumuman', 'route' => 'pengumuman.index'],
                                ['label' => 'Galeri Foto', 'route' => 'galeri.index'],
                            ]],
                            ['label' => 'Data', 'route' => '#', 'children' => [
                                ['label' => 'Kependudukan', 'route' => 'statistik.kependudukan'],
                                ['label' => 'IDM', 'route' => 'statistik.idm'],
                                ['label' => 'SDGs', 'route' => 'statistik.sdgs'],
                                ['label' => 'Peta Interaktif', 'route' => 'peta'],
                            ]],
                            ['label' => 'Transparansi', 'route' => '#', 'children' => [
                                ['label' => 'APBKal', 'route' => 'transparansi.apbkal'],
                                ['label' => 'Pembangunan', 'route' => 'transparansi.pembangunan'],
                                ['label' => 'Bantuan Sosial', 'route' => 'transparansi.bansos'],
                                ['label' => 'PPID', 'route' => 'ppid.index'],
                            ]],
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                        @if(empty($link['children']))
                            <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}"
                               class="px-3 py-2 text-sm font-semibold rounded-lg transition-all"
                               :class="scrolled ? 'text-gray-700 hover:text-blue-700 hover:bg-blue-50' : 'text-white/90 hover:text-white hover:bg-white/10'">
                                {{ $link['label'] }}
                            </a>
                        @else
                            <div class="nav-dropdown">
                                <button class="px-3 py-2 text-sm font-semibold rounded-lg transition-all flex items-center gap-1"
                                        :class="scrolled ? 'text-gray-700 hover:text-blue-700 hover:bg-blue-50' : 'text-white/90 hover:text-white hover:bg-white/10'">
                                    {{ $link['label'] }}
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="nav-dropdown-menu">
                                    @foreach($link['children'] as $child)
                                        <a href="{{ route($child['route']) }}" class="nav-dropdown-item">
                                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    {{-- Dark Mode Toggle --}}
                    <button
                        @click="toggleDark()"
                        class="w-9 h-9 rounded-full flex items-center justify-center transition-all"
                        :class="scrolled ? 'text-gray-600 hover:bg-gray-100' : 'text-white/80 hover:bg-white/10 hover:text-white'"
                        aria-label="Toggle dark mode"
                    >
                        <svg x-show="!darkMode" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- Portal Warga Button --}}
                    <a href="{{ route('warga.login') }}"
                       class="hidden sm:flex btn btn-accent text-sm px-4 py-2"
                       id="btn-portal-warga">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Portal Warga
                    </a>

                    {{-- Mobile Menu Toggle --}}
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-9 h-9 rounded-full flex items-center justify-center transition-all"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                        aria-label="Buka menu"
                        :aria-expanded="mobileMenuOpen"
                    >
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden bg-white border-t border-gray-100 shadow-xl"
        >
            <div class="container-sid py-4 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="{{ route('berita.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Berita
                </a>
                <a href="{{ route('agenda.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Agenda
                </a>
                <a href="{{ route('galeri.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Galeri
                </a>
                <a href="{{ route('layanan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Layanan
                </a>
                <a href="{{ route('kontak') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Kontak
                </a>
                <div class="pt-2 border-t border-gray-100 mt-2">
                    <a href="{{ route('warga.login') }}" class="flex items-center justify-center gap-2 w-full btn btn-primary py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Masuk Portal Warga
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ===================================================
         PAGE CONTENT
    ==================================================== --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ===================================================
         POPUP ANNOUNCEMENT
    ==================================================== --}}
    @php
        $popupAnnouncement = \App\Models\Announcement::popup()->orderByDesc('created_at')->first();
    @endphp
    @if($popupAnnouncement)
    <div
        x-data="{ show: !sessionStorage.getItem('popup_{{ $popupAnnouncement->id }}_dismissed') }"
        x-show="show"
        x-cloak
        class="popup-overlay"
        @click.self="show = false; sessionStorage.setItem('popup_{{ $popupAnnouncement->id }}_dismissed', '1')"
    >
        <div class="popup-modal" @click.stop>
            <div class="popup-urgent-bar">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/></svg>
                {{ strtoupper($popupAnnouncement->priority) }}
            </div>
            <div class="popup-body">
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $popupAnnouncement->title }}</h3>
                <div class="text-gray-600 text-sm leading-relaxed prose prose-sm max-w-none">
                    {!! $popupAnnouncement->content !!}
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button
                        @click="show = false; sessionStorage.setItem('popup_{{ $popupAnnouncement->id }}_dismissed', '1')"
                        class="btn btn-outline text-sm">
                        Tutup
                    </button>
                    <a href="{{ route('pengumuman.show', $popupAnnouncement->id) }}" class="btn btn-primary text-sm">
                        Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===================================================
         FOOTER
    ==================================================== --}}
    <footer class="footer" aria-label="Footer">
        <div class="container-sid">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">

                {{-- Col 1: Brand --}}
                <div class="footer-logo-area lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-condongcatur.png') }}"
                             alt="Logo Condongcatur"
                             class="w-12 h-12 object-contain"
                             onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%228%22 fill=%22%231B4F8A%22/><text x=%2224%22 y=%2231%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2218%22 font-weight=%22bold%22>KC</text></svg>'">
                        <div>
                            <div class="text-white font-bold text-base leading-tight">Kalurahan Condongcatur</div>
                            <div class="text-slate-400 text-xs">Kapanewon Depok, Sleman</div>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Melayani dengan hati, membangun bersama warga untuk Condongcatur yang lebih maju dan sejahtera.
                    </p>
                    <div class="flex gap-2">
                        <a href="https://facebook.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="1.5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="1.5"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="YouTube">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="footer-social-btn" aria-label="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Col 2: Navigasi --}}
                <div>
                    <h4 class="footer-heading">Navigasi</h4>
                    <nav>
                        <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                        <a href="{{ route('profil.visi-misi') }}" class="footer-link">Profil Kalurahan</a>
                        <a href="{{ route('berita.index') }}" class="footer-link">Berita & Artikel</a>
                        <a href="{{ route('agenda.index') }}" class="footer-link">Agenda Kegiatan</a>
                        <a href="{{ route('galeri.index') }}" class="footer-link">Galeri Foto</a>
                        <a href="{{ route('pengumuman.index') }}" class="footer-link">Pengumuman</a>
                    </nav>
                </div>

                {{-- Col 3: Layanan --}}
                <div>
                    <h4 class="footer-heading">Layanan</h4>
                    <nav>
                        <a href="{{ route('layanan.surat') }}" class="footer-link">Permohonan Surat</a>
                        <a href="{{ route('transparansi.apbkal') }}" class="footer-link">APBKal</a>
                        <a href="{{ route('statistik.kependudukan') }}" class="footer-link">Statistik Desa</a>
                        <a href="{{ route('ppid.index') }}" class="footer-link">PPID Dokumen</a>
                        <a href="{{ route('pengaduan.index') }}" class="footer-link">Pengaduan</a>
                        <a href="{{ route('buku-tamu.index') }}" class="footer-link">Buku Tamu</a>
                    </nav>
                </div>

                {{-- Col 4: Kontak --}}
                <div>
                    <h4 class="footer-heading">Kontak Kami</h4>
                    <div class="space-y-3">
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Manggis No. 1, Condongcatur, Depok, Sleman 55283</span>
                        </div>
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(0274) 881094</span>
                        </div>
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>condongcatur1946@gmail.com</span>
                        </div>
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Sen-Jum: 07.30–16.00<br>Sabtu: 08.00–12.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Bottom --}}
            <div class="footer-bottom">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
                    <p>&copy; {{ date('Y') }} Kalurahan Condongcatur. Hak Cipta Dilindungi.</p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-white transition-colors">Sitemap</a>
                        <span class="text-slate-600">v2.0</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Back to Top Button --}}
    <button
        id="back-to-top"
        x-data
        x-show="scrolled"
        x-transition
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 w-10 h-10 bg-blue-600 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-700 transition-all z-50"
        aria-label="Kembali ke atas"
    >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
