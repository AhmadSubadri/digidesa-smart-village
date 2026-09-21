@extends('layouts.app')

@section('title', 'Formulir Permohonan — ' . $letterType->name)
@section('description', 'Formulir pengajuan online ' . $letterType->name . ' bagi warga terdaftar.')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-white tracking-tight">Formulir Permohonan Surat</h1>
                <div class="flex items-center gap-2 text-xs text-blue-200/80 mt-1.5 font-medium">
                    <a href="{{ route('warga.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('warga.surat.create') }}" class="hover:text-white transition-colors">Pilih Surat</a>
                    <span>/</span>
                    <span class="text-white">{{ $letterType->code }}</span>
                </div>
            </div>
            <a href="{{ route('warga.surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-sm border border-white/15 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Katalog
            </a>
        </div>
    </div>
</div>

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]">
    <div class="container-sid">
        <div class="max-w-3xl mx-auto">

            {{-- Letter Information Banner --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80 mb-8">
                <div class="flex items-start justify-between gap-4 flex-wrap pb-6 border-b border-slate-100 dark:border-slate-700/80">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 font-mono font-bold text-xs">
                                {{ $letterType->code }}
                            </span>
                            <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                                ⏱️ Estimasi Proses: {{ $letterType->estimated_days ?? 1 }} Hari Kerja
                            </span>
                        </div>
                        <h2 class="text-xl lg:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ $letterType->name }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                            {{ $letterType->description ?? 'Pengajuan surat resmi dengan verifikasi berkas dan pengesahan tanda tangan elektronik (TTE).' }}
                        </p>
                    </div>
                </div>

                {{-- Applicant Identity Preview --}}
                <div class="mt-6 bg-slate-50 dark:bg-slate-900/60 rounded-2xl p-4 lg:p-5 border border-slate-200/60 dark:border-slate-700/60">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            Data Pemohon (Sesuai Akun Terdaftar)
                        </span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-md border border-emerald-200 dark:border-emerald-800">
                            Auto-Verified
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="text-slate-400">Nama Lengkap:</span>
                            <div class="font-bold text-slate-800 dark:text-slate-100 mt-0.5">{{ $warga->name }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">NIK:</span>
                            <div class="font-mono font-bold text-slate-800 dark:text-slate-100 mt-0.5">{{ $warga->nik }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">Nomor Telepon/WA:</span>
                            <div class="font-medium text-slate-800 dark:text-slate-100 mt-0.5">{{ $warga->phone ?? '-' }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">Alamat / Padukuhan:</span>
                            <div class="font-medium text-slate-800 dark:text-slate-100 mt-0.5">
                                {{ $warga->resident?->padukuhan?->name ?? 'Wilayah Desa' }}
                                @if($warga->resident?->rt_id || $warga->resident?->rw_id)
                                (RT {{ $warga->resident->rt?->number ?? '-' }} / RW {{ $warga->resident->rw?->number ?? '-' }})
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submission Form --}}
                <form action="{{ route('warga.surat.store', $letterType->code) }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf

                    {{-- Purpose Field --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Keperluan / Alasan Pembuatan Surat*
                        </label>
                        <textarea
                            name="purpose"
                            rows="3"
                            required
                            placeholder="Contoh: Digunakan sebagai syarat kelengkapan pendaftaran beasiswa kuliah, permohonan kredit usaha di bank, dll."
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none @error('purpose') border-red-500 @enderror"
                        >{{ old('purpose') }}</textarea>
                        <span class="text-[11px] text-slate-400 mt-1 block">Tuliskan tujuan penggunaan surat dengan jelas dan lengkap.</span>
                        @error('purpose')
                        <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Additional Notes (Optional) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Catatan Tambahan untuk Petugas (Opsional)
                        </label>
                        <input
                            type="text"
                            name="notes"
                            value="{{ old('notes') }}"
                            placeholder="Catatan khusus bila ada (misal: mohon diproses sebelum tanggal tertentu)"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    {{-- Dynamic Requirements File Uploads --}}
                    @if(is_array($letterType->requirements) && count($letterType->requirements) > 0)
                    <div class="pt-6 border-t border-slate-100 dark:border-slate-700/80 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Unggah Berkas Persyaratan Lampiran
                            </h3>
                            <span class="text-[10px] text-slate-400 font-mono">Format: JPG, PNG, PDF (Maks. 5MB)</span>
                        </div>

                        <div class="space-y-4">
                            @foreach($letterType->requirements as $i => $req)
                            @php $label = is_array($req) ? ($req['label'] ?? 'Dokumen Pendukung') : $req; @endphp
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-700/80">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-2">
                                    {{ $i + 1 }}. {{ $label }}
                                </label>
                                <input
                                    type="file"
                                    name="attachments[]"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer transition-all"
                                >
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Submit & Cancel Buttons --}}
                    <div class="pt-6 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between gap-4">
                        <a href="{{ route('warga.surat.create') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black shadow-lg shadow-blue-500/25 flex items-center gap-2 transition-all">
                            <span>Kirim Permohonan Surat</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
