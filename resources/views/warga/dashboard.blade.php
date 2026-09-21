@extends('layouts.app')

@section('title', 'Portal Warga Mandiri — Dashboard')
@section('description', 'Dashboard layanan administrasi mandiri warga digital Desa / Kalurahan.')

@section('content')
{{-- Breadcrumb & Welcome Banner --}}
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                {{-- Avatar Initial --}}
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-blue-500/30 ring-4 ring-white/10 shrink-0">
                    {{ strtoupper(substr($warga->name ?? 'W', 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                            Akun Warga Terverifikasi
                        </span>
                        @if($warga->resident?->padukuhan)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-blue-500/20 text-blue-200 border border-blue-500/30">
                            Padukuhan {{ $warga->resident->padukuhan->name }}
                        </span>
                        @endif
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-black text-white mt-1.5 tracking-tight">
                        Selamat Datang, {{ $warga->name }}
                    </h1>
                    <p class="text-xs text-blue-200/80 font-mono mt-0.5">
                        NIK: {{ substr($warga->nik, 0, 6) }}******{{ substr($warga->nik, -4) }}
                        @if($warga->resident?->kk_number)
                        &bull; No. KK: {{ substr($warga->resident->kk_number, 0, 6) }}******{{ substr($warga->resident->kk_number, -4) }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2.5 flex-wrap">
                <a href="{{ route('warga.profil') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-sm border border-white/15 transition-all shadow-sm">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
                <a href="{{ route('warga.surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-xs font-bold shadow-lg shadow-blue-500/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Permohonan
                </a>
                <form action="{{ route('warga.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-300 hover:text-red-200 text-xs font-semibold border border-red-500/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]">
    <div class="container-sid">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        </div>
        @endif

        {{-- 4 Modern Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-8">
            {{-- Total Requests --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Diajukan</div>
                        <div class="text-3xl font-black text-slate-900 dark:text-white mt-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $stats['total'] }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shadow-inner">
                        📄
                    </div>
                </div>
                <div class="mt-3 text-[11px] text-slate-400 dark:text-slate-500 font-medium">Semua riwayat permohonan</div>
            </div>

            {{-- In Progress / Pending --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-3xl border border-amber-200/60 dark:border-amber-900/40 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Dalam Proses</div>
                        <div class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-1">
                            {{ $stats['pending'] }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shadow-inner">
                        ⏳
                    </div>
                </div>
                <div class="mt-3 text-[11px] text-amber-600/80 dark:text-amber-400/80 font-medium flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Sedang diverifikasi petugas
                </div>
            </div>

            {{-- Approved / Signed --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-3xl border border-indigo-200/60 dark:border-indigo-900/40 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Disetujui / TTE</div>
                        <div class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1">
                            {{ $stats['approved'] }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shadow-inner">
                        ✍️
                    </div>
                </div>
                <div class="mt-3 text-[11px] text-indigo-600/80 dark:text-indigo-400/80 font-medium">Proses tanda tangan lurah</div>
            </div>

            {{-- Completed --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-3xl border border-emerald-200/60 dark:border-emerald-900/40 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Selesai / Terbit</div>
                        <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">
                            {{ $stats['completed'] }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shadow-inner">
                        ✅
                    </div>
                </div>
                <div class="mt-3 text-[11px] text-emerald-600/80 dark:text-emerald-400/80 font-medium">Siap diunduh / diambil</div>
            </div>
        </div>

        {{-- Quick Letter Request Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80 mb-8">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>📜</span> Layanan Permohonan Surat Online
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Pilih jenis surat keterangan yang Anda butuhkan untuk langsung mengajukan permohonan.
                    </p>
                </div>
                <a href="{{ route('warga.surat.create') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 inline-flex items-center gap-1">
                    Lihat Semua Surat & Persyaratan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5">
                @forelse($letterTypes as $type)
                <a href="{{ route('warga.surat.form', $type->code) }}" class="group p-4 bg-slate-50 dark:bg-slate-900/60 hover:bg-blue-50/70 dark:hover:bg-blue-950/40 border border-slate-200/70 dark:border-slate-700/70 hover:border-blue-300 dark:hover:border-blue-700 rounded-2xl text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div class="w-11 h-11 mx-auto rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-xl mb-2.5 shadow-sm group-hover:scale-110 group-hover:border-blue-200 transition-all">
                            📜
                        </div>
                        <div class="font-bold text-xs text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 leading-snug">
                            {{ $type->name }}
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-200/60 dark:border-slate-700/60 flex items-center justify-center gap-1 text-[10px] text-slate-400 dark:text-slate-500 font-mono">
                        <span>{{ $type->code }}</span>
                        @if($type->estimated_days)
                        <span>&bull; {{ $type->estimated_days }} Hari</span>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">
                    Belum ada jenis surat yang diaktifkan.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Request History Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>⏱️</span> Riwayat Permohonan Terkini
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Daftar dan status terkini permohonan surat administrasi Anda.
                    </p>
                </div>
                @if($letterRequests->count() > 5)
                <a href="{{ route('warga.surat.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 inline-flex items-center gap-1">
                    Buka Arsip Lengkap
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                @endif
            </div>

            @if($letterRequests->isNotEmpty())
            <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-700/80">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 font-bold border-b border-slate-100 dark:border-slate-700/80 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="p-4">No. Tiket Permohonan</th>
                            <th class="p-4">Jenis Surat</th>
                            <th class="p-4">Waktu Pengajuan</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-slate-600 dark:text-slate-300">
                        @foreach($letterRequests->take(8) as $req)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900 dark:text-white">
                                <a href="{{ route('warga.surat.show', $req->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $req->request_number }}
                                </a>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-slate-800 dark:text-slate-100">{{ $req->letterType?->name ?? 'Surat Keterangan' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $req->letterType?->code }}</div>
                            </td>
                            <td class="p-4 text-slate-500 dark:text-slate-400">
                                <div>{{ $req->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $req->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $statusMap = [
                                        'submitted' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800', 'label' => 'Diajukan', 'dot' => 'bg-amber-500 animate-pulse'],
                                        'pending' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800', 'label' => 'Menunggu', 'dot' => 'bg-amber-500 animate-pulse'],
                                        'verifying' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800', 'label' => 'Verifikasi Berkas', 'dot' => 'bg-blue-500 animate-pulse'],
                                        'processing' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800', 'label' => 'Sedang Diproses', 'dot' => 'bg-blue-500'],
                                        'waiting_signature' => ['badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800', 'label' => 'Tanda Tangan Lurah', 'dot' => 'bg-indigo-500'],
                                        'completed' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800', 'label' => 'Selesai / Terbit', 'dot' => 'bg-emerald-500'],
                                        'rejected' => ['badge' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800', 'label' => 'Ditolak', 'dot' => 'bg-red-500'],
                                        'revision' => ['badge' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-950/40 dark:text-orange-300 dark:border-orange-800', 'label' => 'Perlu Revisi', 'dot' => 'bg-orange-500'],
                                        'cancelled' => ['badge' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700', 'label' => 'Dibatalkan', 'dot' => 'bg-slate-400'],
                                    ];
                                    $st = $statusMap[$req->status] ?? ['badge' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($req->status), 'dot' => 'bg-slate-400'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold border {{ $st['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}"></span>
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('warga.surat.show', $req->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-700/70 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold transition-all">
                                        Detail
                                    </a>
                                    @if($req->status === 'completed' && $req->pdf_path)
                                    <a href="{{ route('warga.surat.download', $req->id) }}" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Unduh PDF
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-12 text-center rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                <div class="w-16 h-16 mx-auto rounded-full bg-blue-50 dark:bg-blue-950/40 text-blue-500 dark:text-blue-400 flex items-center justify-center text-2xl mb-3">
                    📭
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Riwayat Permohonan</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 mb-5">
                    Anda belum pernah membuat permohonan surat online. Silakan klik tombol di bawah untuk membuat permohonan pertama Anda.
                </p>
                <a href="{{ route('warga.surat.create') }}" class="btn btn-primary text-xs px-5 py-2.5">
                    Ajukan Surat Sekarang
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
