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
            Actions\Action::make('print_outgoing')
                ->label('Cetak Agenda Surat Keluar')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(route('admin.cetak.buku-agenda-surat', ['type' => 'outgoing']), shouldOpenInNewTab: true),

            Actions\Action::make('print_incoming')
                ->label('Cetak Agenda Surat Masuk')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->url(route('admin.cetak.buku-agenda-surat', ['type' => 'incoming']), shouldOpenInNewTab: true),

            Actions\CreateAction::make()->label('Catat Surat Baru'),
        ];
    }
}
