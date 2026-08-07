<?php

namespace Database\Seeders;

use App\Models\IdmScore;
use App\Models\IdmIndicator;
use Illuminate\Database\Seeder;

class IdmScoreSeeder extends Seeder
{
    public function run(): void
    {
        // IDM 2024
        $idm2024 = IdmScore::firstOrCreate(
            ['year' => 2024],
            [
                'total_score' => 0.8756,
                'status' => 'mandiri',
                'ike_score' => 0.8534,
                'ikl_score' => 0.8912,
                'iks_score' => 0.8823,
                'national_rank' => null,
                'provincial_rank' => 15,
                'district_rank' => 3,
                'published_at' => now()->subMonths(6),
            ]
        );

        // IDM 2023
        IdmScore::firstOrCreate(
            ['year' => 2023],
            [
                'total_score' => 0.8512,
                'status' => 'mandiri',
                'ike_score' => 0.8321,
                'ikl_score' => 0.8734,
                'iks_score' => 0.8480,
                'provincial_rank' => 18,
                'district_rank' => 4,
                'published_at' => now()->subYear()->subMonths(6),
            ]
        );

        // IDM 2022
        IdmScore::firstOrCreate(
            ['year' => 2022],
            [
                'total_score' => 0.8234,
                'status' => 'maju',
                'ike_score' => 0.8012,
                'ikl_score' => 0.8567,
                'iks_score' => 0.8123,
                'provincial_rank' => 22,
                'district_rank' => 6,
                'published_at' => now()->subYears(2)->subMonths(6),
            ]
        );

        // IDM indicators for 2024
        $indicators = [
            ['dimension' => 'ekonomi', 'indicator_name' => 'Keberadaan Lembaga Ekonomi', 'score' => 0.9200, 'weight' => 0.1667],
            ['dimension' => 'ekonomi', 'indicator_name' => 'Keterbukaan Wilayah', 'score' => 0.8500, 'weight' => 0.1667],
            ['dimension' => 'ekonomi', 'indicator_name' => 'Akses Distribusi dan Logistik', 'score' => 0.7900, 'weight' => 0.1667],
            ['dimension' => 'lingkungan', 'indicator_name' => 'Kualitas Lingkungan', 'score' => 0.8800, 'weight' => 0.3333],
            ['dimension' => 'lingkungan', 'indicator_name' => 'Potensi Rawan Bencana', 'score' => 0.9100, 'weight' => 0.3333],
            ['dimension' => 'sosial', 'indicator_name' => 'Kesehatan', 'score' => 0.9000, 'weight' => 0.2500],
            ['dimension' => 'sosial', 'indicator_name' => 'Pendidikan', 'score' => 0.8700, 'weight' => 0.2500],
            ['dimension' => 'sosial', 'indicator_name' => 'Modal Sosial', 'score' => 0.8600, 'weight' => 0.2500],
            ['dimension' => 'sosial', 'indicator_name' => 'Permukiman', 'score' => 0.8900, 'weight' => 0.2500],
        ];

        foreach ($indicators as $data) {
            IdmIndicator::firstOrCreate(
                ['idm_score_id' => $idm2024->id, 'indicator_name' => $data['indicator_name']],
                array_merge($data, ['idm_score_id' => $idm2024->id])
            );
        }
    }
}
