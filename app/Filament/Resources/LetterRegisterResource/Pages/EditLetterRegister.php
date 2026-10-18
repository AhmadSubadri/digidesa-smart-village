<?php

namespace App\Filament\Resources\LetterRegisterResource\Pages;

use App\Filament\Resources\LetterRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLetterRegister extends EditRecord
{
    protected static string $resource = LetterRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
