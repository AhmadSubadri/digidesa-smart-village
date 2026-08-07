<?php

namespace Database\Seeders;

use App\Models\Padukuhan;
use Illuminate\Database\Seeder;

class PadukuhanSeeder extends Seeder
{
    public function run(): void
    {
        $padukuhans = [
            ['name' => 'Gejayan', 'code' => 'GJ', 'sort_order' => 1],
            ['name' => 'Kayen', 'code' => 'KY', 'sort_order' => 2],
            ['name' => 'Kentungan', 'code' => 'KT', 'sort_order' => 3],
            ['name' => 'Kledokan', 'code' => 'KL', 'sort_order' => 4],
            ['name' => 'Manggung', 'code' => 'MG', 'sort_order' => 5],
            ['name' => 'Mrican', 'code' => 'MR', 'sort_order' => 6],
            ['name' => 'Nologaten', 'code' => 'NL', 'sort_order' => 7],
            ['name' => 'Pelem Wulung', 'code' => 'PW', 'sort_order' => 8],
            ['name' => 'Perumnas Condongcatur', 'code' => 'PC', 'sort_order' => 9],
            ['name' => 'Pondok', 'code' => 'PD', 'sort_order' => 10],
            ['name' => 'Ringinsari', 'code' => 'RS', 'sort_order' => 11],
            ['name' => 'Sambilegi', 'code' => 'SB', 'sort_order' => 12],
            ['name' => 'Sanggrahan', 'code' => 'SG', 'sort_order' => 13],
            ['name' => 'Saren', 'code' => 'SR', 'sort_order' => 14],
            ['name' => 'Satu Atap Condongcatur', 'code' => 'SA', 'sort_order' => 15],
            ['name' => 'Soropadan', 'code' => 'SP', 'sort_order' => 16],
            ['name' => 'Sukunan', 'code' => 'SK', 'sort_order' => 17],
            ['name' => 'Tambak Bayan', 'code' => 'TB', 'sort_order' => 18],
        ];

        foreach ($padukuhans as $data) {
            Padukuhan::firstOrCreate(
                ['code' => $data['code']],
                array_merge($data, [
                    'population' => rand(1000, 2500),
                    'families_count' => rand(300, 700),
                    'total_rt' => rand(5, 15),
                    'total_rw' => rand(2, 6),
                    'area_size' => rand(30, 100) + (rand(0, 99) / 100),
                ])
            );
        }
    }
}
