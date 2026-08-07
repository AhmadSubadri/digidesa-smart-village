<?php

namespace App\Services;

use App\Models\LetterRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LetterPdfService
{
    public function generatePdf(LetterRequest $letterRequest): string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);

        $token = Str::random(32);
        $verificationUrl = route('layanan.verifikasi', $token);

        $html = view('pdf.letter', [
            'letter' => $letterRequest,
            'token' => $token,
            'verificationUrl' => $verificationUrl,
            'date' => now()->translatedFormat('d F Y'),
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'surat_' . Str::slug($letterRequest->request_number) . '.pdf';
        $path = 'letters/' . $filename;

        Storage::disk('public')->put($path, $dompdf->output());

        $letterRequest->update([
            'pdf_path' => $path,
            'qr_code_token' => $token,
            'status' => 'completed',
        ]);

        return $path;
    }
}
