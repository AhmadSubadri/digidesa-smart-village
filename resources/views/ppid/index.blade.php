@extends('layouts.app')

@section('title', 'PPID Dokumen Publik')
@section('description', 'Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Dokumen Publik (PPID)</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">PPID</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('ppid.index') }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Semua</a>
                <a href="{{ route('ppid.index', ['category' => 'berkala']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ request('category') === 'berkala' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Berkala</a>
                <a href="{{ route('ppid.index', ['category' => 'serta_merta']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ request('category') === 'serta_merta' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Serta Merta</a>
                <a href="{{ route('ppid.index', ['category' => 'setiap_saat']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ request('category') === 'setiap_saat' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Setiap Saat</a>
            </div>
        </div>

        <div class="space-y-4 max-w-4xl mx-auto">
            @forelse($documents as $doc)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between gap-4">
                <div>
                    <span class="badge badge-primary uppercase text-[10px] mb-1">{{ $doc->category }}</span>
                    <h3 class="font-bold text-gray-900 text-base mb-1">{{ $doc->title }}</h3>
                    <p class="text-xs text-gray-500">Tahun: {{ $doc->year }} | Diunduh: {{ number_format($doc->download_count ?? 0) }} kali</p>
                </div>
                <a href="{{ route('ppid.download', $doc->slug) }}" class="btn btn-outline text-xs py-2 px-4 shrink-0">
                    Unduh Dokumen
                </a>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada dokumen publik yang diunggah.
            </div>
            @endforelse
        </div>

        <div class="mt-8 max-w-4xl mx-auto">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
