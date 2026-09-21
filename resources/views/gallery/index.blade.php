@extends('layouts.app')

@section('title', 'Galeri Dokumentasi')
@section('description', 'Dokumentasi kegiatan dan foto-foto Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Galeri Dokumentasi</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Galeri</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($albums as $album)
            <a href="{{ route('galeri.show', $album->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-md transition-all">
                <div class="aspect-square relative overflow-hidden bg-slate-100">
                    <img
                        src="{{ $album->cover_image ? Storage::url($album->cover_image) : placeholder_image(400, 400, $album->title) }}"
                        alt="{{ $album->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $album->title }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $album->event_date?->format('d M Y') ?? $album->created_at->format('d M Y') }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada album galeri.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $albums->links() }}
        </div>
    </div>
</div>
@endsection
