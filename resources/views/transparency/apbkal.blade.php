@extends('layouts.app')

@section('title', 'Transparansi APBKal')
@section('description', 'Keterbukaan Informasi Anggaran Pendapatan dan Belanja Kalurahan (APBKal) Condongcatur.')

@section('content')
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Transparansi APBKal {{ $budget?->fiscal_year ?? date('Y') }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span>Transparansi</span>
            <span class="sep">/</span>
            <span class="current">APBKal</span>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">

        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-br from-green-600 to-green-800 text-white rounded-3xl p-6 shadow-md">
                <div class="text-xs uppercase font-semibold tracking-wider text-green-200 mb-1">Pendapatan Kalurahan</div>
                <div class="text-3xl font-black mb-2">Rp {{ number_format($budget?->total_income ?? 3850000000, 0, ',', '.') }}</div>
                <div class="text-xs text-green-100">Rencana Anggaran {{ $budget?->fiscal_year ?? date('Y') }}</div>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-3xl p-6 shadow-md">
                <div class="text-xs uppercase font-semibold tracking-wider text-blue-200 mb-1">Belanja Kalurahan</div>
                <div class="text-3xl font-black mb-2">Rp {{ number_format($budget?->total_expense ?? 3780000000, 0, ',', '.') }}</div>
                <div class="text-xs text-blue-100">Alokasi Belanja & Pembangunan</div>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-700 text-white rounded-3xl p-6 shadow-md">
                <div class="text-xs uppercase font-semibold tracking-wider text-amber-200 mb-1">Pembiayaan / SILPA</div>
                <div class="text-3xl font-black mb-2">Rp {{ number_format($budget?->total_financing ?? 70000000, 0, ',', '.') }}</div>
                <div class="text-xs text-amber-100">Netto Pembiayaan Kalurahan</div>
            </div>
        </div>

        {{-- Income Table --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6 text-green-700 flex items-center gap-2">
                <span>💰</span> Rincian Pendapatan Kalurahan
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-green-50 text-green-900 font-bold border-b border-green-100">
                        <tr>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Uraian Pendapatan</th>
                            <th class="p-3 text-right">Anggaran (Rp)</th>
                            <th class="p-3 text-right">Realisasi (Rp)</th>
                            <th class="p-3 text-right">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($incomes as $inc)
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-700">{{ $inc->code }}</td>
                            <td class="p-3 font-medium text-gray-900">{{ $inc->item_name }}</td>
                            <td class="p-3 text-right font-mono">{{ number_format($inc->planned_amount, 0, ',', '.') }}</td>
                            <td class="p-3 text-right font-mono text-green-600 font-bold">{{ number_format($inc->realized_amount, 0, ',', '.') }}</td>
                            <td class="p-3 text-right"><span class="badge badge-success">{{ $inc->percentage }}%</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Expense Table --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-6 text-blue-700 flex items-center gap-2">
                <span>🏗️</span> Rincian Belanja Kalurahan
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-blue-50 text-blue-900 font-bold border-b border-blue-100">
                        <tr>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Bidang / Uraian Belanja</th>
                            <th class="p-3 text-right">Anggaran (Rp)</th>
                            <th class="p-3 text-right">Realisasi (Rp)</th>
                            <th class="p-3 text-right">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($expenses as $exp)
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-700">{{ $exp->code }}</td>
                            <td class="p-3 font-medium text-gray-900">{{ $exp->item_name }}</td>
                            <td class="p-3 text-right font-mono">{{ number_format($exp->planned_amount, 0, ',', '.') }}</td>
                            <td class="p-3 text-right font-mono text-blue-600 font-bold">{{ number_format($exp->realized_amount, 0, ',', '.') }}</td>
                            <td class="p-3 text-right"><span class="badge badge-primary">{{ $exp->percentage }}%</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
