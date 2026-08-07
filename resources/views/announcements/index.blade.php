@extends('layouts.app')

@section('title', 'Pengumuman Resmi')
@section('description', 'Daftar pengumuman dan edaran resmi dari Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Pengumuman Resmi</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Pengumuman</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="space-y-4 max-w-4xl mx-auto">
            @forelse($announcements as $ann)
            <a href="{{ route('pengumuman.show', $ann->id) }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4 hover:shadow-md transition-all group">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-1
                    {{ $ann->priority === 'urgent' ? 'bg-red-100 text-red-600' : ($ann->priority === 'important' ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600') }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        @if($ann->priority === 'urgent')
                        <span class="badge badge-danger">Urgent</span>
                        @elseif($ann->priority === 'important')
                        <span class="badge badge-warning">Penting</span>
                        @endif
                        <span class="text-xs text-gray-400">{{ $ann->updated_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition-colors">
                        {{ $ann->title }}
                    </h3>
                </div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-600 shrink-0 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @empty
            <div class="bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada pengumuman.
            </div>
            @endforelse
        </div>

        <div class="mt-8 max-w-4xl mx-auto">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
