@extends('layouts.app')

@section('title', $announcement->title)
@section('description', Str::limit(strip_tags($announcement->content), 150))

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">{{ $announcement->title }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('pengumuman.index') }}">Pengumuman</a>
            <span class="sep">/</span>
            <span class="current">Detail</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 mb-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 text-xs text-gray-500">
                    <span class="badge badge-primary uppercase">{{ $announcement->priority }}</span>
                    <span>Dipublikasikan: {{ $announcement->created_at->translatedFormat('d F Y') }}</span>
                </div>

                <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed mb-8">
                    {!! $announcement->content !!}
                </div>

                @if($announcement->attachment_path)
                <div class="p-4 bg-blue-50 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-blue-900 font-semibold">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lampiran Dokumen Resmi
                    </div>
                    <a href="{{ Storage::url($announcement->attachment_path) }}" target="_blank" class="btn btn-primary text-xs">
                        Unduh Lampiran
                    </a>
                </div>
                @endif
            </div>

            <a href="{{ route('pengumuman.index') }}" class="btn btn-outline">
                ← Kembali ke Pengumuman
            </a>
        </div>
    </div>
</div>
@endsection
