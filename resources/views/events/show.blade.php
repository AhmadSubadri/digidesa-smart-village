@extends('layouts.app')

@section('title', $event->title)
@section('description', $event->description)

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">{{ $event->title }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('agenda.index') }}">Agenda</a>
            <span class="sep">/</span>
            <span class="current">Detail</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 mb-8">
                <div class="flex flex-wrap gap-4 items-center justify-between pb-6 mb-6 border-b border-gray-100 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Waktu: <strong>{{ $event->start_datetime->translatedFormat('l, d F Y, H:i') }} WIB</strong></span>
                    </div>
                    @if($event->location)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Lokasi: <strong>{{ $event->location }}</strong></span>
                    </div>
                    @endif
                </div>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8">
                    {{ $event->description }}
                </div>

                @if($event->organizer)
                <div class="p-4 bg-slate-50 rounded-xl text-xs text-gray-600">
                    Penyelenggara: <strong>{{ $event->organizer }}</strong>
                    @if($event->contact_phone)
                    | Kontak: <strong>{{ $event->contact_phone }}</strong>
                    @endif
                </div>
                @endif
            </div>

            <a href="{{ route('agenda.index') }}" class="btn btn-outline">
                ← Kembali ke Agenda
            </a>
        </div>
    </div>
</div>
@endsection
