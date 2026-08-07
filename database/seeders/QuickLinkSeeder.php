<?php

namespace Database\Seeders;

use App\Models\QuickLink;
use Illuminate\Database\Seeder;

class QuickLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            ['title' => 'Surat Keterangan', 'description' => 'Ajukan permohonan surat keterangan secara online', 'icon' => 'heroicon-o-document-text', 'url' => '/layanan/surat', 'color' => '#2563EB', 'sort_order' => 1],
            ['title' => 'Data Kependudukan', 'description' => 'Informasi statistik kependudukan terkini', 'icon' => 'heroicon-o-users', 'url' => '/statistik', 'color' => '#7C3AED', 'sort_order' => 2],
            ['title' => 'APBKal', 'description' => 'Transparansi anggaran belanja kalurahan', 'icon' => 'heroicon-o-banknotes', 'url' => '/transparansi/apbkal', 'color' => '#16A34A', 'sort_order' => 3],
            ['title' => 'Pengaduan', 'description' => 'Sampaikan pengaduan dan aspirasi Anda', 'icon' => 'heroicon-o-megaphone', 'url' => '/pengaduan', 'color' => '#DC2626', 'sort_order' => 4],
            ['title' => 'Galeri', 'description' => 'Foto dan video kegiatan kalurahan', 'icon' => 'heroicon-o-photo', 'url' => '/galeri', 'color' => '#D97706', 'sort_order' => 5],
            ['title' => 'Agenda', 'description' => 'Jadwal kegiatan dan acara kalurahan', 'icon' => 'heroicon-o-calendar-days', 'url' => '/agenda', 'color' => '#0891B2', 'sort_order' => 6],
            ['title' => 'PPID', 'description' => 'Dokumen dan informasi publik', 'icon' => 'heroicon-o-folder-open', 'url' => '/ppid', 'color' => '#65A30D', 'sort_order' => 7],
            ['title' => 'Peta Desa', 'description' => 'Peta interaktif wilayah Condongcatur', 'icon' => 'heroicon-o-map', 'url' => '/peta', 'color' => '#E11D48', 'sort_order' => 8],
        ];

        foreach ($links as $data) {
            QuickLink::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
