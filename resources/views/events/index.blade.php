@extends('layouts.app')

@section('title', 'Agenda Kegiatan')
@section('description', 'Jadwal dan agenda kegiatan masyarakat dan Pemerintah Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Agenda & Kegiatan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Agenda</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
            <a href="{{ route('agenda.show', $event->slug) }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-14 text-center shrink-0">
                            <div class="bg-amber-400 text-amber-950 font-black text-xl leading-none rounded-t-lg py-1">
                                {{ $event->start_datetime->format('d') }}
                            </div>
                            <div class="bg-amber-500/20 text-amber-800 text-xs font-semibold rounded-b-lg py-1">
                                {{ $event->start_datetime->translatedFormat('M Y') }}
                            </div>
                        </div>
                        <div>
                            <span class="badge badge-primary mb-1">{{ ucfirst($event->status ?? 'Mendatang') }}</span>
                            <div class="text-xs text-gray-500">{{ $event->start_datetime->format('H:i') }} WIB</div>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $event->title }}
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $event->description }}</p>
                </div>
                @if($event->location)
                <div class="pt-4 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-500">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <span class="truncate">{{ $event->location }}</span>
                </div>
                @endif
            </a>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada agenda kegiatan.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
