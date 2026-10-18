<?php

namespace App\Services;

use App\Models\LetterRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class LetterDocumentService
{
    protected LetterNumberService $numberService;

    public function __construct(LetterNumberService $numberService)
    {
        $this->numberService = $numberService;
    }

    /**
     * Generate berkas surat (DOCX / PDF) sesuai konfigurasi tipe surat.
     */
    public function generate(LetterRequest $request): array
    {
        // Pastikan nomor surat resmi sudah terbentuk
        $letterNumber = $this->numberService->generateAndRegister($request);

        $type = $request->letterType;
        $paths = [
            'pdf_path' => null,
            'docx_path' => null,
        ];

        // 1. Jika tipe template adalah Word (.docx) dan filenya ada
        if ($type?->template_type === 'docx' && !empty($type->docx_template_path) && Storage::disk('public')->exists($type->docx_template_path)) {
            $docxPath = $this->generateFromDocx($request);
            $paths['docx_path'] = $docxPath;
        }

        // 2. Default render via DomPDF (Blade)
        $pdfPath = $this->generateFromBlade($request);
        $paths['pdf_path'] = $pdfPath;

        // Simpan path ke request
        $request->update(array_filter($paths));

        return $paths;
    }

    /**
     * Generate dokumen dari template Microsoft Word (.docx) menggunakan PHPWord.
     */
    public function generateFromDocx(LetterRequest $request): string
    {
        $templateRealPath = Storage::disk('public')->path($request->letterType->docx_template_path);
        $templateProcessor = new TemplateProcessor($templateRealPath);

        $resident = $request->resident;
        $formData = $request->form_data ?? [];

        // Pemetaan variabel template Word: ${variabel}
        $variables = [
            'nomor_surat'    => $request->letter_number,
            'nama'           => $resident?->full_name ?? ($formData['nama'] ?? '-'),
            'nik'            => $resident?->nik ?? ($formData['nik'] ?? '-'),
            'tempat_lahir'   => $resident?->birth_place ?? ($formData['tempat_lahir'] ?? '-'),
            'tanggal_lahir'  => $resident?->birth_date ? Carbon::parse($resident->birth_date)->translatedFormat('d F Y') : ($formData['tanggal_lahir'] ?? '-'),
            'jenis_kelamin'  => $resident?->gender === 'L' ? 'Laki-Laki' : 'Perempuan',
            'agama'          => $resident?->religion ?? ($formData['agama'] ?? '-'),
            'pekerjaan'      => $resident?->occupation ?? ($formData['pekerjaan'] ?? '-'),
            'alamat'         => $resident?->address ?? ($formData['alamat'] ?? '-'),
            'rt'             => $resident?->rt ?? ($formData['rt'] ?? '-'),
            'rw'             => $resident?->rw ?? ($formData['rw'] ?? '-'),
            'keperluan'      => $formData['keperluan'] ?? ($request->notes ?? 'Urusan Administrasi'),
            'tanggal_surat'  => Carbon::now()->translatedFormat('d F Y'),
            'nama_desa'      => setting('village_name', 'Pemerintah Desa'),
            'nama_kecamatan' => setting('district_name', 'Kecamatan'),
            'nama_kabupaten' => setting('regency_name', 'Kabupaten'),
            'nama_pejabat'   => setting('leader_name', 'Kepala Desa'),
            'jabatan_pejabat'=> setting('leader_title', 'Kepala Desa'),
        ];

        foreach ($variables as $key => $val) {
            $templateProcessor->setValue($key, (string) $val);
        }

        $fileName = 'surat_' . $request->id . '_' . time() . '.docx';
        $relativeDir = 'letters/' . Carbon::now()->format('Y/m');
        $fullDir = storage_path('app/public/' . $relativeDir);

        if (!file_exists($fullDir)) {
            mkdir($fullDir, 0755, true);
        }

        $fullPath = $fullDir . '/' . $fileName;
        $templateProcessor->saveAs($fullPath);

        return $relativeDir . '/' . $fileName;
    }

    /**
     * Generate dokumen dari template Blade via DomPDF.
     */
    public function generateFromBlade(LetterRequest $request): string
    {
        $verificationUrl = url('/verifikasi/surat/' . ($request->qr_code_token ?? $request->request_number));
        $date = Carbon::now()->translatedFormat('d F Y');

        // Gunakan view dinamis
        $view = $request->letterType?->template_path && view()->exists($request->letterType->template_path)
            ? $request->letterType->template_path
            : 'pdf.letter';

        $pdf = Pdf::loadView($view, [
            'letter' => $request,
            'verificationUrl' => $verificationUrl,
            'date' => $date,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $fileName = 'surat_' . $request->id . '_' . time() . '.pdf';
        $relativeDir = 'letters/' . Carbon::now()->format('Y/m');
        $fullPath = $relativeDir . '/' . $fileName;

        Storage::disk('public')->put($fullPath, $pdf->output());

        return $fullPath;
    }
}
