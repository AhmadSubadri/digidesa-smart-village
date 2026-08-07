@extends('layouts.app')

@section('title', 'Peta Interaktif Wilayah')
@section('description', 'Peta interaktif Kalurahan Condongcatur, Sleman dengan lokasi padukuhan, UMKM, dan objek wisata.')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Peta Interaktif Condongcatur</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Peta</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 mb-8">
            <div id="map" class="w-full h-[600px] rounded-2xl z-0"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-7.7500, 110.3833], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors | Kalurahan Condongcatur'
    }).addTo(map);

    // Kantor Kalurahan Marker
    L.marker([-7.7500, 110.3833]).addTo(map)
        .bindPopup('<b>Kantor Kalurahan Condongcatur</b><br>Jl. Manggis No. 1, Depok, Sleman')
        .openPopup();
</script>
@endpush
