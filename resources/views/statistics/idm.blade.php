@extends('layouts.app')

@section('title', 'Indeks Desa Membangun (IDM)')
@section('description', 'Capaian dan indikator Indeks Desa Membangun Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Indeks Desa Membangun (IDM)</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Statistik</span>
            <span class="sep">/</span>
            <span class="current">IDM</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        {{-- IDM Hero Banner --}}
        <div class="bg-gradient-to-br from-blue-900 to-indigo-950 rounded-3xl p-8 md:p-12 text-white shadow-xl mb-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <span class="badge badge-warning uppercase mb-3">Status Kemandirian Desa</span>
                <h2 class="text-3xl md:text-4xl font-black mb-2">DESA MANDIRI</h2>
                <p class="text-blue-200 text-sm">Skor IDM {{ $latest?->year ?? date('Y') }}: <strong class="text-amber-400 text-lg ml-1">{{ number_format($latest?->total_score ?? 0.8756, 4) }}</strong></p>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center shrink-0">
                <div class="bg-white/10 p-4 rounded-2xl glass">
                    <div class="text-xs text-blue-200">IKS (Sosial)</div>
                    <div class="text-xl font-bold text-white">{{ number_format($latest?->iks_score ?? 0.8823, 4) }}</div>
                </div>
                <div class="bg-white/10 p-4 rounded-2xl glass">
                    <div class="text-xs text-blue-200">IKE (Ekonomi)</div>
                    <div class="text-xl font-bold text-white">{{ number_format($latest?->ike_score ?? 0.8534, 4) }}</div>
                </div>
                <div class="bg-white/10 p-4 rounded-2xl glass">
                    <div class="text-xs text-blue-200">IKL (Lingkungan)</div>
                    <div class="text-xl font-bold text-white">{{ number_format($latest?->ikl_score ?? 0.8912, 4) }}</div>
                </div>
            </div>
        </div>

        {{-- History Table --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-12">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Skor IDM Tahunan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-slate-50 text-gray-900 font-bold border-b border-gray-100">
                        <tr>
                            <th class="p-3">Tahun</th>
                            <th class="p-3">Skor IDM</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">IKS (Sosial)</th>
                            <th class="p-3">IKE (Ekonomi)</th>
                            <th class="p-3">IKL (Lingkungan)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($idmScores as $score)
                        <tr>
                            <td class="p-3 font-bold text-gray-900">{{ $score->year }}</td>
                            <td class="p-3 font-mono font-bold text-blue-600">{{ number_format($score->total_score, 4) }}</td>
                            <td class="p-3"><span class="badge badge-success uppercase">{{ $score->status }}</span></td>
                            <td class="p-3">{{ number_format($score->iks_score, 4) }}</td>
                            <td class="p-3">{{ number_format($score->ike_score, 4) }}</td>
                            <td class="p-3">{{ number_format($score->ikl_score, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
