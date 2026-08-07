@extends('layouts.app')

@section('title', 'Potensi UMKM Desa')
@section('description', 'Katalog Usaha Mikro Kecil dan Menengah (UMKM) Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Potensi UMKM Condongcatur</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Potensi</span>
            <span class="sep">/</span>
            <span class="current">UMKM</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($umkms as $umkm)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div>
                    <span class="badge badge-warning uppercase text-[10px] mb-2">{{ $umkm->category ?? 'Kuliner' }}</span>
                    <h3 class="font-bold text-gray-900 text-base mb-1">{{ $umkm->name }}</h3>
                    <p class="text-xs text-gray-500 mb-3">Pemilik: {{ $umkm->owner_name }}</p>
                    <p class="text-xs text-gray-600 line-clamp-3 mb-4">{{ $umkm->description }}</p>
                </div>
                @if($umkm->phone)
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-gray-500">{{ $umkm->phone }}</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->phone) }}" target="_blank" class="btn btn-accent text-[10px] py-1 px-3">
                        Kontak WA
                    </a>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada data UMKM terdaftar.
            </div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $umkms->links() }}
        </div>
    </div>
</div>
@endsection
