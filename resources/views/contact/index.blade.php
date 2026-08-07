@extends('layouts.app')

@section('title', 'Kontak Kami')
@section('description', 'Hubungi Kalurahan Condongcatur, alamat kantor, telepon, email, dan Google Maps.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Hubungi Kami</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Kontak</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Contact Info --}}
            <div class="space-y-6">
                <div>
                    <span class="badge badge-primary uppercase mb-2">Kantor Kalurahan</span>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Kalurahan Condongcatur</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Kami siap melayani kebutuhan informasi dan administrasi warga. Silakan hubungi kami atau kunjungi kantor pelayanan pada jam kerja.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            📍
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Alamat Kantor</h4>
                            <p class="text-xs text-gray-600">Jl. Manggis No. 1, Condongcatur, Depok, Sleman, D.I. Yogyakarta 55283</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            📞
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Telepon & WhatsApp</h4>
                            <p class="text-xs text-gray-600">(0274) 881094 | WhatsApp: +62 812-3456-7890</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                            ✉️
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Email Resmi</h4>
                            <p class="text-xs text-gray-600">condongcatur1946@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 text-lg mb-6">Kirim Pesan</h3>

                @if(session('success'))
                <div class="p-4 bg-green-50 text-green-700 rounded-xl text-xs font-semibold mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('kontak.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Anda*</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Nama Lengkap">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Anda*</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="email@contoh.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Subjek / Perihal*</label>
                        <input type="text" name="subject" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Perihal pesan">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pesan*</label>
                        <textarea name="message" rows="4" required class="w-full p-4 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600" placeholder="Tuliskan pesan Anda..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 text-sm">
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
