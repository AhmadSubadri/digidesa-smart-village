<?php

namespace App\Filament\Resources\VillageAssetResource\Pages;

use App\Filament\Resources\VillageAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillageAssets extends ListRecords
{
    protected static string $resource = VillageAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print_assets')
                ->label('Cetak Buku Inventaris Aset')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(route('admin.cetak.buku-inventaris-aset'), shouldOpenInNewTab: true),

            Actions\CreateAction::make()->label('Tambah Aset Baru'),
        ];
    }
}
