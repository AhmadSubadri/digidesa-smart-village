@extends('layouts.app')

@section('title', 'Verifikasi Keabsahan Surat Resmi')
@section('description', 'Layanan publik verifikasi keabsahan dokumen dan surat resmi ber-TTE digital Pemerintah Desa.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Verifikasi Keabsahan Dokumen</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('layanan.index') }}">Layanan</a>
            <span class="sep">/</span>
            <span class="current">Verifikasi Surat</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl p-6 md:p-10 shadow-lg border border-gray-100 text-center">

            @if($isValid && $letter)
                {{-- BADGE VALID --}}
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5 ring-8 ring-emerald-50/50">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-3">
                    DOKUMEN RESMI TERVERIFIKASI
                </span>
                
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    {{ $letter->letterType?->name ?? 'Surat Keterangan Resmi' }}
                </h2>
                <p class="text-xs text-gray-500 mb-6">
                    Diterbitkan oleh Pemerintah {{ setting('village_name', 'Desa') }}, Kec. {{ setting('district_name', 'Kecamatan') }}, Kab. {{ setting('regency_name', 'Kabupaten') }}
                </p>

                <div class="bg-slate-50 p-6 rounded-2xl text-left space-y-3.5 text-sm mb-6 border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">Nomor Surat Resmi:</span>
                        <span class="font-mono font-bold text-gray-900">{{ $letter->letter_number ?? $letter->request_number }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">Nama Pemohon:</span>
                        <span class="font-bold text-gray-900">{{ $letter->applicant_name }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">NIK Pemohon:</span>
                        <span class="font-mono text-gray-800">{{ $maskedNik }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">Keperluan / Keterangan:</span>
                        <span class="font-medium text-gray-800">{{ $letter->purpose }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">Tanggal Pengesahan:</span>
                        <span class="font-medium text-gray-800">
                            {{ $letter->completed_at ? \Carbon\Carbon::parse($letter->completed_at)->translatedFormat('d F Y') : ($letter->created_at ? \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') : date('d F Y')) }}
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200/80 pb-2.5">
                        <span class="text-gray-500 text-xs sm:text-sm">Penandatangan Resmi:</span>
                        <span class="font-bold text-blue-900">{{ setting('leader_title', 'Kepala Desa') }} ({{ setting('leader_name', 'Pemerintah Desa') }})</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <span class="text-gray-500 text-xs sm:text-sm">Digital Fingerprint (SHA-256):</span>
                        <span class="font-mono text-[11px] text-gray-500 break-all sm:text-right max-w-xs">{{ $fingerprint }}</span>
                    </div>
                </div>

                @if(!empty($letter->pdf_path) && Storage::disk('public')->exists($letter->pdf_path))
                    <div class="mb-6">
                        <a href="{{ Storage::disk('public')->url($letter->pdf_path) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-sm shadow hover:opacity-95 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh Salinan Asli PDF
                        </a>
                    </div>
                @endif

                <p class="text-xs text-gray-500 leading-relaxed">
                    Dokumen ini sah diterbitkan melalui Sistem Informasi Resmi <strong>{{ setting('village_name', setting('site_name', 'Pemerintah Desa')) }}</strong>. QR Code dan tanda tangan digital ini memiliki kekuatan hukum administratif yang mengikat sesuai peraturan perundang-undangan.
                </p>

            @else
                {{-- BADGE INVALID --}}
                <div class="w-20 h-20 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-5 ring-8 ring-rose-50/50">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <span class="inline-block bg-rose-100 text-rose-800 text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-3">
                    DOKUMEN TIDAK TERDAFTAR / INVALID
                </span>

                <h2 class="text-2xl font-extrabold text-gray-900 mb-4">
                    Data Surat Tidak Ditemukan
                </h2>

                <div class="bg-rose-50/70 p-5 rounded-2xl text-left text-sm mb-6 border border-rose-200 text-rose-900 leading-relaxed">
                    <p class="font-semibold mb-1">Perhatian:</p>
                    <p>
                        Token atau Nomor Surat <strong>"{{ $token }}"</strong> tidak terdaftar dalam basis data resmi Pemerintah Desa. Waspadai adanya indikasi pemalsuan dokumen surat menyurat.
                    </p>
                </div>

                <a href="{{ route('layanan.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gray-900 text-white font-semibold text-sm shadow hover:bg-gray-800 transition">
                    Kembali ke Pusat Layanan
                </a>
            @endif

        </div>
    </div>
</div>
@endsection
