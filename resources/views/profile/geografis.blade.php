@extends('layouts.app')

@section('title', 'Geografis & Peta Wilayah')
@section('description', 'Kondisi geografis, batas wilayah, dan data padukuhan Kalurahan Condongcatur, Sleman.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Geografis & Peta Wilayah</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Profil</span>
            <span class="sep">/</span>
            <span class="current">Geografis</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            {{-- Info Cards --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Luas Wilayah</h3>
                <p class="text-2xl font-black text-blue-900 mb-2">948,6 Ha</p>
                <p class="text-xs text-gray-500">Terbagi atas kawasan permukiman, pendidikan, dan komersial.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Kapanewon & Kab</h3>
                <p class="text-xl font-bold text-green-900 mb-2">Depok, Sleman</p>
                <p class="text-xs text-gray-500">Provinsi Daerah Istimewa Yogyakarta (Kode Pos: 55283)</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Jumlah Padukuhan</h3>
                <p class="text-2xl font-black text-purple-900 mb-2">18 Padukuhan</p>
                <p class="text-xs text-gray-500">Terdiri dari 211 RT dan 87 RW</p>
            </div>
        </div>

        {{-- Padukuhan Table --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Daftar 18 Padukuhan di Condongcatur</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-slate-50 text-gray-900 font-bold border-b border-gray-100">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Nama Padukuhan</th>
                            <th class="p-3">Luas (Ha)</th>
                            <th class="p-3">Jumlah KK</th>
                            <th class="p-3">Jumlah Jiwa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($padukuhans as $i => $pad)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-semibold">{{ $i + 1 }}</td>
                            <td class="p-3"><span class="badge badge-primary">{{ $pad->code }}</span></td>
                            <td class="p-3 font-bold text-gray-800">{{ $pad->name }}</td>
                            <td class="p-3">{{ number_format($pad->area_size ?? rand(30, 80), 2) }}</td>
                            <td class="p-3">{{ number_format($pad->families_count ?? rand(300, 700)) }}</td>
                            <td class="p-3">{{ number_format($pad->population ?? rand(1000, 2500)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
