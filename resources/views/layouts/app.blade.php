<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', config('app.name', 'DigiDesa')) — Platform Smart Village</title>
    <meta name="description" content="@yield('description', 'Website Resmi & Portal Layanan Mandiri Digital Desa. Sistem Informasi Desa untuk pelayanan publik, informasi desa, dan data kependudukan.')">
    <meta name="keywords" content="@yield('keywords', 'DigiDesa, Sistem Informasi Desa, SID, Smart Village, Portal Warga, Layanan Mandiri')">
    <meta name="author" content="Pemerintah Desa">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name', 'DigiDesa'))">
    <meta property="og:description" content="@yield('og_description', 'Platform Sistem Informasi Desa & Portal Layanan Mandiri Digital')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DigiDesa Smart Village">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'DigiDesa Smart Village')">
    <meta name="twitter:description" content="@yield('description', 'Platform Sistem Informasi Desa & Portal Layanan Mandiri Digital')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {
        "{{ '@' }}context": "https://schema.org",
        "{{ '@' }}type": "GovernmentOrganization",
        "name": "DigiDesa Smart Village",
        "url": "{{ config('app.url') }}",
        "address": {
            "{{ '@' }}type": "PostalAddress",
            "streetAddress": "Jl. Utama Desa No. 1",
            "addressLocality": "Kecamatan",
            "addressRegion": "Kabupaten",
            "addressCountry": "ID"
        },
        "telephone": "(0274) 881094",
        "email": "info@digidesa.id"
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
</head>

