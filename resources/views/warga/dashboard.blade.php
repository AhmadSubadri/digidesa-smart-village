@extends('layouts.app')

@section('title', 'Dashboard Portal Warga')
@section('description', 'Dashboard layanan mandiri warga Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white">Selamat Datang, {{ $warga->full_name }}</h1>
                <p class="text-blue-100 text-xs mt-1">NIK: {{ substr($warga->nik, 0, 6) }}********** | Status: <span class="badge badge-success uppercase text-[10px]">{{ $warga->status ?? 'Aktif' }}</span></p>
            </div>
            <form action="{{ route('warga.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary text-xs py-1.5 px-3">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="text-xs text-gray-500 font-semibold mb-1">Total Permohonan</div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="text-xs text-amber-600 font-semibold mb-1">Dalam Proses</div>
                <div class="text-2xl font-black text-amber-600">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="text-xs text-blue-600 font-semibold mb-1">Disetujui</div>
                <div class="text-2xl font-black text-blue-600">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="text-xs text-green-600 font-semibold mb-1">Selesai / Terbit</div>
                <div class="text-2xl font-black text-green-600">{{ $stats['completed'] }}</div>
            </div>
        </div>

        {{-- Quick Letter Request Buttons --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Ajukan Permohonan Surat Keterangan</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($letterTypes as $type)
                <a href="{{ route('warga.surat.form', $type->code) }}" class="p-3 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 rounded-xl text-center transition-all group">
                    <div class="text-xl mb-1">📜</div>
                    <div class="font-bold text-xs text-gray-800 group-hover:text-blue-600 truncate">{{ $type->name }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $type->code }}</div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Request History Table --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Riwayat Permohonan Surat</h2>
            @if($letterRequests->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-slate-50 text-gray-900 font-bold border-b border-gray-100">
                        <tr>
                            <th class="p-3">No. Tiket</th>
                            <th class="p-3">Jenis Surat</th>
                            <th class="p-3">Tanggal Permohonan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($letterRequests as $req)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-bold text-gray-800">{{ $req->request_number }}</td>
                            <td class="p-3 font-medium">{{ $req->letterType?->name }}</td>
                            <td class="p-3 text-xs text-gray-500">{{ $req->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3">
                                <span class="badge {{ $req->status === 'completed' ? 'badge-success' : ($req->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                @if($req->status === 'completed' && $req->pdf_path)
                                <a href="{{ Storage::url($req->pdf_path) }}" target="_blank" class="btn btn-primary text-xs py-1 px-3">
                                    Unduh Surat
                                </a>
                                @else
                                <span class="text-xs text-gray-400">Dalam Proses</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center text-gray-500 text-sm">
                Anda belum pernah mengajukan permohonan surat. Pilih jenis surat di atas untuk memulai.
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
