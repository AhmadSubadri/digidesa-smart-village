@extends('layouts.app')

@section('title', 'Buku Tamu Digital')
@section('description', 'Buku Tamu Digital Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Buku Tamu Digital</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Buku Tamu</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Form --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Isi Buku Tamu</h2>

                @if(session('success'))
                <div class="p-4 bg-green-50 text-green-700 rounded-xl text-xs font-semibold mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('buku-tamu.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Tamu*</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Nama Lengkap">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Instansi / Asal</label>
                        <input type="text" name="institution" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Perusahaan / Kampus / Umum">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. HP / WA*</label>
                        <input type="text" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="0812xxxxxxxx">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Maksud & Tujuan Kunjungan*</label>
                        <textarea name="purpose" rows="3" required class="w-full p-4 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Jelaskan maksud kunjungan Anda..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 text-sm">
                        Simpan Buku Tamu
                    </button>
                </form>
            </div>

            {{-- List --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Daftar Pengunjung Terbaru</h2>

                    <div class="space-y-4">
                        @forelse($guests as $guest)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($guest->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $guest->name }}</h4>
                                    <span class="text-xs text-gray-400">{{ $guest->created_at->diffForHumans() }}</span>
                                </div>
                                @if($guest->institution)
                                <span class="badge badge-primary text-[10px] mb-2">{{ $guest->institution }}</span>
                                @endif
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $guest->purpose }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-gray-500 py-8 text-sm">
                            Belum ada entri buku tamu.
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
