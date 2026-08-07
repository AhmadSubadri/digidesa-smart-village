<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\ChartWidget;

class ComplaintStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = '📊 Status Pengaduan Warga';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $submitted = Complaint::where('status', 'submitted')->count();
        $inProgress = Complaint::where('status', 'in_progress')->count();
        $resolved = Complaint::where('status', 'resolved')->count();
        $rejected = Complaint::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Pengaduan',
                    'data' => [$submitted, $inProgress, $resolved, $rejected],
                    'backgroundColor' => [
                        '#F59E0B', // Submitted (Amber)
                        '#3B82F6', // In Progress (Blue)
                        '#10B981', // Resolved (Green)
                        '#EF4444', // Rejected (Red)
                    ],
                ],
            ],
            'labels' => ['Baru Masuk', 'Diproses', 'Selesai', 'Ditolak'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
