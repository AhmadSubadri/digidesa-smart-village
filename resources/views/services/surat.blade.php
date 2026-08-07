@extends('layouts.app')

@section('title', 'Katalog Surat Keterangan')
@section('description', 'Katalog dan syarat pengurusan surat keterangan Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Katalog Surat Keterangan</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('layanan.index') }}">Layanan</a>
            <span class="sep">/</span>
            <span class="current">Surat</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($letterTypes as $type)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div>
                    <span class="badge badge-primary font-mono mb-2">{{ $type->code }}</span>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $type->name }}</h3>
                    <p class="text-gray-600 text-xs leading-relaxed mb-4">{{ $type->description }}</p>

                    @if(is_array($type->requirements))
                    <div class="bg-slate-50 p-3 rounded-xl mb-4 text-xs text-gray-600">
                        <div class="font-bold text-gray-800 mb-1">Persyaratan Document:</div>
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($type->requirements as $req)
                            <li>{{ is_array($req) ? ($req['label'] ?? '') : $req }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <a href="{{ route('warga.login') }}" class="btn btn-primary text-xs py-2 w-full">
                    Ajukan Sekarang
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
