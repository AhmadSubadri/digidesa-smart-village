@extends('layouts.app')

@section('title', 'Struktur Organisasi')
@section('description', 'Bagan struktur organisasi tata kerja Kalurahan Condongcatur, Sleman.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Struktur Organisasi (SOTK)</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Pemerintahan</span>
            <span class="sep">/</span>
            <span class="current">Struktur</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Bagan Struktur Organisasi Kalurahan Condongcatur</h2>

            {{-- Org Chart Cards --}}
            <div class="max-w-md mx-auto mb-8">
                <div class="bg-gradient-to-br from-blue-900 to-blue-800 text-white rounded-2xl p-6 shadow-md">
                    <div class="text-xs uppercase font-bold tracking-widest text-amber-400 mb-1">Pimpinan Utama</div>
                    <h3 class="text-xl font-extrabold">{{ $lurah?->name ?? 'Drs. H. Ahmad Mukhlis, M.Si' }}</h3>
                    <p class="text-sm text-blue-200 mt-0.5">Lurah Condongcatur</p>
                </div>
            </div>

            <div class="w-0.5 h-8 bg-blue-600 mx-auto"></div>

            <div class="max-w-md mx-auto mb-8">
                <div class="bg-blue-600 text-white rounded-2xl p-5 shadow-md">
                    <div class="text-xs uppercase font-bold tracking-widest text-blue-200 mb-1">Sekretariat</div>
                    <h3 class="text-lg font-bold">{{ $sekretaris?->name ?? 'Ir. Budi Santoso' }}</h3>
                    <p class="text-xs text-blue-100">Carik (Sekretaris Kalurahan)</p>
                </div>
            </div>

            <div class="w-0.5 h-8 bg-blue-600 mx-auto"></div>

            {{-- Kasi & Kaur Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
                @foreach($officials->skip(2) as $off)
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-left">
                    <h4 class="font-bold text-gray-900 text-sm">{{ $off->name }}</h4>
                    <p class="text-xs text-blue-600 font-semibold mt-0.5">{{ $off->position }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
