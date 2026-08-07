@extends('layouts.app')

@section('title', 'Layanan Publik Mandiri')
@section('description', 'Portal layanan administrasi publik dan permohonan surat keterangan Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Layanan Publik Mandiri</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Layanan</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        {{-- Banner Portal Warga CTA --}}
        <div class="bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-8 md:p-12 text-white shadow-xl mb-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <span class="badge badge-warning mb-3">Portal Warga Condongcatur</span>
                <h2 class="text-3xl font-extrabold mb-3">Pengurusan Surat Lebih Cepat & Praktis secara Online</h2>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Masuk ke Portal Warga menggunakan NIK untuk mengajukan permohonan surat keterangan, melacak status, dan mengunduh surat ber-QR Code resmi.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="{{ route('warga.login') }}" class="btn btn-accent px-6 py-3">
                    Masuk Portal Warga
                </a>
                <a href="{{ route('warga.register') }}" class="btn btn-secondary px-6 py-3">
                    Daftar Akun
                </a>
            </div>
        </div>

        {{-- List Surat --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Daftar Jenis Surat yang Dapat Diajukan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($letterTypes as $type)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="badge badge-primary font-mono">{{ $type->code }}</span>
                            <span class="text-xs text-gray-400">Estimasi: {{ $type->estimated_days ?? 1 }} hari</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-base mb-2">{{ $type->name }}</h3>
                        <p class="text-gray-600 text-xs leading-relaxed mb-4">{{ $type->description }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-green-600">Gratis (Rp 0)</span>
                        <a href="{{ route('warga.login') }}" class="btn btn-outline text-xs py-1.5 px-3">
                            Ajukan Surat →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
