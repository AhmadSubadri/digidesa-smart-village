<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Selamat Datang di Kalurahan Condongcatur',
                'subtitle' => 'Melayani Dengan Hati, Membangun Bersama Warga. Kalurahan Condongcatur, Kapanewon Depok, Sleman.',
                'image_path' => 'banners/hero-1.jpg',
                'cta_text' => 'Layanan Mandiri',
                'cta_url' => '/layanan',
                'cta_secondary_text' => 'Profil Kalurahan',
                'cta_secondary_url' => '/profil',
                'text_position' => 'left',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Portal Layanan Warga Digital',
                'subtitle' => 'Urus surat keterangan, permohonan dokumen, dan layanan administrasi lainnya dari rumah. Cepat, mudah, dan transparan.',
                'image_path' => 'banners/hero-2.jpg',
                'cta_text' => 'Ajukan Permohonan',
                'cta_url' => '/warga/login',
                'cta_secondary_text' => 'Pelajari Lebih Lanjut',
                'cta_secondary_url' => '/layanan',
                'text_position' => 'center',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Transparansi Anggaran Kalurahan',
                'subtitle' => 'Kami berkomitmen untuk mengelola anggaran secara transparan dan akuntabel demi kesejahteraan warga Condongcatur.',
                'image_path' => 'banners/hero-3.jpg',
                'cta_text' => 'Lihat APBKal',
                'cta_url' => '/transparansi/apbkal',
                'text_position' => 'right',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $data) {
            Banner::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
