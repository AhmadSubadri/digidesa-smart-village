@extends('layouts.app')

@section('title', '404 Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-20">
    <div class="container-sid text-center">
        <div class="max-w-md mx-auto bg-white rounded-3xl p-10 shadow-sm border border-gray-100">
            <div class="text-6xl font-black text-blue-900 mb-2">404</div>
            <h1 class="text-xl font-bold text-gray-900 mb-2">Halaman Tidak Ditemukan</h1>
            <p class="text-gray-500 text-xs leading-relaxed mb-6">
                Maaf, halaman atau dokumen yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary text-xs py-2.5">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
