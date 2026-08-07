@extends('layouts.app')

@section('title', 'Transparansi Bantuan Sosial')
@section('description', 'Informasi program dan transparansi penerima bantuan sosial di Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Program Bantuan Sosial (Bansos)</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Transparansi</span>
            <span class="sep">/</span>
            <span class="current">Bansos</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programs as $prog)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div>
                    <span class="badge badge-success font-mono mb-2">{{ $prog->code }}</span>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $prog->name }}</h3>
                    <p class="text-gray-600 text-xs leading-relaxed mb-4">{{ $prog->description }}</p>
                </div>
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>Sumber: <strong>{{ $prog->source }}</strong></span>
                    <span class="badge badge-primary">Aktif</span>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-500">
                Belum ada program bantuan sosial aktif.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
