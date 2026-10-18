<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan — {{ $letter->letter_number ?? $letter->request_number }}</title>
    <style>
        @page { margin: 2cm 2.5cm; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11pt; line-height: 1.5; color: #111; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px; }
        .kop-title-kab { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-kec { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-des { font-size: 15pt; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
        .kop-alamat { font-size: 8.5pt; font-style: italic; margin-top: 4px; color: #333; }

        .surat-header { text-align: center; margin-bottom: 25px; }
        .surat-title { font-size: 13pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin: 0; }
        .surat-nomor { font-size: 10.5pt; margin-top: 4px; }

        .content-table { width: 100%; margin: 15px 0 20px 0; border-collapse: collapse; }
        .content-table td { padding: 4px 0; vertical-align: top; }
        .content-table td.label { width: 32%; }
        .content-table td.colon { width: 3%; }
        .content-table td.value { width: 65%; }

        .footer-table { width: 100%; margin-top: 30px; }
        .footer-table td { vertical-align: top; }

        .tte-box { text-align: center; width: 240px; margin-left: auto; }
        .stempel-badge { display: inline-block; border: 1.5px solid #0284c7; color: #0369a1; padding: 3px 8px; font-weight: bold; font-size: 7.5pt; border-radius: 4px; text-transform: uppercase; margin-bottom: 6px; }
        .qr-img { display: block; margin: 0 auto; }
        .verify-text { font-size: 7.5pt; color: #64748b; margin-top: 5px; }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI PEMERINTAH DESA --}}
    <div class="kop">
        <div class="kop-title-kab">{{ setting('regency_name', 'Pemerintah Daerah') }}</div>
        <div class="kop-title-kec">Kecamatan {{ setting('district_name', 'Kecamatan') }}</div>
        <div class="kop-title-des">Pemerintah {{ setting('village_name', setting('site_name', 'Desa')) }}</div>
        <div class="kop-alamat">{{ setting('contact_address', 'Kantor Pemerintah Desa') }} | Telp: {{ setting('contact_phone', '-') }} | Email: {{ setting('contact_email', '-') }}</div>
    </div>

    {{-- JUDUL DAN NOMOR SURAT RESMI PERMENDAGRI --}}
    <div class="surat-header">
        <div class="surat-title">{{ strtoupper($letter->letterType?->name ?? 'Surat Keterangan') }}</div>
        <div class="surat-nomor">Nomor: {{ $letter->letter_number ?? $letter->request_number }}</div>
    </div>

    {{-- PEMBUKA DAN ISI SURAT --}}
    <p style="text-align: justify; text-indent: 30px; margin-bottom: 12px;">
        Yang bertanda tangan di bawah ini {{ setting('leader_title', 'Kepala Desa') }} {{ setting('village_name', setting('site_name', 'Desa')) }}, Kecamatan {{ setting('district_name', 'Kecamatan') }}, Kabupaten {{ setting('regency_name', 'Kabupaten') }}, menerangkan dengan sebenarnya bahwa:
    </p>

    <table class="content-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $letter->applicant_name }}</strong></td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td class="value">{{ $letter->nik }}</td>
        </tr>
        <tr>
            <td class="label">Keperluan / Keterangan</td>
            <td class="colon">:</td>
            <td class="value">{{ $letter->purpose }}</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px; line-height: 1.6;">
        Orang tersebut di atas adalah benar-benar warga yang bertempat tinggal / terdaftar di wilayah administrasi {{ setting('village_name', setting('site_name', 'Desa')) }}. Demikian surat keterangan ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    {{-- TANDA TANGAN ELEKTRONIK & TTE RESMI BER-QR CODE --}}
    <table class="footer-table">
        <tr>
            <td style="width: 45%;"></td>
            <td style="width: 55%;">
                <div class="tte-box">
                    <div>{{ setting('village_name', 'Desa') }}, {{ $date }}</div>
                    <div style="font-weight: bold; margin-bottom: 8px;">{{ setting('leader_title', 'Kepala Desa') }} {{ setting('village_name', setting('site_name', 'Desa')) }}</div>
                    
                    <div class="stempel-badge">Tanda Tangan Elektronik</div>
                    
                    @php
                        $qrSvgBase64 = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(85)->errorCorrection('H')->generate($verificationUrl));
                    @endphp
                    <img class="qr-img" src="data:image/svg+xml;base64,{{ $qrSvgBase64 }}" width="85" height="85" alt="QR Code Verifikasi">

                    <div class="verify-text">Scan QR Code untuk verifikasi keabsahan dokumen</div>
                    <div style="font-weight: bold; text-decoration: underline; margin-top: 10px;">{{ setting('leader_name', 'Kepala Desa') }}</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
