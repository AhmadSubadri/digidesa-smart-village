<?php

namespace App\Filament\Resources\VillageAssetResource\Pages;

use App\Filament\Resources\VillageAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillageAsset extends EditRecord
{
    protected static string $resource = VillageAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
