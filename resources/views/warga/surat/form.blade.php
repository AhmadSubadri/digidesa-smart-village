@extends('layouts.app')

@section('title', 'Form Permohonan ' . $letterType->name)
@section('description', 'Form permohonan online ' . $letterType->name . ' Kalurahan Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white">Form Permohonan Surat</h1>
        <div class="breadcrumb">
            <a href="{{ route('warga.dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Permohonan Surat</span>
            <span class="sep">/</span>
            <span class="current">{{ $letterType->code }}</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

            <div class="border-b border-gray-100 pb-6 mb-6">
                <span class="badge badge-primary font-mono mb-2">{{ $letterType->code }}</span>
                <h2 class="text-2xl font-bold text-gray-900">{{ $letterType->name }}</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $letterType->description }}</p>
            </div>

            <form action="{{ route('warga.surat.store', $letterType->code) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Applicant Info (Read-only) --}}
                <div class="bg-slate-50 p-4 rounded-xl space-y-2 text-xs">
                    <div class="font-bold text-gray-800 text-sm mb-2">Data Pemohon (Sesuai Akun)</div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">NIK:</span>
                        <span class="font-mono font-bold text-gray-800">{{ $warga->nik }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama Lengkap:</span>
                        <span class="font-bold text-gray-800">{{ $warga->full_name }}</span>
                    </div>
                </div>

                {{-- Purpose --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Keperluan / Alasan Permohonan Surat*</label>
                    <textarea
                        name="purpose"
                        rows="3"
                        placeholder="Jelaskan keperluan pembuatan surat ini secara rinci (misal: Persyaratan pengurusan beasiswa, perizinan usaha, dll)"
                        required
                        class="w-full p-4 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600 @error('purpose') border-red-500 @enderror"
                    >{{ old('purpose') }}</textarea>
                    @error('purpose')<span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>@enderror
                </div>

                {{-- Dynamic Requirements File Upload --}}
                @if(is_array($letterType->requirements) && count($letterType->requirements) > 0)
                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <h3 class="font-bold text-gray-900 text-sm">Unggah Dokumen Persyaratan</h3>
                    @foreach($letterType->requirements as $i => $req)
                    @php $label = is_array($req) ? ($req['label'] ?? 'Dokumen Pendukung') : $req; @endphp
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            {{ $i + 1 }}. {{ $label }}
                        </label>
                        <input
                            type="file"
                            name="attachments[]"
                            accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('warga.dashboard') }}" class="btn btn-outline text-sm">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary text-sm flex-1">
                        Kirim Permohonan Surat
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
