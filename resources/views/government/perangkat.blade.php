@extends('layouts.app')

@section('title', 'Perangkat Kalurahan')
@section('description', 'Daftar pamong dan perangkat Kalurahan Condongcatur, Sleman.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Perangkat Kalurahan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Pemerintahan</span>
            <span class="sep">/</span>
            <span class="current">Perangkat</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($officials as $official)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-28 h-28 mx-auto rounded-2xl overflow-hidden mb-4 bg-slate-100">
                    <img
                        src="{{ $official->photo_path ? Storage::url($official->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($official->name) . '&background=1B4F8A&color=fff&size=200' }}"
                        alt="{{ $official->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">{{ $official->name }}</h3>
                <p class="badge badge-primary text-xs mb-3">{{ $official->position }}</p>
                @if($official->phone)
                <p class="text-xs text-gray-500 flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $official->phone }}
                </p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
