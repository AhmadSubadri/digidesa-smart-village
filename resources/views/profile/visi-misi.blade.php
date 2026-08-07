@extends('layouts.app')

@section('title', 'Visi & Misi')
@section('description', 'Visi dan Misi Pembangunan Kalurahan Condongcatur, Kapanewon Depok, Kabupaten Sleman.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Visi & Misi Kalurahan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Profil</span>
            <span class="sep">/</span>
            <span class="current">Visi & Misi</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto space-y-12">

            {{-- VISI CARD --}}
            <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 text-center">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-amber-400 text-amber-950 font-bold text-xs uppercase tracking-widest mb-4">
                        Visi Kalurahan Condongcatur
                    </span>
                    <blockquote class="text-2xl md:text-3xl font-extrabold leading-relaxed font-primary">
                        "Terwujudnya Kalurahan Condongcatur yang Mandiri, Sejahtera, Berbudaya, dan Berkelanjutan Berlandaskan Semangat Gotong Royong"
                    </blockquote>
                </div>
            </div>

            {{-- MISI CARD --}}
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100">
                <div class="text-center mb-10">
                    <div class="section-header-label justify-center">Program Kerja Utama</div>
                    <h2 class="section-title">Misi Pembangunan</h2>
                    <p class="section-subtitle">Langkah strategis dalam mewujudkan visi Kalurahan Condongcatur</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $misiList = [
                            ['num' => '01', 'title' => 'Tata Kelola Pemerintahan', 'desc' => 'Mewujudkan tata kelola pemerintahan kalurahan yang bersih, transparan, akuntabel, dan berbasis teknologi informasi (Digital Village).', 'icon' => '🏛️'],
                            ['num' => '02', 'title' => 'Pemberdayaan Ekonomi', 'desc' => 'Meningkatkan perekonomian warga melalui penguatan UMKM, BUMKal Mandiri, dan pengembangan potensi pariwisata lokal.', 'icon' => '📈'],
                            ['num' => '03', 'title' => 'Layanan Sosial & Kesehatan', 'desc' => 'Meningkatkan kualitas layanan sosial, kesehatan masyarakat, pencegahan stunting, dan perlindungan kesejahteraan keluarga.', 'icon' => '❤️'],
                            ['num' => '04', 'title' => 'Infrastruktur & Lingkungan', 'desc' => 'Pembangunan infrastruktur perdesaan yang merata, ramah lingkungan, serta pengelolaan sampah yang berkelanjutan.', 'icon' => '🌱'],
                            ['num' => '05', 'title' => 'Pelestarian Seni & Budaya', 'desc' => 'Melestarikan nilai-nilai kebudayaan lokal Yogyakarta, kearifan lokal, serta memupuk semangat kebersamaan dan gotong royong.', 'icon' => '🎭'],
                            ['num' => '06', 'title' => 'Kamtibmas & Ketahanan', 'desc' => 'Menciptakan lingkungan wilayah yang aman, tertib, kondusif, dan tanggap terhadap bencana alam.', 'icon' => '🛡️'],
                        ];
                    @endphp

                    @foreach($misiList as $misi)
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-3xl">{{ $misi['icon'] }}</span>
                            <span class="text-2xl font-black text-blue-900/20">{{ $misi['num'] }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $misi['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $misi['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