<body
    x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        mobileMenuOpen: false,
        scrolled: false,
        init() {
            this.applyTheme();
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 30;
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
    class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased"
>    {{-- ===================================================
         UNIFIED STICKY HEADER (TICKER + NAVBAR)
    ==================================================== --}}
    <header class="sticky top-0 z-[1000] shadow-lg transition-all">

        {{-- TOP OFFICIAL TICKER BAR --}}
        <div class="bg-slate-950 text-white border-b border-slate-800/80 py-1.5 relative z-50 text-xs">
            <div class="container-sid flex items-center justify-between gap-4">
                {{-- Left: Official Announcement Ticker --}}
                <div class="flex items-center gap-2.5 overflow-hidden flex-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-blue-900/60 text-blue-200 border border-blue-700/50 font-bold text-[10px] uppercase tracking-wider shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        Pengumuman
                    </span>
                    @php
                        $tickerAnnouncements = \Illuminate\Support\Facades\Cache::remember('layout.ticker_announcements', 300, function () {
                            return \App\Models\Announcement::ticker()->orderByDesc('updated_at')->limit(6)->get();
                        });
                    @endphp
                    <div class="overflow-hidden whitespace-nowrap flex-1 text-slate-300 text-[11px] font-medium"
                         x-data="{
                             items: {{ json_encode($tickerAnnouncements->isEmpty() ? ['Selamat datang di Portal Informasi & Layanan Mandiri Digital Kalurahan Condongcatur', 'Pelayanan administrasi kependudukan mandiri online 24 jam nonstop', 'Transparansi anggaran dan publikasi resmi pemerintahan kalurahan'] : $tickerAnnouncements->pluck('title')->toArray()) }},
                             current: 0,
                             init() {
                                 setInterval(() => {
                                     this.current = (this.current + 1) % this.items.length;
                                 }, 4500);
                             }
                         }">
                        <div class="transition-all duration-500 ease-in-out inline-block" x-text="items[current]"></div>
                    </div>
                </div>

                {{-- Right: Citizen Service Info & Date --}}
                <div class="hidden md:flex items-center gap-4 text-slate-400 text-[11px] font-medium shrink-0">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Senin - Jumat (08.00 - 15.30 WIB)</span>
                    </div>
                    <span class="text-slate-700">•</span>
                    <a href="tel:{{ \App\Services\SettingService::getValue('office_phone', '(0274) 881094') }}" class="hover:text-blue-300 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ \App\Services\SettingService::getValue('office_phone', '(0274) 881094') }}</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- MAIN NAVBAR --}}
        <nav
            class="navbar bg-[#0F294A] dark:bg-slate-900 text-white transition-all duration-300 border-b border-blue-900/50 dark:border-slate-800"
            :class="{ 'shadow-2xl bg-[#0b1f38]/95 backdrop-blur-md': scrolled }"
            aria-label="Navigasi Utama"
        >
            <div class="container-sid">
                <div class="flex items-center justify-between py-2.5">

                    {{-- Brand Logo & Official Title --}}
                    <a href="{{ route('home') }}" class="navbar-brand flex items-center gap-3 group" aria-label="Beranda Desa">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-black flex items-center justify-center shadow-md border border-white/15 group-hover:scale-105 transition-transform shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="navbar-name font-black text-sm sm:text-base leading-tight text-white tracking-tight">
                                {{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Kalurahan') }}
                            </div>
                            <div class="navbar-tagline text-[10px] sm:text-xs text-blue-200/80 font-medium">
                                Kapanewon {{ \App\Services\SettingService::getValue('village_subdistrict', 'Depok') }}, {{ \App\Services\SettingService::getValue('village_district', 'Sleman') }}
                            </div>
                        </div>
                    </a>

                    {{-- Desktop Navigation Links with Clean Sub-menus --}}
                    <div class="hidden lg:flex items-center gap-1">
                        @php
                            $navLinks = [
                                ['label' => 'Beranda', 'route' => 'home', 'children' => []],
                                ['label' => 'Profil', 'route' => '#', 'children' => [
                                    ['label' => 'Visi & Misi', 'desc' => 'Arah & komitmen pembangunan desa', 'route' => 'profil.visi-misi'],
                                    ['label' => 'Sejarah Kalurahan', 'desc' => 'Asal usul & tonggak sejarah', 'route' => 'profil.sejarah'],
                                    ['label' => 'Geografis & Wilayah', 'desc' => 'Batas & kondisi kewilayahan', 'route' => 'profil.geografis'],
                                    ['label' => 'Demografi Penduduk', 'desc' => 'Struktur demografi kependudukan', 'route' => 'profil.demografi'],
                                ]],
                                ['label' => 'Pemerintahan', 'route' => '#', 'children' => [
                                    ['label' => 'Struktur Organisasi', 'desc' => 'Bagan SOTK Kalurahan', 'route' => 'pemerintahan.struktur'],
                                    ['label' => 'Pamong & Perangkat', 'desc' => 'Profil Lurah & jajaran pamong', 'route' => 'pemerintahan.perangkat'],
                                    ['label' => 'Lembaga Kalurahan', 'desc' => 'BPMKal, PKK, Karang Taruna, LPMK', 'route' => 'pemerintahan.lembaga'],
                                ]],
                                ['label' => 'Informasi Publik', 'route' => '#', 'children' => [
                                    ['label' => 'Berita & Publikasi', 'desc' => 'Warta & kabar resmi kalurahan', 'route' => 'berita.index'],
                                    ['label' => 'Agenda Kegiatan', 'desc' => 'Jadwal agenda & acara desa', 'route' => 'agenda.index'],
                                    ['label' => 'Pengumuman Resmi', 'desc' => 'Surat edaran & info mendesak', 'route' => 'pengumuman.index'],
                                    ['label' => 'Galeri Dokumentasi', 'desc' => 'Foto dokumentasi kegiatan', 'route' => 'galeri.index'],
                                ]],
                                ['label' => 'Data & Statistik', 'route' => '#', 'children' => [
                                    ['label' => 'Statistik Kependudukan', 'desc' => 'Piramida usia & data kependudukan', 'route' => 'statistik.kependudukan'],
                                    ['label' => 'Indeks Desa Membangun (IDM)', 'desc' => 'Status kemandirian & skor IDM', 'route' => 'statistik.idm'],
                                    ['label' => 'SDGs Desa', 'desc' => 'Pencapaian 18 Tujuan SDGs', 'route' => 'statistik.sdgs'],
                                    ['label' => 'Peta Spasial Kalurahan', 'desc' => 'Peta interaktif batas & fasilitas', 'route' => 'peta'],
                                ]],
                                ['label' => 'Transparansi', 'route' => '#', 'children' => [
                                    ['label' => 'APBDes / APBKal', 'desc' => 'Realisasi anggaran pendapatan & belanja', 'route' => 'transparansi.apbkal'],
                                    ['label' => 'Pembangunan Fisik', 'desc' => 'Progres proyek infrastruktur fisik', 'route' => 'transparansi.pembangunan'],
                                    ['label' => 'Bantuan Sosial', 'desc' => 'Katalog penerima bansos', 'route' => 'transparansi.bansos'],
                                    ['label' => 'PPID Dokumen Publik', 'desc' => 'Unduh berkas dokumen publik', 'route' => 'ppid.index'],
                                ]],
                            ];
                        @endphp

                        @foreach($navLinks as $link)
                            @if(empty($link['children']))
                                <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}"
                                   class="px-3.5 py-2 text-xs font-bold rounded-xl text-slate-200 hover:text-white hover:bg-white/10 transition-all">
                                    {{ $link['label'] }}
                                </a>
                            @else
                                <div class="nav-dropdown relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="px-3.5 py-2 text-xs font-bold rounded-xl text-slate-200 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5">
                                        <span>{{ $link['label'] }}</span>
                                        <svg class="w-3 h-3 opacity-70 group-hover:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    {{-- Sub-menu Dropdown Card --}}
                                    <div
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                        class="absolute top-full left-0 mt-1.5 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200/80 dark:border-slate-800 p-2 z-50 overflow-hidden"
                                    >
                                        @foreach($link['children'] as $child)
                                            <a href="{{ route($child['route']) }}" class="flex flex-col p-2.5 rounded-xl hover:bg-blue-50/80 dark:hover:bg-slate-800/80 transition-all group/item">
                                                <div class="text-xs font-bold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 dark:group-hover/item:text-blue-400 transition-colors">
                                                    {{ $child['label'] }}
                                                </div>
                                                <div class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 leading-tight">
                                                    {{ $child['desc'] }}
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Right Action Buttons --}}
                    <div class="flex items-center gap-2.5">
                        {{-- Dark Mode Toggle Button --}}
                        <button
                            @click="toggleDark()"
                            class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/10 hover:bg-white/20 text-white transition-all shadow-inner"
                            aria-label="Toggle dark mode"
                            title="Mode Gelap / Terang"
                        >
                            <svg x-show="!darkMode" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        {{-- Portal Warga Accent Button --}}
                        <a href="{{ route('warga.login') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-amber-950 font-extrabold text-xs px-4 py-2.5 rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105"
                           id="btn-portal-warga">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Portal Warga
                        </a>

                        {{-- Mobile Menu Toggle Button --}}
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden w-9 h-9 rounded-xl flex items-center justify-center bg-white/10 hover:bg-white/20 text-white transition-all"
                            aria-label="Buka menu"
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

            {{-- Mobile Dropdown Menu --}}
            <div
                x-show="mobileMenuOpen"
                x-transition
                class="lg:hidden bg-slate-900 border-t border-slate-800 shadow-2xl"
            >
                <div class="container-sid py-4 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-200 hover:bg-slate-800 font-semibold text-sm">
                        Beranda
                    </a>
                    <a href="{{ route('berita.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-200 hover:bg-slate-800 font-semibold text-sm">
                        Berita & Artikel
                    </a>
                    <a href="{{ route('agenda.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-200 hover:bg-slate-800 font-semibold text-sm">
                        Agenda Kegiatan
                    </a>
                    <a href="{{ route('layanan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-200 hover:bg-slate-800 font-semibold text-sm">
                        Layanan Mandiri
                    </a>
                    <a href="{{ route('kontak') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-200 hover:bg-slate-800 font-semibold text-sm">
                        Kontak Kami
                    </a>
                    <div class="pt-2 border-t border-slate-800 mt-2">
                        <a href="{{ route('warga.login') }}" class="flex items-center justify-center gap-2 w-full bg-amber-400 text-amber-950 font-bold py-2.5 rounded-xl text-xs">
                            Masuk Portal Warga
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- ===================================================
         PAGE MAIN CONTENT
    ==================================================== --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ===================================================
         POPUP ANNOUNCEMENT
    ==================================================== --}}
    @php
        $popupAnnouncement = \Illuminate\Support\Facades\Cache::remember('layout.popup_announcement', 300, function () {
            return \App\Models\Announcement::popup()->orderByDesc('created_at')->first();
        });
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
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $popupAnnouncement->title }}</h3>
                <div class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed prose prose-sm max-w-none">
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
    <footer class="footer bg-slate-950 text-slate-300 pt-14 pb-8 border-t border-slate-800" aria-label="Footer">
        <div class="container-sid">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">

                {{-- Col 1: Brand --}}
                <div class="footer-logo-area lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-black flex items-center justify-center shadow-md border border-white/10 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-bold text-base leading-tight">{{ \App\Services\SettingService::getValue('village_name', 'Pemerintah Kalurahan') }}</div>
                            <div class="text-slate-400 text-xs">Kapanewon {{ \App\Services\SettingService::getValue('village_subdistrict', 'Depok') }}, {{ \App\Services\SettingService::getValue('village_district', 'Sleman') }}</div>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Melayani dengan hati, membangun bersama warga untuk desa yang lebih maju, transparan, dan sejahtera.
                    </p>
                </div>

                {{-- Col 2: Navigasi --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-amber-400 pl-2.5">Navigasi</h4>
                    <nav class="flex flex-col space-y-2.5 text-sm">
                        <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a>
                        <a href="{{ route('profil.visi-misi') }}" class="hover:text-amber-400 transition-colors">Profil Desa</a>
                        <a href="{{ route('berita.index') }}" class="hover:text-amber-400 transition-colors">Berita & Artikel</a>
                        <a href="{{ route('agenda.index') }}" class="hover:text-amber-400 transition-colors">Agenda Kegiatan</a>
                        <a href="{{ route('galeri.index') }}" class="hover:text-amber-400 transition-colors">Galeri Foto</a>
                        <a href="{{ route('pengumuman.index') }}" class="hover:text-amber-400 transition-colors">Pengumuman</a>
                    </nav>
                </div>

                {{-- Col 3: Layanan --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-amber-400 pl-2.5">Layanan</h4>
                    <nav class="flex flex-col space-y-2.5 text-sm">
                        <a href="{{ route('layanan.surat') }}" class="hover:text-amber-400 transition-colors">Permohonan Surat</a>
                        <a href="{{ route('transparansi.apbkal') }}" class="hover:text-amber-400 transition-colors">APBDes</a>
                        <a href="{{ route('statistik.kependudukan') }}" class="hover:text-amber-400 transition-colors">Statistik Desa</a>
                        <a href="{{ route('ppid.index') }}" class="hover:text-amber-400 transition-colors">PPID Dokumen</a>
                        <a href="{{ route('pengaduan.index') }}" class="hover:text-amber-400 transition-colors">Pengaduan</a>
                        <a href="{{ route('buku-tamu.index') }}" class="hover:text-amber-400 transition-colors">Buku Tamu</a>
                    </nav>
                </div>

                {{-- Col 4: Kontak --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-amber-400 pl-2.5">Kontak Kami</h4>
                    <div class="space-y-3">
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span>{{ \App\Services\SettingService::getValue('office_address', 'Jl. Utama Desa No. 1') }}</span>
                        </div>
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ \App\Services\SettingService::getValue('office_phone', '(0274) 881094') }}</span>
                        </div>
                        <div class="flex gap-3 text-sm text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \App\Services\SettingService::getValue('office_email', 'info@digidesa.id') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Bottom --}}
            <div class="border-t border-slate-800 pt-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <p>&copy; {{ date('Y') }} DigiDesa Smart Village System. Hak Cipta Dilindungi.</p>
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
        class="fixed bottom-6 right-6 w-11 h-11 bg-blue-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-blue-700 transition-all z-50 hover:scale-110"
        aria-label="Kembali ke atas"
    >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
