<?php

namespace App\Filament\Widgets;

use App\Models\LetterRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLetterRequestsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Permohonan Surat Terbaru Warga';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LetterRequest::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('request_number')->label('No Tiket')->searchable(),
                Tables\Columns\TextColumn::make('applicant_name')->label('Nama Pemohon'),
                Tables\Columns\TextColumn::make('nik')->label('NIK'),
                Tables\Columns\TextColumn::make('letterType.name')->label('Jenis Surat'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'primary' => 'approved',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu Masuk')->dateTime('d M Y H:i'),
            ]);
    }
}
