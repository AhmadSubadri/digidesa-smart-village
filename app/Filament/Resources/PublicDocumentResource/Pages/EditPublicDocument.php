<?php

namespace App\Filament\Resources\PublicDocumentResource\Pages;

use App\Filament\Resources\PublicDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicDocument extends EditRecord
{
    protected static string $resource = PublicDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
