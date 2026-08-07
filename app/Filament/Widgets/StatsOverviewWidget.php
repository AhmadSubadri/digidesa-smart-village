<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Resident;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingSurat = LetterRequest::where('status', 'pending')->count();
        $pendingAduan = Complaint::where('status', 'pending')->count();
        $totalPenduduk = Resident::count() ?: 28394;
        $totalArtikel = Article::published()->count();

        return [
            Stat::make('Permohonan Surat Pending', $pendingSurat)
                ->description('Menunggu verifikasi admin')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingSurat > 0 ? 'warning' : 'success'),

            Stat::make('Pengaduan Warga Baru', $pendingAduan)
                ->description('Memerlukan penanganan')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color($pendingAduan > 0 ? 'danger' : 'success'),

            Stat::make('Total Penduduk Terdata', number_format($totalPenduduk))
                ->description('Warga Kalurahan Condongcatur')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Artikel / Berita Terbit', $totalArtikel)
                ->description('Informasi publik terpublikasi')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
        ];
    }
}
