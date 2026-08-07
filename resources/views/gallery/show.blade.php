@extends('layouts.app')

@section('title', $album->title)
@section('description', $album->description)

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">{{ $album->title }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('galeri.index') }}">Galeri</a>
            <span class="sep">/</span>
            <span class="current">Detail</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
            <p class="text-gray-600 mb-4">{{ $album->description }}</p>
            <div class="text-xs text-gray-400">Tanggal: {{ $album->event_date?->translatedFormat('d F Y') ?? $album->created_at->translatedFormat('d F Y') }}</div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @for($i=1; $i<=8; $i++)
            <div class="rounded-xl overflow-hidden shadow-sm aspect-square bg-slate-100 group">
                <img
                    src="https://picsum.photos/600/600?random={{ $album->id * 10 + $i }}"
                    alt="Foto {{ $i }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    loading="lazy"
                >
            </div>
            @endfor
        </div>

        <div class="mt-8">
            <a href="{{ route('galeri.index') }}" class="btn btn-outline">
                ← Kembali ke Galeri
            </a>
        </div>
    </div>
</div>
@endsection
