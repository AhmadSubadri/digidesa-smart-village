@extends('layouts.app')

@section('title', 'Sejarah Desa')
@section('description', 'Sejarah dan asal-usul ditemukannya Kalurahan Condongcatur sejak berdirinya pada tahun 1946.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Sejarah Kalurahan Condongcatur</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Profil</span>
            <span class="sep">/</span>
            <span class="current">Sejarah</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">
                    Asal Usul Nama & Pembentukan (1946)
                </h2>
                <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed space-y-4">
                    <p>
                        Kalurahan Condongcatur terbentuk berdasarkan <strong>Maklumat Pemerintah Daerah Istimewa Yogyakarta Nomor 5 Tahun 1946</strong> tentang Penggabungan Kelurahan-Kelurahan. Sebelum terbentuk Kalurahan Condongcatur, wilayah ini terdiri dari 4 (empat) kelurahan lama yaitu:
                    </p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Kelurahan Manukberi</strong> (kini Padukuhan Gejayan, Mrican, Soropadan)</li>
                        <li><strong>Kelurahan Gorongan</strong> (kini Padukuhan Kayen, Kentungan, Manggung)</li>
                        <li><strong>Kelurahan Kolombo</strong> (kini Padukuhan Kledokan, Nologaten, Tambakbayan)</li>
                        <li><strong>Kelurahan Sanggrahan</strong> (kini Padukuhan Sanggrahan, Ringinsari, Dll)</li>
                    </ul>
                    <p>
                        Keempat kelurahan tersebut kemudian sepakat untuk bergabung (*condong*) menjadi satu wadah pemerintahan tunggal (*catur* yang berarti empat). Dari sinilah nama <strong>Condongcatur</strong> digagas yang secara filosofis bermakna *"Kesepakatan dan persatuan dari empat wilayah kelurahan menjadi satu kesatuan yang harmonis"*.
                    </p>
                </div>
            </div>

            {{-- TIMELINE --}}
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Timeline Sejarah Perjalanan</h3>

                <div class="relative border-l-2 border-blue-600 ml-4 md:ml-32 space-y-10">
                    @php
                        $timeline = [
                            ['year' => '1946', 'title' => 'Penggabungan 4 Kelurahan', 'desc' => 'Maklumat DIY No. 5 Tahun 1946 secara resmi menggabungkan 4 kelurahan lama menjadi Kalurahan Condongcatur.'],
                            ['year' => '1975', 'title' => 'Pembangunan Kantor Kalurahan Baru', 'desc' => 'Peresmian kantor balai desa di lokasi strategis Jalan Manggis No. 1 Condongcatur.'],
                            ['year' => '1999', 'title' => 'Perkembangan Kawasan Pendidikan', 'desc' => 'Condongcatur berkembang pesat sebagai kawasan perguruan tinggi terbesar di DIY (UNY, UPN, UII, AMIKOM).'],
                            ['year' => '2020', 'title' => 'Predikat Desa Mandiri (IDM)', 'desc' => 'Meraih status Desa Mandiri dari Kementerian Desa dengan skor Indeks Desa Membangun tertinggi.'],
                            ['year' => '2025', 'title' => 'Era Digitalisasi Smart Village', 'desc' => 'Peluncuran Sistem Informasi Desa v2.0 (Condongcatur Digital) untuk transparansi dan layanan mandiri warga.'],
                        ];
                    @endphp

                    @foreach($timeline as $item)
                    <div class="relative pl-8">
                        {{-- Dot --}}
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-blue-600 border-4 border-white shadow"></div>
                        {{-- Year box --}}
                        <div class="md:absolute md:-left-32 md:top-0 font-extrabold text-blue-900 text-lg mb-1 md:mb-0">
                            {{ $item['year'] }}
                        </div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $item['title'] }}</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
