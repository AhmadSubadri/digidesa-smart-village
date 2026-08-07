<?php

namespace App\Filament\Widgets;

use App\Models\LetterRequest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class LetterRequestTrendChartWidget extends ChartWidget
{
    protected static ?string $heading = '📈 Tren Permohonan Surat Mandiri (6 Bulan Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect();
        $counts = collect();

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months->push($month->translatedFormat('M Y'));
            
            $count = LetterRequest::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $counts->push($count);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Permohonan Surat',
                    'data' => $counts->toArray(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
