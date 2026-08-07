<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            ['name' => 'Badan Permusyawaratan Kalurahan (BPKal)', 'abbreviation' => 'BPKal', 'type' => 'legislatif', 'chairman_name' => 'H. Supriyanto, S.H', 'members_count' => 9, 'period' => '2021-2027'],
            ['name' => 'LPMK Condongcatur', 'abbreviation' => 'LPMK', 'type' => 'pemberdayaan', 'chairman_name' => 'Bambang Suharno', 'members_count' => 15, 'period' => '2023-2028'],
            ['name' => 'PKK Condongcatur', 'abbreviation' => 'PKK', 'type' => 'perempuan', 'chairman_name' => 'Hj. Sri Rahayu', 'members_count' => 50, 'period' => '2022-2027'],
            ['name' => 'Karang Taruna Condongcatur', 'abbreviation' => 'Karang Taruna', 'type' => 'pemuda', 'chairman_name' => 'Bagas Prasetyo', 'members_count' => 120, 'period' => '2024-2026'],
            ['name' => 'Linmas Condongcatur', 'abbreviation' => 'Linmas', 'type' => 'keamanan', 'chairman_name' => 'Joko Susilo', 'members_count' => 35, 'period' => '2023-2028'],
            ['name' => 'Kelompok Tani Condongcatur', 'abbreviation' => 'Gapoktan', 'type' => 'pertanian', 'chairman_name' => 'Mugiyono', 'members_count' => 85, 'period' => '2022-2027'],
            ['name' => 'BUMKal Condongcatur Mandiri', 'abbreviation' => 'BUMKal', 'type' => 'ekonomi', 'chairman_name' => 'Ir. Hartono', 'members_count' => 12, 'period' => '2023-2026'],
            ['name' => 'Forum Kesehatan Kalurahan', 'abbreviation' => 'FKK', 'type' => 'kesehatan', 'chairman_name' => 'dr. Retno Widyastuti', 'members_count' => 25, 'period' => '2024-2026'],
        ];

        foreach ($institutions as $data) {
            Institution::firstOrCreate(
                ['abbreviation' => $data['abbreviation']],
                array_merge($data, ['is_active' => true, 'sort_order' => 0])
            );
        }
    }
}
