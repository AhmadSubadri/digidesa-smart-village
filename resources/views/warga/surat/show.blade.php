@extends('layouts.app')

@section('title', 'Detail Permohonan — ' . $letterRequest->request_number)
@section('description', 'Status dan pelacakan riwayat permohonan surat administrasi mandiri.')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-white tracking-tight">Pelacakan Status Permohonan</h1>
                <div class="flex items-center gap-2 text-xs text-blue-200/80 mt-1.5 font-medium">
                    <a href="{{ route('warga.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('warga.surat.index') }}" class="hover:text-white transition-colors">Riwayat Surat</a>
                    <span>/</span>
                    <span class="text-white font-mono">{{ $letterRequest->request_number }}</span>
                </div>
            </div>
            <a href="{{ route('warga.surat.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-sm border border-white/15 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
            @endif

            {{-- Top Overview Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100 dark:border-slate-700/80">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            <span class="px-2.5 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 font-mono font-bold text-xs">
                                {{ $letterRequest->letterType?->code }}
                            </span>
                            <span class="font-mono text-xs text-slate-400">
                                Tiket: <strong>{{ $letterRequest->request_number }}</strong>
                            </span>
                        </div>
                        <h2 class="text-xl lg:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ $letterRequest->letterType?->name ?? 'Surat Keterangan' }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Diajukan pada {{ $letterRequest->created_at->translatedFormat('l, d F Y - H:i') }} WIB
                        </p>
                    </div>

                    {{-- Status Badge & Action --}}
                    <div class="flex items-center gap-3 flex-wrap">
                        @php
                            $statusMap = [
                                'submitted' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800', 'label' => 'Diajukan', 'step' => 1],
                                'pending' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800', 'label' => 'Menunggu Verifikasi', 'step' => 1],
                                'verifying' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800', 'label' => 'Verifikasi Berkas', 'step' => 2],
                                'processing' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800', 'label' => 'Sedang Diproses', 'step' => 2],
                                'waiting_signature' => ['badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800', 'label' => 'Proses Tanda Tangan', 'step' => 3],
                                'approved' => ['badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800', 'label' => 'Disetujui', 'step' => 3],
                                'completed' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800', 'label' => 'Selesai & Terbit', 'step' => 4],
                                'rejected' => ['badge' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800', 'label' => 'Permohonan Ditolak', 'step' => 0],
                                'revision' => ['badge' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-950/40 dark:text-orange-300 dark:border-orange-800', 'label' => 'Perlu Revisi Berkas', 'step' => 0],
                                'cancelled' => ['badge' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700', 'label' => 'Permohonan Dibatalkan', 'step' => 0],
                            ];
                            $st = $statusMap[$letterRequest->status] ?? ['badge' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($letterRequest->status), 'step' => 1];
                            $currentStep = $st['step'];
                        @endphp
                        
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $st['badge'] }}">
                            {{ $st['label'] }}
                        </span>

                        @if(in_array($letterRequest->status, ['submitted', 'pending']))
                        <form action="{{ route('warga.surat.cancel', $letterRequest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permohonan surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold transition-colors">
                                Batalkan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                {{-- Visual 4-Stage Stepper (if not rejected/cancelled) --}}
                @if($currentStep > 0)
                <div class="pt-8 pb-4">
                    <div class="grid grid-cols-4 gap-2 relative">
                        {{-- Connecting line background --}}
                        <div class="absolute top-4 left-[12%] right-[12%] h-1 bg-slate-200 dark:bg-slate-700 -z-0"></div>
                        <div class="absolute top-4 left-[12%] h-1 bg-blue-600 dark:bg-blue-500 transition-all duration-500 -z-0"
                             style="width: {{ $currentStep == 1 ? '0%' : ($currentStep == 2 ? '38%' : ($currentStep == 3 ? '70%' : '100%')) }};"></div>

                        {{-- Step 1 --}}
                        <div class="text-center relative z-10">
                            <div class="w-9 h-9 mx-auto rounded-full flex items-center justify-center font-bold text-xs shadow-md transition-all {{ $currentStep >= 1 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-950' : 'bg-slate-200 dark:bg-slate-700 text-slate-500' }}">
                                @if($currentStep > 1) ✓ @else 1 @endif
                            </div>
                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200 mt-2">Pengajuan</div>
                            <div class="text-[10px] text-slate-400">Berkas dikirim</div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="text-center relative z-10">
                            <div class="w-9 h-9 mx-auto rounded-full flex items-center justify-center font-bold text-xs shadow-md transition-all {{ $currentStep >= 2 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-950' : 'bg-slate-200 dark:bg-slate-700 text-slate-500' }}">
                                @if($currentStep > 2) ✓ @else 2 @endif
                            </div>
                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200 mt-2">Verifikasi</div>
                            <div class="text-[10px] text-slate-400">Pemeriksaan staf</div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="text-center relative z-10">
                            <div class="w-9 h-9 mx-auto rounded-full flex items-center justify-center font-bold text-xs shadow-md transition-all {{ $currentStep >= 3 ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-950' : 'bg-slate-200 dark:bg-slate-700 text-slate-500' }}">
                                @if($currentStep > 3) ✓ @else 3 @endif
                            </div>
                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200 mt-2">Pengesahan</div>
                            <div class="text-[10px] text-slate-400">TTE Lurah</div>
                        </div>

                        {{-- Step 4 --}}
                        <div class="text-center relative z-10">
                            <div class="w-9 h-9 mx-auto rounded-full flex items-center justify-center font-bold text-xs shadow-md transition-all {{ $currentStep >= 4 ? 'bg-emerald-600 text-white ring-4 ring-emerald-100 dark:ring-emerald-950' : 'bg-slate-200 dark:bg-slate-700 text-slate-500' }}">
                                @if($currentStep >= 4) ✓ @else 4 @endif
                            </div>
                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200 mt-2">Selesai</div>
                            <div class="text-[10px] text-slate-400">Dokumen terbit</div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Rejection Note if Rejected --}}
                @if($letterRequest->status === 'rejected' && $letterRequest->rejection_reason)
                <div class="mt-6 p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">⚠️</span>
                        <div>
                            <div class="text-xs font-bold text-red-800 dark:text-red-200 uppercase tracking-wider">Alasan Penolakan Petugas:</div>
                            <p class="text-xs text-red-700 dark:text-red-300 mt-1 leading-relaxed">{{ $letterRequest->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Completed Document Download Card --}}
            @if($letterRequest->status === 'completed')
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 lg:p-8 text-white shadow-xl shadow-emerald-500/20">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-3xl shrink-0 ring-4 ring-white/10">
                            📜
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold uppercase tracking-wider">
                                Dokumen Resmi Siap Unduh
                            </span>
                            <h3 class="text-xl font-black mt-1">Surat Keterangan Telah Selesai Diterbitkan</h3>
                            <p class="text-xs text-emerald-100 mt-0.5 font-mono">
                                @if($letterRequest->letter_number)
                                No. Surat: {{ $letterRequest->letter_number }} &bull;
                                @endif
                                Diterbitkan pada: {{ $letterRequest->completed_at ? $letterRequest->completed_at->format('d/m/Y H:i') : now()->format('d/m/Y') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        @if($letterRequest->pdf_path)
                        <a href="{{ route('warga.surat.download', $letterRequest->id) }}" class="w-full md:w-auto px-6 py-3 rounded-2xl bg-white text-emerald-800 hover:bg-emerald-50 font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Surat PDF
                        </a>
                        @endif
                        @if($letterRequest->qr_code_token)
                        <a href="{{ route('layanan.verifikasi', $letterRequest->qr_code_token) }}" target="_blank" class="px-4 py-3 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs backdrop-blur-sm transition-all flex items-center justify-center gap-1.5">
                            <span>🔍</span> Cek Keabsahan QR
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Request Details & Uploaded Files --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Detail Pemohon & Keperluan --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-700/80 space-y-4">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        Rincian Permohonan
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400">Nama Pemohon:</span>
                            <div class="font-bold text-slate-800 dark:text-slate-100 mt-0.5">{{ $letterRequest->applicant_name ?? $warga->name }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">NIK:</span>
                            <div class="font-mono font-bold text-slate-800 dark:text-slate-100 mt-0.5">{{ $letterRequest->nik ?? $warga->nik }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">Keperluan Pembuatan Surat:</span>
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 font-medium text-slate-700 dark:text-slate-300 mt-1 leading-relaxed">
                                {{ $letterRequest->form_data['purpose'] ?? ($letterRequest->purpose ?? '-') }}
                            </div>
                        </div>
                        @if(!empty($letterRequest->notes))
                        <div>
                            <span class="text-slate-400">Catatan Pemohon:</span>
                            <div class="text-slate-600 dark:text-slate-300 mt-0.5 italic">{{ $letterRequest->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Uploaded Attachments Review --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-700/80 space-y-4">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        Berkas Lampiran Persyaratan
                    </h3>

                    @if(is_array($letterRequest->attachments) && count($letterRequest->attachments) > 0)
                    <div class="space-y-2.5">
                        @foreach($letterRequest->attachments as $i => $file)
                        @php
                            $filePath = is_array($file) ? ($file['path'] ?? '') : $file;
                            $fileName = is_array($file) ? ($file['name'] ?? 'Lampiran ' . ($i + 1)) : 'Lampiran Berkas ' . ($i + 1);
                        @endphp
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5 overflow-hidden">
                                <span class="text-base">📎</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300 truncate">{{ $fileName }}</span>
                            </div>
                            @if($filePath)
                            <a href="{{ Storage::url($filePath) }}" target="_blank" class="px-3 py-1 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 hover:bg-blue-100 font-bold shrink-0 transition-colors">
                                Pratinjau
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="py-6 text-center text-xs text-slate-400">
                        Tidak ada berkas lampiran yang diunggah.
                    </div>
                    @endif
                </div>

            </div>

            {{-- Activity & Audit Logs Timeline --}}
            @if($letterRequest->logs->isNotEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider mb-6 flex items-center gap-2">
                    <span>📜</span> Riwayat Catatan & Log Aktivitas Surat
                </h3>

                <div class="space-y-6 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-700">
                    @foreach($letterRequest->logs as $log)
                    <div class="relative flex items-start gap-4">
                        <div class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-950/80 border-2 border-blue-500 text-blue-600 dark:text-blue-300 flex items-center justify-center text-xs shrink-0 shadow-sm">
                            •
                        </div>
                        <div class="flex-1 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                                <span class="font-bold text-xs text-slate-800 dark:text-slate-100">{{ $log->action }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                            </div>
                            @if($log->notes)
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">{{ $log->notes }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
