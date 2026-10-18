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
            Actions\CreateAction::make()->label('Tambah Aset Baru'),
        ];
    }
}
