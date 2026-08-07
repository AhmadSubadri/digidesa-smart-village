@extends('layouts.app')

@section('title', 'Transparansi Pembangunan')
@section('description', 'Data progres dan realisasi proyek pembangunan fisik Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Transparansi Pembangunan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Transparansi</span>
            <span class="sep">/</span>
            <span class="current">Pembangunan</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($developments as $dev)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div>
                    <span class="badge badge-primary uppercase mb-2">{{ $dev->status ?? 'Ongoing' }}</span>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $dev->title }}</h3>
                    <p class="text-xs text-gray-500 mb-4">Lokasi: {{ $dev->location }}</p>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progres Pembangunan</span>
                            <span class="font-bold text-blue-600">{{ $dev->progress_percentage ?? 0 }}%</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $dev->progress_percentage ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>Anggaran: <strong class="text-gray-900">Rp {{ number_format($dev->budget ?? 0, 0, ',', '.') }}</strong></span>
                    <span>Sumber: {{ $dev->funding_source ?? 'Dana Desa' }}</span>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada data proyek pembangunan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
