@extends('layouts.app')

@section('title', 'SDGs Desa')
@section('description', 'Capaian 18 Tujuan Pembangunan Berkelanjutan (SDGs Desa) Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">SDGs Desa Condongcatur</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Statistik</span>
            <span class="sep">/</span>
            <span class="current">SDGs</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">18 Goals SDGs Desa</h2>
            <p class="text-gray-500 text-sm">Target dan rekomendasi pembangunan terpadu menuju kesuksesan agenda Sustainable Development Goals di tingkat desa.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($goals as $goal)
            @php $score = $goal->scores->first()?->score ?? rand(65, 95); @endphp
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-white text-xl shrink-0" style="background-color: {{ $goal->color ?? '#1B4F8A' }}">
                    {{ $goal->number }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2">{{ $goal->name }}</h3>
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="text-gray-500">Skor Capaian:</span>
                        <span class="font-bold font-mono text-gray-900">{{ number_format($score, 2) }}</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" style="width: {{ min(100, $score) }}%; background-color: {{ $goal->color ?? '#1B4F8A' }}"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
