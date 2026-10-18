<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Inventaris Aset Desa — {{ setting('village_name', 'Desa') }}</title>
    <style>
        @page { size: A4 landscape; margin: 1.5cm 1.2cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; line-height: 1.3; color: #000; margin: 0; padding: 20px; background: #fff; }
        .kop { text-align: center; border-bottom: 2.5px solid #000; padding-bottom: 8px; margin-bottom: 15px; position: relative; }
        .kop h3 { font-size: 13pt; margin: 0; text-transform: uppercase; font-weight: bold; }
        .kop h2 { font-size: 14pt; margin: 2px 0; text-transform: uppercase; font-weight: bold; }
        .kop p { font-size: 8.5pt; margin: 3px 0 0; font-style: italic; }
        
        .header-title { text-align: center; margin-bottom: 20px; }
        .header-title h4 { font-size: 12pt; text-transform: uppercase; margin: 0; font-weight: bold; }
        .header-title p { font-size: 9pt; margin: 2px 0 0; color: #444; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 5px 6px; vertical-align: top; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; font-size: 8pt; text-transform: uppercase; }
        table.data-table td { font-size: 8pt; }
        table.data-table td.center { text-align: center; }
        table.data-table td.right { text-align: right; }

        .signature-table { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-table td { width: 50%; text-align: center; vertical-align: top; font-size: 9.5pt; }

        /* Floating action buttons */
        .no-print { position: fixed; top: 15px; right: 20px; z-index: 9999; display: flex; gap: 10px; }
        .btn { padding: 8px 16px; font-family: sans-serif; font-size: 12px; font-weight: bold; border-radius: 6px; cursor: pointer; text-decoration: none; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
        .btn-print { background: #0284c7; color: #fff; }
        .btn-back { background: #334155; color: #fff; }

        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
        <a href="{{ url('/admin/village-assets') }}" class="btn btn-back">⬅️ Kembali ke Admin</a>
    </div>

    {{-- KOP PEMERINTAH DESA --}}
    <div class="kop">
        <h3>PEMERINTAH KABUPATEN {{ strtoupper(setting('regency_name', 'KABUPATEN')) }}</h3>
        <h3>KECAMATAN {{ strtoupper(setting('district_name', 'KECAMATAN')) }}</h3>
        <h2>PEMERINTAH {{ strtoupper(setting('village_name', 'DESA')) }}</h2>
        <p>{{ setting('contact_address', 'Kantor Pemerintah Desa') }} | Telp: {{ setting('contact_phone', '-') }} | Email: {{ setting('contact_email', '-') }}</p>
    </div>

    {{-- JUDUL BUKU INVENTARIS PERMENDAGRI NO 1/2016 --}}
    <div class="header-title">
        <h4>BUKU INVENTARIS DAN KEKAYAAN DESA</h4>
        <p>Pengelolaan Aset Desa — Format Lampiran Permendagri No. 1 Tahun 2016 & No. 47 Tahun 2016</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No.</th>
                <th style="width: 11%;">Kode Barang / Aset</th>
                <th style="width: 20%;">Jenis / Nama Barang</th>
                <th style="width: 12%;">Kategori Aset</th>
                <th style="width: 8%;">Tahun Perolehan</th>
                <th style="width: 14%;">Asal Usul / Sumber Dana</th>
                <th style="width: 8%;">Jumlah</th>
                <th style="width: 12%;">Nilai Perolehan (Rp)</th>
                <th style="width: 8%;">Kondisi</th>
                <th style="width: 15%;">Lokasi / Pemegang</th>
            </tr>
            <tr style="background: #fafafa; font-size: 7.5pt;">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $r)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center font-mono"><strong>{{ $r->asset_code }}</strong></td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ ucwords(str_replace('_', ' ', $r->category)) }}</td>
                    <td class="center">{{ $r->acquisition_date ? \Carbon\Carbon::parse($r->acquisition_date)->format('Y') : '-' }}</td>
                    <td>{{ $r->source_fund ?? '-' }}</td>
                    <td class="center">{{ $r->quantity }} {{ $r->unit ?? 'Unit' }}</td>
                    <td class="right font-mono">Rp {{ number_format($r->acquisition_value, 0, ',', '.') }}</td>
                    <td class="center">{{ ucwords(str_replace('_', ' ', $r->current_condition)) }}</td>
                    <td>{{ $r->location ?? '-' }} {{ $r->responsible_person ? '(' . $r->responsible_person . ')' : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="center" style="padding: 25px;">Belum ada arsip aset desa yang tercatat dalam sistem.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; font-weight: bold;">
                <td colspan="7" class="right" style="padding: 8px;">TOTAL REKAPITULASI NILAI ASET DESA:</td>
                <td class="right font-mono" style="padding: 8px; font-size: 9pt;">Rp {{ number_format($totalValue, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    {{-- PENGESAHAN DOKUMEN --}}
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>{{ setting('leader_title', 'Kepala Desa') }} {{ setting('village_name', 'Desa') }}</strong>
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ setting('leader_name', 'Pemerintah Desa') }}</span><br>
                <small>NIP. {{ setting('leader_nip', '-') }}</small>
            </td>
            <td>
                {{ setting('village_name', 'Desa') }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <strong>Pengurus Barang Desa / Kaur Tata Usaha & Umum</strong>
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ setting('secretary_name', 'Petugas Pengurus Barang') }}</span><br>
                <small>NIP. {{ setting('secretary_nip', '-') }}</small>
            </td>
        </tr>
    </table>

</body>
</html>
