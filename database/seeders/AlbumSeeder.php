<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'title' => 'Musyawarah Kalurahan 2025',
                'description' => 'Dokumentasi pelaksanaan Musyawarah Kalurahan Condongcatur tahun 2025 dalam rangka penetapan RKP Kalurahan.',
                'category' => 'pemerintahan',
                'event_date' => now()->subMonths(1)->toDateString(),
                'photographer' => 'Tim Dokumentasi Kalurahan',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Festival UMKM Condongcatur 2025',
                'description' => 'Momen-momen berkesan dari Festival UMKM Condongcatur 2025 yang menghadirkan 50+ pelaku usaha dari seluruh padukuhan.',
                'category' => 'kegiatan',
                'event_date' => now()->subMonths(2)->toDateString(),
                'photographer' => 'Tim Dokumentasi Kalurahan',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Gotong Royong Bersih Desa 2025',
                'description' => 'Kegiatan gotong royong warga Condongcatur dalam rangka menjaga kebersihan lingkungan dan membersihkan saluran air.',
                'category' => 'kegiatan',
                'event_date' => now()->subMonths(3)->toDateString(),
                'photographer' => 'Tim Dokumentasi Kalurahan',
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Pembangunan Infrastruktur 2024',
                'description' => 'Dokumentasi progres pembangunan infrastruktur di Kalurahan Condongcatur tahun 2024 meliputi perbaikan jalan dan saluran irigasi.',
                'category' => 'pembangunan',
                'event_date' => now()->subYear()->toDateString(),
                'photographer' => 'Tim Dokumentasi Kalurahan',
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($albums as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']);
            Album::firstOrCreate(
                ['slug' => $slug],
                array_merge($data, ['slug' => $slug])
            );
        }
    }
}
