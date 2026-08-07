<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan — {{ $letter->request_number }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-title-kab { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-kec { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-des { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-alamat { font-size: 9pt; font-style: italic; margin-top: 5px; }

        .surat-header { text-align: center; margin-bottom: 25px; }
        .surat-title { font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin: 0; }
        .surat-nomor { font-size: 11pt; margin-top: 3px; }

        .content-table { width: 100%; margin: 15px 0; border-collapse: collapse; }
        .content-table td { padding: 4px 0; vertical-align: top; }
        .content-table td.label { width: 30%; }
        .content-table td.colon { width: 3%; }

        .footer-table { width: 100%; margin-top: 40px; }
        .footer-table td { text-align: center; vertical-align: top; width: 50%; }

        .stempel-box { position: relative; height: 90px; }
        .stempel-badge { display: inline-block; border: 2px solid #1B4F8A; color: #1B4F8A; padding: 5px 12px; font-weight: bold; font-size: 9pt; border-radius: 6px; text-transform: uppercase; }

        .qr-box { font-size: 8pt; color: #666; margin-top: 5px; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="kop-title-kab">Pemerintah Kabupaten Sleman</div>
        <div class="kop-title-kec">Kapanewon Depok</div>
        <div class="kop-title-des">Kalurahan Condongcatur</div>
        <div class="kop-alamat">Jl. Manggis No. 1, Condongcatur, Depok, Sleman 55283 | Telp: (0274) 881094 | Email: condongcatur1946@gmail.com</div>
    </div>

    {{-- JUDUL SURAT --}}
    <div class="surat-header">
        <div class="surat-title">{{ strtoupper($letter->letterType?->name ?? 'Surat Keterangan') }}</div>
        <div class="surat-nomor">Nomor: {{ $letter->request_number }}</div>
    </div>

    {{-- ISI SURAT --}}
    <p>Yang bertanda tangan di bawah ini Lurah Condongcatur, Kapanewon Depok, Kabupaten Sleman, menerangkan bahwa:</p>

    <table class="content-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td><strong>{{ $letter->applicant_name }}</strong></td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $letter->nik }}</td>
        </tr>
        <tr>
            <td class="label">Keperluan</td>
            <td class="colon">:</td>
            <td>{{ $letter->purpose }}</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Orang tersebut di atas adalah benar-benar warga yang berdomisili/terdaftar di wilayah Kalurahan Condongcatur. Surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>

    {{-- TANDA TANGAN & TTE QR CODE --}}
    <table class="footer-table">
        <tr>
            <td></td>
            <td>
                <div>Condongcatur, {{ $date }}</div>
                <div style="font-weight: bold; margin-bottom: 10px;">Lurah Condongcatur</div>
                <div class="stempel-box">
                    <div class="stempel-badge">Tanda Tangan Digital</div>
                    <div class="qr-box">Verifikasi Keabsahan: {{ $verificationUrl }}</div>
                </div>
                <div style="font-weight: bold; text-decoration: underline;">Drs. H. Ahmad Mukhlis, M.Si</div>
            </td>
        </tr>
    </table>

</body>
</html>
