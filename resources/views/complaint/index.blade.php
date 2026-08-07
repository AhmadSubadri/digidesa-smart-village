@extends('layouts.app')

@section('title', 'Layanan Pengaduan Warga')
@section('description', 'Fasilitas penyampaian aspirasi dan pengaduan warga Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Layanan Pengaduan Warga</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Pengaduan</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Complaint Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Form Sampaikan Pengaduan / Aspirasi</h2>

                    @if(session('success'))
                    <div class="p-4 bg-green-50 text-green-700 rounded-xl text-sm font-semibold mb-6">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('pengaduan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul Pengaduan / Topik*</label>
                            <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Misal: Perbaikan Jalan Rusak Padukuhan Kayen">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori*</label>
                                <select name="category" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600">
                                    <option value="infrastruktur">Infrastruktur & Fasilitas</option>
                                    <option value="pelayanan">Pelayanan Administrasi</option>
                                    <option value="kebersihan">Kebersihan & Lingkungan</option>
                                    <option value="keamanan">Kamtibmas</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Lokasi Kejadian</label>
                                <input type="text" name="location" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Padukuhan / RT / RW">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Isi Laporan / Pengaduan*</label>
                            <textarea name="content" rows="4" required class="w-full p-4 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Uraikan laporan pengaduan Anda dengan jelas..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pelapor*</label>
                                <input type="text" name="reporter_name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Nama Anda">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp / Telepon*</label>
                                <input type="text" name="reporter_phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="0812xxxxxxxx">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-full py-3 text-sm mt-4">
                            Kirim Pengaduan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tracking Widget --}}
            <div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h3 class="font-bold text-gray-900 text-base mb-3">Lacak Status Pengaduan</h3>
                    <form action="{{ route('pengaduan.tracking') }}" method="GET" class="space-y-3">
                        <input type="text" name="ticket" placeholder="Masukkan Nomor Tiket (ADU-...)" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600 font-mono">
                        <button type="submit" class="btn btn-primary w-full py-2.5 text-xs">
                            Cek Status Tiket
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
