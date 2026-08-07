<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita', 'slug' => 'berita', 'icon' => 'heroicon-o-newspaper', 'color' => '#2563EB', 'sort_order' => 1],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'icon' => 'heroicon-o-megaphone', 'color' => '#DC2626', 'sort_order' => 2],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'icon' => 'heroicon-o-calendar', 'color' => '#16A34A', 'sort_order' => 3],
            ['name' => 'Pemerintahan', 'slug' => 'pemerintahan', 'icon' => 'heroicon-o-building-library', 'color' => '#7C3AED', 'sort_order' => 4],
            ['name' => 'Pembangunan', 'slug' => 'pembangunan', 'icon' => 'heroicon-o-wrench-screwdriver', 'color' => '#D97706', 'sort_order' => 5],
            ['name' => 'Sosial', 'slug' => 'sosial', 'icon' => 'heroicon-o-heart', 'color' => '#DB2777', 'sort_order' => 6],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'icon' => 'heroicon-o-heart', 'color' => '#059669', 'sort_order' => 7],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'icon' => 'heroicon-o-academic-cap', 'color' => '#0EA5E9', 'sort_order' => 8],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'icon' => 'heroicon-o-currency-dollar', 'color' => '#CA8A04', 'sort_order' => 9],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
