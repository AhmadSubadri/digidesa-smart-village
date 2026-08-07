<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Kalurahan Condongcatur', 'type' => 'text', 'label' => 'Nama Website', 'sort_order' => 1],
            ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Kalurahan Condongcatur, Kapanewon Depok, Sleman, D.I. Yogyakarta', 'type' => 'text', 'label' => 'Tagline Website', 'sort_order' => 2],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Website resmi Kalurahan Condongcatur sebagai pusat informasi dan layanan publik warga.', 'type' => 'textarea', 'label' => 'Deskripsi Website', 'sort_order' => 3],
            ['group' => 'general', 'key' => 'site_logo', 'value' => null, 'type' => 'image', 'label' => 'Logo Website', 'sort_order' => 4],
            ['group' => 'general', 'key' => 'site_favicon', 'value' => null, 'type' => 'image', 'label' => 'Favicon', 'sort_order' => 5],
            ['group' => 'general', 'key' => 'site_og_image', 'value' => null, 'type' => 'image', 'label' => 'OG Image (Share)', 'sort_order' => 6],

            // Contact
            ['group' => 'contact', 'key' => 'contact_address', 'value' => 'Jl. Manggis No. 1, Condongcatur, Depok, Sleman, D.I. Yogyakarta 55283', 'type' => 'textarea', 'label' => 'Alamat', 'sort_order' => 1],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '(0274) 881094', 'type' => 'text', 'label' => 'Nomor Telepon', 'sort_order' => 2],
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'condongcatur1946@gmail.com', 'type' => 'email', 'label' => 'Email', 'sort_order' => 3],
            ['group' => 'contact', 'key' => 'contact_maps_url', 'value' => 'https://maps.google.com/?q=Kalurahan+Condongcatur', 'type' => 'url', 'label' => 'Google Maps URL', 'sort_order' => 4],
            ['group' => 'contact', 'key' => 'contact_lat', 'value' => '-7.7500', 'type' => 'text', 'label' => 'Latitude Kantor', 'sort_order' => 5],
            ['group' => 'contact', 'key' => 'contact_lng', 'value' => '110.3833', 'type' => 'text', 'label' => 'Longitude Kantor', 'sort_order' => 6],

            // Social Media
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com/condongcatur', 'type' => 'url', 'label' => 'Facebook', 'sort_order' => 1],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://instagram.com/condongcatur', 'type' => 'url', 'label' => 'Instagram', 'sort_order' => 2],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => null, 'type' => 'url', 'label' => 'YouTube', 'sort_order' => 3],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => null, 'type' => 'url', 'label' => 'Twitter/X', 'sort_order' => 4],
            ['group' => 'social', 'key' => 'social_whatsapp', 'value' => '6281234567890', 'type' => 'text', 'label' => 'WhatsApp (no +)', 'sort_order' => 5],

            // Office Hours
            ['group' => 'office', 'key' => 'office_hours_weekday', 'value' => '07:30 - 16:00 WIB', 'type' => 'text', 'label' => 'Jam Kerja Senin-Jumat', 'sort_order' => 1],
            ['group' => 'office', 'key' => 'office_hours_saturday', 'value' => '08:00 - 12:00 WIB', 'type' => 'text', 'label' => 'Jam Kerja Sabtu', 'sort_order' => 2],
            ['group' => 'office', 'key' => 'office_hours_note', 'value' => 'Tutup pada hari Minggu dan hari libur nasional', 'type' => 'text', 'label' => 'Catatan Jam Kerja', 'sort_order' => 3],

            // Village Stats
            ['group' => 'stats', 'key' => 'village_area', 'value' => '948.6', 'type' => 'text', 'label' => 'Luas Wilayah (Ha)', 'sort_order' => 1],
            ['group' => 'stats', 'key' => 'village_population', 'value' => '28394', 'type' => 'number', 'label' => 'Jumlah Penduduk', 'sort_order' => 2],
            ['group' => 'stats', 'key' => 'village_families', 'value' => '9800', 'type' => 'number', 'label' => 'Jumlah KK', 'sort_order' => 3],
            ['group' => 'stats', 'key' => 'village_padukuhan', 'value' => '18', 'type' => 'number', 'label' => 'Jumlah Padukuhan', 'sort_order' => 4],
            ['group' => 'stats', 'key' => 'village_established_year', 'value' => '1946', 'type' => 'number', 'label' => 'Tahun Berdiri', 'sort_order' => 5],

            // Appearance
            ['group' => 'appearance', 'key' => 'theme_color_primary', 'value' => '#1B4F72', 'type' => 'color', 'label' => 'Warna Utama', 'sort_order' => 1],
            ['group' => 'appearance', 'key' => 'theme_color_secondary', 'value' => '#2E86C1', 'type' => 'color', 'label' => 'Warna Sekunder', 'sort_order' => 2],
            ['group' => 'appearance', 'key' => 'theme_color_accent', 'value' => '#F39C12', 'type' => 'color', 'label' => 'Warna Aksen', 'sort_order' => 3],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
