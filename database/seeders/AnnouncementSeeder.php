<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Jadwal Pelayanan Administrasi Kependudukan',
                'content' => '<p>Pelayanan administrasi kependudukan di Kalurahan Condongcatur dilayani setiap hari kerja Senin s/d Jumat pukul 08.00 - 15.00 WIB dan Sabtu pukul 08.00 - 12.00 WIB.</p><p>Mohon membawa dokumen persyaratan yang lengkap dan membuat janji terlebih dahulu melalui WhatsApp resmi kalurahan.</p>',
                'priority' => 'normal',
                'is_ticker' => true,
                'is_pinned' => false,
                'is_popup' => false,
                'is_active' => true,
            ],
            [
                'title' => 'PENTING: Pemutakhiran Data Kependudukan 2025',
                'content' => '<p>Warga Kalurahan Condongcatur dihimbau untuk segera melakukan pemutakhiran data kependudukan. Program ini berlangsung mulai 1 Agustus - 31 Oktober 2025.</p><p>Bagi warga yang belum melakukan pemutakhiran data, harap segera datang ke kantor kalurahan dengan membawa KTP dan KK asli.</p>',
                'priority' => 'urgent',
                'is_ticker' => true,
                'is_pinned' => true,
                'is_popup' => true,
                'is_active' => true,
                'end_date' => now()->addMonths(3)->toDateString(),
            ],
            [
                'title' => 'Rekrutmen Petugas Sensus Ekonomi 2025',
                'content' => '<p>Badan Pusat Statistik bekerja sama dengan Kalurahan Condongcatur membuka rekrutmen petugas sensus ekonomi tahun 2025. Pendaftaran dibuka untuk warga Condongcatur yang memenuhi persyaratan.</p>',
                'priority' => 'important',
                'is_ticker' => false,
                'is_pinned' => true,
                'is_popup' => false,
                'is_active' => true,
                'end_date' => now()->addMonths(1)->toDateString(),
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
