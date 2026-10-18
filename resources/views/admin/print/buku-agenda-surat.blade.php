<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} — TA {{ $year }}</title>
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
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; font-size: 8.5pt; text-transform: uppercase; }
        table.data-table td { font-size: 8.5pt; }
        table.data-table td.center { text-align: center; }

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
        <a href="{{ url('/admin/letter-registers') }}" class="btn btn-back">⬅️ Kembali ke Admin</a>
    </div>

    {{-- KOP PEMERINTAH DESA --}}
    <div class="kop">
        <h3>PEMERINTAH KABUPATEN {{ strtoupper(setting('regency_name', 'KABUPATEN')) }}</h3>
        <h3>KECAMATAN {{ strtoupper(setting('district_name', 'KECAMATAN')) }}</h3>
        <h2>PEMERINTAH {{ strtoupper(setting('village_name', 'DESA')) }}</h2>
        <p>{{ setting('contact_address', 'Kantor Pemerintah Desa') }} | Telp: {{ setting('contact_phone', '-') }} | Email: {{ setting('contact_email', '-') }}</p>
    </div>

    {{-- JUDUL BUKU REGISTER PERMENDAGRI --}}
    <div class="header-title">
        <h4>{{ $title }}</h4>
        <p>Buku Administrasi Umum — Standar Lampiran Permendagri No. 47 Tahun 2016 | Tahun Anggaran {{ $year }}</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No. Urut</th>
                <th style="width: 10%;">Tgl Penerimaan / Pengiriman</th>
                <th style="width: 18%;">Nomor Surat</th>
                <th style="width: 10%;">Tanggal Surat</th>
                <th style="width: 20%;">{{ $type === 'incoming' ? 'Pengirim (Dari Mana)' : 'Ditujukan Kepada' }}</th>
                <th style="width: 26%;">Perihal / Isi Ringkas Surat</th>
                <th style="width: 12%;">Keterangan</th>
            </tr>
            <tr style="background: #fafafa; font-size: 7.5pt;">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $r)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') : '-' }}</td>
                    <td><strong>{{ $r->letter_number }}</strong></td>
                    <td class="center">{{ $r->letter_date ? \Carbon\Carbon::parse($r->letter_date)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $r->sender_or_recipient ?? '-' }}</td>
                    <td>{{ $r->subject ?? '-' }}</td>
                    <td>{{ $r->summary ?? ($r->register_type === 'outgoing' ? 'Teregistrasi Sistem' : '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center" style="padding: 25px;">Belum ada arsip register surat pada tahun anggaran {{ $year }}.</td>
                </tr>
            @endforelse
        </tbody>
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
                <strong>Sekretaris Desa / Petugas Pencatat</strong>
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ setting('secretary_name', 'Sekretaris Desa') }}</span><br>
                <small>NIP. {{ setting('secretary_nip', '-') }}</small>
            </td>
        </tr>
    </table>

</body>
</html>
