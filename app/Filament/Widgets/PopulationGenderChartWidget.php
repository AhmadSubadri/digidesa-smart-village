<?php

namespace App\Filament\Widgets;

use App\Models\Resident;
use Filament\Widgets\ChartWidget;

class PopulationGenderChartWidget extends ChartWidget
{
    protected static ?string $heading = '👥 Komposisi Jenis Kelamin Penduduk';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $male = Resident::where('gender', 'L')->count();
        $female = Resident::where('gender', 'P')->count();

        // Fallback if no residents in DB yet
        if ($male === 0 && $female === 0) {
            $male = 15420;
            $female = 15830;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jenis Kelamin',
                    'data' => [$male, $female],
                    'backgroundColor' => [
                        '#1D4ED8', // Laki-laki (Dark Blue)
                        '#EC4899', // Perempuan (Pink)
                    ],
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
