@extends('layouts.app')

@section('title', 'Destinasi Wisata')
@section('description', 'Destinasi wisata dan tempat bersejarah di Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Destinasi Wisata Condongcatur</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Potensi</span>
            <span class="sep">/</span>
            <span class="current">Wisata</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($destinations as $dest)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="aspect-video relative bg-slate-100">
                    <img src="{{ placeholder_image(600, 400, $dest->name) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="badge badge-primary uppercase text-[10px] mb-2">{{ $dest->category ?? 'Wisata' }}</span>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $dest->name }}</h3>
                    <p class="text-xs text-gray-600 line-clamp-3 mb-4">{{ $dest->description }}</p>
                    <div class="text-xs text-gray-500 font-semibold">
                        Tiket: {{ $dest->ticket_price ? 'Rp ' . number_format($dest->ticket_price, 0, ',', '.') : 'Gratis' }}
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada data destinasi wisata.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
