@extends('layouts.app')

@section('title', 'Demografi & Statistik Penduduk')
@section('description', 'Statistik kependudukan, komposisi jenis kelamin, dan usia warga Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Demografi Kependudukan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Profil</span>
            <span class="sep">/</span>
            <span class="current">Demografi</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['total_penduduk']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Total Penduduk</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['total_kk']) }}</div>
                <div class="text-sm font-semibold text-gray-600 mt-1">Kepala Keluarga</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['laki']) }}</div>
                <div class="text-sm font-semibold text-blue-600 mt-1">Laki-Laki</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['perempuan']) }}</div>
                <div class="text-sm font-semibold text-pink-600 mt-1">Perempuan</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Visualisasi Interaktif Dashboard Kependudukan</h2>
            <p class="text-gray-500 mb-6">Akses grafik demografi lengkap seperti struktur usia, pendidikan, pekerjaan, dan agama di menu Statistik.</p>
            <a href="{{ route('statistik.kependudukan') }}" class="btn btn-primary">
                Buka Dashboard Statistik Kependudukan
            </a>
        </div>
    </div>
</div>
@endsection
