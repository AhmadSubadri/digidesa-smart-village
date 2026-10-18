<?php

namespace App\Filament\Resources\PublicDocumentResource\Pages;

use App\Filament\Resources\PublicDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublicDocuments extends ListRecords
{
    protected static string $resource = PublicDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Dokumen Regulasi'),
        ];
    }
}
