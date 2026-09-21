@extends('layouts.app')

@section('title', 'Riwayat & Arsip Permohonan Surat')
@section('description', 'Daftar riwayat dan status permohonan surat administrasi warga mandiri.')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 py-10 lg:py-12 border-b border-blue-800/40">
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="container-sid relative z-10">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-white tracking-tight">Riwayat Permohonan Surat</h1>
                <div class="flex items-center gap-2 text-xs text-blue-200/80 mt-1.5 font-medium">
                    <a href="{{ route('warga.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Riwayat Surat</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('warga.surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-xs font-bold shadow-lg shadow-blue-500/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajukan Surat Baru
                </a>
            </div>
        </div>
    </div>
</div>

<div class="section-py bg-slate-50 dark:bg-slate-900/50 min-h-[600px]">
    <div class="container-sid">

        {{-- Filter & Search Form --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-700/80 mb-8">
            <form action="{{ route('warga.surat.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Status Pills --}}
                <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                    @php $currStatus = request('status'); @endphp
                    <a href="{{ route('warga.surat.index', array_filter(request()->except(['status', 'page']))) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ empty($currStatus) ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('warga.surat.index', array_merge(request()->except('page'), ['status' => 'submitted'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $currStatus === 'submitted' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                        Diajukan
                    </a>
                    <a href="{{ route('warga.surat.index', array_merge(request()->except('page'), ['status' => 'processing'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $currStatus === 'processing' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                        Diproses
                    </a>
                    <a href="{{ route('warga.surat.index', array_merge(request()->except('page'), ['status' => 'completed'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $currStatus === 'completed' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                        Selesai / Terbit
                    </a>
                    <a href="{{ route('warga.surat.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $currStatus === 'rejected' ? 'bg-red-600 text-white shadow-md shadow-red-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                        Ditolak
                    </a>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-72">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari no. tiket / surat..."
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-900 text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
        </div>

        {{-- Requests Table --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/80 dark:border-slate-700/80">
            @if($requests->isNotEmpty())
            <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-700/80">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 font-bold border-b border-slate-100 dark:border-slate-700/80 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="p-4">No. Tiket</th>
                            <th class="p-4">Jenis Surat</th>
                            <th class="p-4">Waktu Pengajuan</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-slate-600 dark:text-slate-300">
                        @foreach($requests as $req)
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
                                        Unduh
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
            @else
            <div class="py-12 text-center rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl mb-3">
                    🔍
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Tidak Ada Permohonan Ditemukan</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 mb-5">
                    Tidak ada riwayat surat dengan filter atau kata kunci yang Anda masukkan.
                </p>
                <a href="{{ route('warga.surat.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold">
                    Reset Filter
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
