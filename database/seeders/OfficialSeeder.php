<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;

class OfficialSeeder extends Seeder
{
    public function run(): void
    {
        $officials = [
            ['name' => 'Drs. H. Ahmad Mukhlis, M.Si', 'position' => 'Lurah', 'rank' => 'IV/a', 'phone' => '08123456001', 'sort_order' => 1],
            ['name' => 'Ir. Budi Santoso', 'position' => 'Carik (Sekretaris Kalurahan)', 'rank' => 'III/d', 'phone' => '08123456002', 'sort_order' => 2],
            ['name' => 'Siti Rahmaningsih, S.E', 'position' => 'Kepala Seksi Pemerintahan', 'rank' => 'III/c', 'phone' => '08123456003', 'sort_order' => 3],
            ['name' => 'Agung Prasetyo, S.Sos', 'position' => 'Kepala Seksi Pemberdayaan', 'rank' => 'III/c', 'phone' => '08123456004', 'sort_order' => 4],
            ['name' => 'Nuryanti, A.Md', 'position' => 'Kepala Seksi Pelayanan', 'rank' => 'III/b', 'phone' => '08123456005', 'sort_order' => 5],
            ['name' => 'Wahyu Triyono', 'position' => 'Kepala Urusan Keuangan', 'rank' => 'III/b', 'phone' => '08123456006', 'sort_order' => 6],
            ['name' => 'Eni Sumarni, S.IP', 'position' => 'Kepala Urusan Tata Usaha & Umum', 'rank' => 'III/b', 'phone' => '08123456007', 'sort_order' => 7],
            ['name' => 'Dwi Purwanto', 'position' => 'Kepala Urusan Perencanaan', 'rank' => 'III/a', 'phone' => '08123456008', 'sort_order' => 8],
            ['name' => 'Tri Haryono', 'position' => 'Staf Administrasi', 'rank' => 'II/c', 'phone' => '08123456009', 'sort_order' => 9],
            ['name' => 'Rini Astuti', 'position' => 'Staf Keuangan', 'rank' => 'II/b', 'phone' => '08123456010', 'sort_order' => 10],
        ];

        foreach ($officials as $data) {
            Official::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
