@extends('layouts.app')

@section('title', 'Statistik Kependudukan')
@section('description', 'Grafik dan data statistik kependudukan Kalurahan Condongcatur.')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Statistik Kependudukan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Statistik</span>
            <span class="sep">/</span>
            <span class="current">Kependudukan</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['total']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Total Penduduk</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['kk']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Kepala Keluarga</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-blue-600">{{ number_format($stats['laki']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Laki-Laki (49,7%)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-pink-600">{{ number_format($stats['perempuan']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Perempuan (50,3%)</div>
            </div>
        </div>

        {{-- ApexCharts Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            {{-- Chart 1: Gender Distribution --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Komposisi Jenis Kelamin</h3>
                <div id="chart-gender"></div>
            </div>

            {{-- Chart 2: Age Pyramid --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Kelompok Usia Penduduk</h3>
                <div id="chart-age"></div>
            </div>

        </div>

        {{-- Demographics breakdown cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Ringkasan Kelompok Usia</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span>Anak-anak (0-14 Thn)</span>
                            <span>5.820 Jiwa (20.5%)</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 20.5%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span>Usia Produktif (15-64 Thn)</span>
                            <span>19.500 Jiwa (68.7%)</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: 68.7%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span>Lanjut Usia (65+ Thn)</span>
                            <span>3.074 Jiwa (10.8%)</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: 10.8%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Tingkat Pendidikan</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between p-2 bg-slate-50 rounded-lg"><span>Sarjana / S1-S3</span><span class="font-bold">6.420 (22.6%)</span></div>
                    <div class="flex justify-between p-2 bg-slate-50 rounded-lg"><span>Diploma / D1-D4</span><span class="font-bold">3.150 (11.1%)</span></div>
                    <div class="flex justify-between p-2 bg-slate-50 rounded-lg"><span>SMA / SLTA</span><span class="font-bold">11.240 (39.6%)</span></div>
                    <div class="flex justify-between p-2 bg-slate-50 rounded-lg"><span>SMP / SLTP</span><span class="font-bold">4.200 (14.8%)</span></div>
                    <div class="flex justify-between p-2 bg-slate-50 rounded-lg"><span>SD / Belum Sekolah</span><span class="font-bold">3.384 (11.9%)</span></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Gender Donut Chart
    new ApexCharts(document.querySelector("#chart-gender"), {
        series: [{{ $stats['laki'] }}, {{ $stats['perempuan'] }}],
        labels: ['Laki-Laki', 'Perempuan'],
        chart: { type: 'donut', height: 300 },
        colors: ['#2563EB', '#EC4899'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true }
    }).render();

    // Age Bar Chart
    new ApexCharts(document.querySelector("#chart-age"), {
        series: [{ name: 'Penduduk', data: [1850, 3970, 7200, 6800, 5500, 3074] }],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        colors: ['#1B4F8A'],
        plotOptions: { bar: { borderRadius: 8, horizontal: false } },
        xaxis: { categories: ['0-4 Thn', '5-14 Thn', '15-29 Thn', '30-49 Thn', '50-64 Thn', '65+ Thn'] }
    }).render();
</script>
@endpush
