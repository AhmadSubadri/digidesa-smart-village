<?php

namespace App\Services;

use App\Models\LetterRegister;
use App\Models\LetterRequest;
use Carbon\Carbon;

class LetterNumberService
{
    /**
     * Generate nomor surat resmi standar Permendagri & log ke Buku Register Surat Keluar.
     * Format: [Kode Klasifikasi]/[Nomor Urut Register]/[Kode Desa]/[Bulan Romawi]/[Tahun]
     * Contoh: 470/023/DESA-01/X/2026
     */
    public function generateAndRegister(LetterRequest $request): string
    {
        if (!empty($request->letter_number)) {
            return $request->letter_number;
        }

        $now = Carbon::now();
        $year = $now->year;
        $romanMonth = $this->getRomanMonth($now->month);

        // Ambil kode klasifikasi dari tipe surat atau fallback kependudukan (470)
        $classificationCode = $request->letterType?->classification_code ?? '470';
        $villageCode = setting('village_code', 'DESA-01');

        // Ambil urutan register keluar untuk tahun berjalan
        $nextSequence = (LetterRequest::whereYear('created_at', $year)->max('sequence_number') ?? 0) + 1;
        $sequenceFormatted = str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

        // Format nomor surat resmi
        $letterNumber = sprintf(
            '%s/%s/%s/%s/%s',
            $classificationCode,
            $sequenceFormatted,
            $villageCode,
            $romanMonth,
            $year
        );

        // Simpan nomor dan urutan ke letter_requests
        $request->update([
            'letter_number' => $letterNumber,
            'sequence_number' => $nextSequence,
        ]);

        // Otomatis catat ke Buku Agenda Surat Keluar (Permendagri 47/2016)
        LetterRegister::firstOrCreate(
            [
                'letter_request_id' => $request->id,
            ],
            [
                'register_type' => 'outgoing',
                'letter_number' => $letterNumber,
                'letter_date' => $now->toDateString(),
                'sender_or_recipient' => $request->resident?->full_name ?? ($request->form_data['nama'] ?? 'Warga'),
                'subject' => $request->letterType?->name ?? 'Surat Keterangan',
                'summary' => 'Keperluan: ' . ($request->form_data['keperluan'] ?? $request->notes ?? '-'),
                'classification_code' => $classificationCode,
                'document_file_path' => $request->pdf_path,
                'archived_by' => auth()->id() ?? $request->signed_by,
            ]
        );

        return $letterNumber;
    }

    /**
     * Konversi angka bulan ke angka romawi.
     */
    public function getRomanMonth(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $map[$month] ?? 'I';
    }
}
