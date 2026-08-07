<?php

namespace Database\Seeders;

use App\Models\SdgsGoal;
use App\Models\SdgsScore;
use Illuminate\Database\Seeder;

class SdgsSeeder extends Seeder
{
    public function run(): void
    {
        // SDGs 18 Goals (Desa)
        $goals = [
            ['number' => 1, 'name' => 'Desa Tanpa Kemiskinan', 'color' => '#E5243B'],
            ['number' => 2, 'name' => 'Desa Tanpa Kelaparan', 'color' => '#DDA63A'],
            ['number' => 3, 'name' => 'Desa Sehat dan Sejahtera', 'color' => '#4C9F38'],
            ['number' => 4, 'name' => 'Pendidikan Berkualitas', 'color' => '#C5192D'],
            ['number' => 5, 'name' => 'Kesetaraan Gender', 'color' => '#FF3A21'],
            ['number' => 6, 'name' => 'Air Bersih dan Sanitasi Layak', 'color' => '#26BDE2'],
            ['number' => 7, 'name' => 'Energi Bersih dan Terjangkau', 'color' => '#FCC30B'],
            ['number' => 8, 'name' => 'Pertumbuhan Ekonomi dan Pekerjaan Layak', 'color' => '#A21942'],
            ['number' => 9, 'name' => 'Industri, Inovasi dan Infrastruktur', 'color' => '#FD6925'],
            ['number' => 10, 'name' => 'Berkurangnya Kesenjangan', 'color' => '#DD1367'],
            ['number' => 11, 'name' => 'Kota dan Permukiman Berkelanjutan', 'color' => '#FD9D24'],
            ['number' => 12, 'name' => 'Konsumsi dan Produksi yang Bertanggung Jawab', 'color' => '#BF8B2E'],
            ['number' => 13, 'name' => 'Penanganan Perubahan Iklim', 'color' => '#3F7E44'],
            ['number' => 14, 'name' => 'Ekosistem Lautan', 'color' => '#0A97D9'],
            ['number' => 15, 'name' => 'Ekosistem Daratan', 'color' => '#56C02B'],
            ['number' => 16, 'name' => 'Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'color' => '#00689D'],
            ['number' => 17, 'name' => 'Kemitraan untuk Mencapai Tujuan', 'color' => '#19486A'],
            ['number' => 18, 'name' => 'Kelembagaan Desa Dinamis dan Budaya Desa Adaptif', 'color' => '#4B0082'],
        ];

        foreach ($goals as $goalData) {
            $goal = SdgsGoal::firstOrCreate(
                ['number' => $goalData['number']],
                $goalData
            );

            // Add 2024 scores
            SdgsScore::firstOrCreate(
                ['sdgs_goal_id' => $goal->id, 'year' => 2024],
                [
                    'sdgs_goal_id' => $goal->id,
                    'year' => 2024,
                    'score' => rand(60, 95) + (rand(0, 99) / 100),
                    'status' => 'berkembang',
                ]
            );
        }
    }
}
