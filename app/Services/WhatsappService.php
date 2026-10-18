<?php

namespace App\Services;

use App\Models\LetterRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim notifikasi ketika permohonan surat baru berhasil diajukan oleh warga.
     */
    public function sendLetterSubmitted(LetterRequest $request): array
    {
        if (setting('whatsapp_notify_letter_submitted', '1') !== '1') {
            return ['status' => false, 'message' => 'Notifikasi pengajuan dinonaktifkan di pengaturan.'];
        }

        $phone = $request->phone;
        if (empty($phone)) {
            return ['status' => false, 'message' => 'Nomor WhatsApp pemohon tidak tersedia.'];
        }

        $desaName = setting('village_name', setting('site_name', 'Pemerintah Desa'));
        $letterName = $request->letterType?->name ?? 'Surat Keterangan';
        $applicantName = $request->applicant_name;
        $ticket = $request->request_number;
        $trackUrl = route('warga.surat.show', $request->id);

        $message = "*PEMBERITAHUAN PENGAJUAN SURAT*\n"
            . "Halo *{$applicantName}*,\n\n"
            . "Permohonan surat *{$letterName}* Anda telah berhasil diterima oleh sistem pelayanan *{$desaName}*.\n\n"
            . "📋 *Nomor Tiket:* `{$ticket}`\n"
            . "🕒 *Status Saat Ini:* Sedang Diverifikasi Petugas\n\n"
            . "Anda dapat memantau proses verifikasi melalui tautan berikut:\n"
            . "👉 {$trackUrl}\n\n"
            . "_Pesan otomatis oleh Sistem Informasi {$desaName}_";

        return $this->sendDirect($phone, $message);
    }

    /**
     * Kirim notifikasi ketika surat resmi telah disetujui, bernomor Permendagri, dan siap diunduh.
     */
    public function sendLetterApproved(LetterRequest $request): array
    {
        if (setting('whatsapp_notify_letter_approved', '1') !== '1') {
            return ['status' => false, 'message' => 'Notifikasi surat disetujui dinonaktifkan di pengaturan.'];
        }

        $phone = $request->phone;
        if (empty($phone)) {
            return ['status' => false, 'message' => 'Nomor WhatsApp pemohon tidak tersedia.'];
        }

        $desaName = setting('village_name', setting('site_name', 'Pemerintah Desa'));
        $letterName = $request->letterType?->name ?? 'Surat Keterangan';
        $applicantName = $request->applicant_name;
        $letterNumber = $request->letter_number ?? '-';
        $verificationUrl = $request->verification_url;
        $downloadUrl = route('warga.surat.download', $request->id);

        $message = "✅ *SURAT ANDA TELAH TERBIT & RESMI*\n\n"
            . "Kabar baik untuk Sdr/i *{$applicantName}*,\n"
            . "Permohonan surat *{$letterName}* Anda telah disetujui dan disahkan oleh *{$desaName}*.\n\n"
            . "📜 *Nomor Surat Resmi:* `{$letterNumber}`\n"
            . "🔐 *Verifikasi Keabsahan:* {$verificationUrl}\n\n"
            . "Dokumen PDF ber-TTE resmi dapat langsung diunduh melalui:\n"
            . "📥 {$downloadUrl}\n\n"
            . "Anda juga dapat mengambil berkas fisik di loket pelayanan kantor desa pada jam kerja.\n\n"
            . "_Terima kasih telah menggunakan Layanan Mandiri {$desaName}_";

        $res = $this->sendDirect($phone, $message);
        if ($res['status']) {
            $request->update(['wa_notification_sent' => true]);
        }

        return $res;
    }

    /**
     * Kirim notifikasi ketika permohonan surat ditolak dengan alasan yang jelas.
     */
    public function sendLetterRejected(LetterRequest $request, ?string $reason = null): array
    {
        if (setting('whatsapp_notify_letter_rejected', '1') !== '1') {
            return ['status' => false, 'message' => 'Notifikasi surat ditolak dinonaktifkan di pengaturan.'];
        }

        $phone = $request->phone;
        if (empty($phone)) {
            return ['status' => false, 'message' => 'Nomor WhatsApp pemohon tidak tersedia.'];
        }

        $desaName = setting('village_name', setting('site_name', 'Pemerintah Desa'));
        $letterName = $request->letterType?->name ?? 'Surat Keterangan';
        $applicantName = $request->applicant_name;
        $alasan = $reason ?? ($request->rejection_reason ?? 'Persyaratan belum lengkap atau data belum sesuai.');
        $trackUrl = route('warga.surat.show', $request->id);

        $message = "⚠️ *PEMBERITAHUAN PERMOHONAN SURAT*\n\n"
            . "Halo *{$applicantName}*,\n"
            . "Permohonan surat *{$letterName}* Anda belum dapat diproses oleh petugas *{$desaName}*.\n\n"
            . "❌ *Alasan Penolakan/Koreksi:*\n"
            . "\"_{$alasan}_\"\n\n"
            . "Silakan periksa kembali berkas persyaratan Anda dan lakukan pengajuan ulang melalui:\n"
            . "👉 {$trackUrl}\n\n"
            . "_Layanan Bantuan Pelayanan Masyarakat {$desaName}_";

        return $this->sendDirect($phone, $message);
    }

    /**
     * Kirim pesan WhatsApp langsung ke nomor tujuan menggunakan provider yang aktif.
     */
    public function sendDirect(string $phone, string $message): array
    {
        $cleanPhone = $this->formatPhoneNumber($phone);
        if (empty($cleanPhone)) {
            return ['status' => false, 'message' => 'Format nomor WhatsApp tidak valid.'];
        }

        $provider = setting('whatsapp_provider', 'mock');
        $token = setting('whatsapp_api_token', '');

        try {
            switch ($provider) {
                case 'fonnte':
                    if (empty($token)) {
                        return ['status' => false, 'message' => 'Token API Fonnte belum dikonfigurasi di Pengaturan WhatsApp.'];
                    }
                    $response = Http::withHeaders([
                        'Authorization' => $token,
                    ])->timeout(10)->post('https://api.fonnte.com/send', [
                        'target' => $cleanPhone,
                        'message' => $message,
                    ]);

                    if ($response->successful()) {
                        Log::info("[FONNTE-WA] Berhasil kirim pesan ke {$cleanPhone}");
                        return ['status' => true, 'provider' => 'fonnte', 'message' => 'Pesan WhatsApp berhasil dikirim via Fonnte.'];
                    }
                    return ['status' => false, 'provider' => 'fonnte', 'message' => 'Fonnte Error: ' . $response->body()];

                case 'wablas':
                    if (empty($token)) {
                        return ['status' => false, 'message' => 'Token API Wablas belum dikonfigurasi di Pengaturan WhatsApp.'];
                    }
                    $response = Http::withHeaders([
                        'Authorization' => $token,
                    ])->timeout(10)->post('https://phone.wablas.com/api/send-message', [
                        'phone' => $cleanPhone,
                        'message' => $message,
                    ]);

                    if ($response->successful()) {
                        Log::info("[WABLAS-WA] Berhasil kirim pesan ke {$cleanPhone}");
                        return ['status' => true, 'provider' => 'wablas', 'message' => 'Pesan WhatsApp berhasil dikirim via Wablas.'];
                    }
                    return ['status' => false, 'provider' => 'wablas', 'message' => 'Wablas Error: ' . $response->body()];

                case 'mock':
                default:
                    // Mode simulasi/development: tulis ke log agar developer dapat menguji flow tanpa kuota berbayar
                    Log::info("[MOCK-WHATSAPP] To: {$cleanPhone}\nMessage:\n{$message}");
                    return [
                        'status' => true,
                        'provider' => 'mock',
                        'message' => "Simulasi berhasil (Mock Driver). Pesan tercatat untuk {$cleanPhone}.",
                    ];
            }
        } catch (\Throwable $e) {
            Log::error("[WHATSAPP-ERROR] " . $e->getMessage());
            return ['status' => false, 'message' => 'Gagal mengirim WhatsApp: ' . $e->getMessage()];
        }
    }

    /**
     * Standardisasi format nomor HP Indonesia (e.g. 0812... -> 62812...).
     */
    public function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return (strlen($phone) >= 10 && strlen($phone) <= 15) ? $phone : '';
    }
}
