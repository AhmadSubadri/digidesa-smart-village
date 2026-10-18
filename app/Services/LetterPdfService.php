<?php

namespace App\Services;

use App\Models\LetterRequest;
use Illuminate\Support\Str;

class LetterPdfService
{
    protected LetterDocumentService $documentService;

    public function __construct(LetterDocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Terbitkan dokumen surat resmi (PDF & DOCX jika tersedia) dan catat ke Buku Agenda Surat.
     */
    public function generatePdf(LetterRequest $letterRequest): string
    {
        if (empty($letterRequest->qr_code_token)) {
            $letterRequest->update([
                'qr_code_token' => Str::random(32),
            ]);
        }

        $paths = $this->documentService->generate($letterRequest);

        $letterRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
            'signed_by' => auth()->id() ?? $letterRequest->signed_by,
            'signed_at' => now(),
        ]);

        // Auto trigger WhatsApp notification to citizen if enabled
        try {
            app(WhatsappService::class)->sendLetterApproved($letterRequest);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("WhatsApp dispatch failed: " . $e->getMessage());
        }

        return $paths['pdf_path'] ?? '';
    }
}
