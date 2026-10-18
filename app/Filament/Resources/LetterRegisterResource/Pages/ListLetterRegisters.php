<?php

namespace App\Filament\Resources\LetterRegisterResource\Pages;

use App\Filament\Resources\LetterRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLetterRegisters extends ListRecords
{
    protected static string $resource = LetterRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Catat Surat Baru'),
        ];
    }
}
