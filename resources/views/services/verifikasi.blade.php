@extends('layouts.app')

@section('title', 'Verifikasi Keabsahan Surat')
@section('description', 'Halaman publik verifikasi keabsahan dokumen dan surat resmi Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Verifikasi Keabsahan Surat</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('layanan.index') }}">Layanan</a>
            <span class="sep">/</span>
            <span class="current">Verifikasi</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">

            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <span class="badge badge-success text-xs uppercase mb-2">DOKUMEN VALID & TERVERIFIKASI</span>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Surat Keterangan Kalurahan Condongcatur</h2>

            <div class="bg-slate-50 p-6 rounded-2xl text-left space-y-3 text-sm mb-6 border border-slate-200">
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-gray-500">Nomor Surat:</span>
                    <span class="font-mono font-bold text-gray-900">470/128/CC/2025</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-gray-500">Jenis Surat:</span>
                    <span class="font-bold text-gray-900">Surat Keterangan Domisili (SKD)</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-gray-500">Tanggal Terbit:</span>
                    <span class="text-gray-900">{{ date('d F Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-gray-500">Penandatangan:</span>
                    <span class="font-bold text-blue-900">Lurah Condongcatur (Drs. H. Ahmad Mukhlis, M.Si)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Token Keabsahan:</span>
                    <span class="font-mono text-xs text-gray-500 truncate max-w-[200px]">{{ $token ?? 'VALID-TOKEN-CC-2025' }}</span>
                </div>
            </div>

            <p class="text-xs text-gray-500">
                Dokumen ini diterbitkan secara sah oleh Pemerintah Kalurahan Condongcatur, Kapanewon Depok, Kabupaten Sleman melalui Sistem Informasi Desa Condongcatur Digital.
            </p>
        </div>
    </div>
</div>
@endsection
