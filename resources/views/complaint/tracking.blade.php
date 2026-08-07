@extends('layouts.app')

@section('title', 'Lacak Pengaduan')
@section('description', 'Status penanganan pengaduan warga Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Status Pengaduan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('pengaduan.index') }}">Pengaduan</a>
            <span class="sep">/</span>
            <span class="current">Tracking</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-2xl mx-auto">
            @if($complaint)
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <span class="text-xs text-gray-400 font-mono">Tiket #{{ $complaint->ticket_number }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $complaint->title }}</h2>
                    </div>
                    <span class="badge badge-primary uppercase">{{ $complaint->status }}</span>
                </div>
                <p class="text-gray-600 text-sm mb-6">{!! nl2br(e($complaint->content)) !!}</p>

                @if($complaint->response)
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 text-sm">
                    <div class="font-bold text-blue-900 mb-1">Tanggapan Petugas Kalurahan:</div>
                    <div class="text-blue-800">{!! nl2br(e($complaint->response)) !!}</div>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100">
                <p class="text-gray-500 text-sm mb-4">Nomor tiket pengaduan <strong class="font-mono text-gray-900">{{ $ticket ?? '' }}</strong> tidak ditemukan.</p>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline text-xs">
                    ← Kembali
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
