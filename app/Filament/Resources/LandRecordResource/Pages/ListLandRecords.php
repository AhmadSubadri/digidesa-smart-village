<?php

namespace App\Filament\Resources\LandRecordResource\Pages;

use App\Filament\Resources\LandRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLandRecords extends ListRecords
{
    protected static string $resource = LandRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print_letter_c')
                ->label('Cetak Buku Letter C')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(route('admin.cetak.buku-letter-c'), shouldOpenInNewTab: true),

            Actions\CreateAction::make()->label('Tambah Bidang Tanah / C Baru'),
        ];
    }
}
