<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Main navigation menu
        $mainMenu = Menu::firstOrCreate(
            ['location' => 'main'],
            ['name' => 'Menu Utama', 'is_active' => true]
        );

        $mainItems = [
            ['label' => 'Beranda', 'url' => '/', 'sort_order' => 1, 'children' => []],
            ['label' => 'Profil', 'url' => '#', 'sort_order' => 2, 'children' => [
                ['label' => 'Visi & Misi', 'url' => '/profil/visi-misi'],
                ['label' => 'Sejarah Desa', 'url' => '/profil/sejarah'],
                ['label' => 'Geografis & Peta', 'url' => '/profil/geografis'],
                ['label' => 'Demografi', 'url' => '/profil/demografi'],
            ]],
            ['label' => 'Pemerintahan', 'url' => '#', 'sort_order' => 3, 'children' => [
                ['label' => 'Struktur Organisasi', 'url' => '/pemerintahan/struktur'],
                ['label' => 'Perangkat Kalurahan', 'url' => '/pemerintahan/perangkat'],
                ['label' => 'Lembaga Desa', 'url' => '/pemerintahan/lembaga'],
            ]],
            ['label' => 'Informasi', 'url' => '#', 'sort_order' => 4, 'children' => [
                ['label' => 'Berita & Artikel', 'url' => '/berita'],
                ['label' => 'Agenda Kegiatan', 'url' => '/agenda'],
                ['label' => 'Pengumuman', 'url' => '/pengumuman'],
                ['label' => 'Galeri', 'url' => '/galeri'],
            ]],
            ['label' => 'Data & Statistik', 'url' => '#', 'sort_order' => 5, 'children' => [
                ['label' => 'Kependudukan', 'url' => '/statistik/kependudukan'],
                ['label' => 'Data Wilayah', 'url' => '/statistik/wilayah'],
                ['label' => 'IDM', 'url' => '/statistik/idm'],
                ['label' => 'SDGs', 'url' => '/statistik/sdgs'],
                ['label' => 'Peta Interaktif', 'url' => '/peta'],
            ]],
            ['label' => 'Transparansi', 'url' => '#', 'sort_order' => 6, 'children' => [
                ['label' => 'APBKal', 'url' => '/transparansi/apbkal'],
                ['label' => 'Pembangunan', 'url' => '/transparansi/pembangunan'],
                ['label' => 'Bantuan Sosial', 'url' => '/transparansi/bansos'],
                ['label' => 'PPID Dokumen', 'url' => '/ppid'],
            ]],
            ['label' => 'Layanan', 'url' => '/layanan', 'sort_order' => 7, 'children' => []],
            ['label' => 'Kontak', 'url' => '/kontak', 'sort_order' => 8, 'children' => []],
        ];

        foreach ($mainItems as $itemData) {
            $children = $itemData['children'];
            unset($itemData['children']);

            $parent = MenuItem::firstOrCreate(
                ['menu_id' => $mainMenu->id, 'label' => $itemData['label'], 'parent_id' => null],
                array_merge($itemData, ['menu_id' => $mainMenu->id, 'is_active' => true])
            );

            foreach ($children as $i => $child) {
                MenuItem::firstOrCreate(
                    ['menu_id' => $mainMenu->id, 'label' => $child['label'], 'parent_id' => $parent->id],
                    array_merge($child, ['menu_id' => $mainMenu->id, 'parent_id' => $parent->id, 'sort_order' => $i + 1, 'is_active' => true])
                );
            }
        }

        // Footer menu
        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'Menu Footer', 'is_active' => true]
        );

        $footerItems = [
            ['label' => 'Tentang Kami', 'url' => '/profil', 'sort_order' => 1],
            ['label' => 'Layanan', 'url' => '/layanan', 'sort_order' => 2],
            ['label' => 'Berita', 'url' => '/berita', 'sort_order' => 3],
            ['label' => 'Kontak', 'url' => '/kontak', 'sort_order' => 4],
            ['label' => 'Kebijakan Privasi', 'url' => '/kebijakan-privasi', 'sort_order' => 5],
        ];

        foreach ($footerItems as $item) {
            MenuItem::firstOrCreate(
                ['menu_id' => $footerMenu->id, 'label' => $item['label']],
                array_merge($item, ['menu_id' => $footerMenu->id, 'is_active' => true])
            );
        }
    }
}
