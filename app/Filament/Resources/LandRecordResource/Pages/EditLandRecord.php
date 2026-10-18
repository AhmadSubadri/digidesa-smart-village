<?php

namespace App\Filament\Resources\LandRecordResource\Pages;

use App\Filament\Resources\LandRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLandRecord extends EditRecord
{
    protected static string $resource = LandRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
