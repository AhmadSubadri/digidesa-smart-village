<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Posyandu Balita Padukuhan Gejayan',
                'description' => 'Pelaksanaan Posyandu rutin untuk balita dan ibu hamil di Padukuhan Gejayan. Bawa buku KIA dan kartu posyandu.',
                'location' => 'Balai Padukuhan Gejayan',
                'start_datetime' => now()->addDays(5)->setTime(8, 0),
                'end_datetime' => now()->addDays(5)->setTime(11, 0),
                'organizer' => 'Kader Posyandu Gejayan',
                'status' => 'upcoming',
                'is_published' => true,
            ],
            [
                'title' => 'Rapat Koordinasi Lembaga Desa',
                'description' => 'Rapat koordinasi bulanan antar lembaga desa untuk membahas program kerja dan evaluasi kegiatan.',
                'location' => 'Aula Balai Kalurahan Condongcatur',
                'start_datetime' => now()->addDays(10)->setTime(9, 0),
                'end_datetime' => now()->addDays(10)->setTime(12, 0),
                'organizer' => 'Pemerintah Kalurahan Condongcatur',
                'status' => 'upcoming',
                'is_published' => true,
            ],
            [
                'title' => 'Pelatihan Digital Marketing UMKM',
                'description' => 'Pelatihan pemasaran digital untuk pelaku UMKM Condongcatur. Peserta akan mendapatkan materi tentang media sosial, marketplace, dan fotografi produk.',
                'location' => 'Gedung Pertemuan Dusun Kentungan',
                'start_datetime' => now()->addDays(14)->setTime(8, 30),
                'end_datetime' => now()->addDays(14)->setTime(16, 0),
                'organizer' => 'Dinas Koperasi dan UMKM Sleman',
                'contact_person' => 'Pak Joko',
                'contact_phone' => '08123456789',
                'status' => 'upcoming',
                'is_published' => true,
            ],
            [
                'title' => 'Lomba 17-an Agustus Tingkat Kalurahan',
                'description' => 'Peringatan HUT Kemerdekaan RI ke-80 tingkat Kalurahan Condongcatur. Berbagai lomba dan kegiatan budaya akan dimeriahkan oleh seluruh warga.',
                'location' => 'Lapangan Condongcatur',
                'start_datetime' => now()->addDays(9)->setTime(7, 0),
                'end_datetime' => now()->addDays(9)->setTime(17, 0),
                'organizer' => 'Panitia HUT RI Condongcatur',
                'attendees_count' => 0,
                'status' => 'upcoming',
                'is_published' => true,
            ],
        ];

        foreach ($events as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']) . '-' . now()->format('Ymd');
            Event::firstOrCreate(
                ['slug' => $slug],
                array_merge($data, ['slug' => $slug])
            );
        }
    }
}
