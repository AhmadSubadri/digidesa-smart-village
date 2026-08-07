@extends('layouts.app')

@section('title', 'Lembaga Kalurahan')
@section('description', 'Daftar lembaga desa di Kalurahan Condongcatur (BPKal, LPMK, PKK, Karang Taruna, Linmas, dll).')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Lembaga Desa / Kalurahan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Pemerintahan</span>
            <span class="sep">/</span>
            <span class="current">Lembaga</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($institutions as $inst)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="badge badge-primary">{{ strtoupper($inst->abbreviation ?? 'Lembaga') }}</span>
                        <span class="text-xs text-gray-400 font-medium">Periode {{ $inst->period ?? '2023-2028' }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $inst->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Ketua: <strong class="text-gray-800">{{ $inst->chairman_name ?? '—' }}</strong>
                    </p>
                </div>
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>Anggota: <strong>{{ $inst->members_count ?? 0 }} orang</strong></span>
                    <span class="capitalize badge badge-gray">{{ $inst->type ?? 'Pemberdayaan' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
