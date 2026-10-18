<?php

namespace App\Filament\Resources\LetterRegisterResource\Pages;

use App\Filament\Resources\LetterRegisterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLetterRegister extends CreateRecord
{
    protected static string $resource = LetterRegisterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['archived_by'] = auth()->id();
        return $data;
    }
}
