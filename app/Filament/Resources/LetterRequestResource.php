<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterRequestResource\Pages;
use App\Models\LetterRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LetterRequestResource extends Resource
{
    protected static ?string $model = LetterRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Layanan Kependudukan';
    protected static ?string $navigationLabel = 'Permohonan Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Permohonan Surat')
                    ->schema([
                        Forms\Components\TextInput::make('request_number')
                            ->label('Nomor Tiket/Surat')
                            ->disabled(),
                        Forms\Components\TextInput::make('applicant_name')
                            ->label('Nama Pemohon')
                            ->disabled(),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->disabled(),
                        Forms\Components\Select::make('letter_type_id')
                            ->label('Jenis Surat')
                            ->relationship('letterType', 'name')
                            ->disabled(),
                        Forms\Components\Textarea::make('purpose')
                            ->label('Keperluan')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('Status Approval')
                            ->options([
                                'pending' => 'Menunggu Verifikasi',
                                'processing' => 'Sedang Diproses',
                                'approved' => 'Disetujui',
                                'completed' => 'Selesai / Terbit',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (Jika Ditolak)')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_number')->label('No Tiket')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('applicant_name')->label('Pemohon')->searchable(),
                Tables\Columns\TextColumn::make('nik')->label('NIK')->searchable(),
                Tables\Columns\TextColumn::make('letterType.name')->label('Jenis Surat')->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'primary' => 'approved',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('Tgl Permohonan')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'approved' => 'Approved',
                    'completed' => 'Completed',
                    'rejected' => 'Rejected',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('generate_pdf')
                    ->label('Terbitkan PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function (LetterRequest $record) {
                        app(\App\Services\LetterPdfService::class)->generatePdf($record);
                        \Filament\Notifications\Notification::make()
                            ->title('Surat Berhasil Diterbitkan')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetterRequests::route('/'),
            'create' => Pages\CreateLetterRequest::route('/create'),
            'edit' => Pages\EditLetterRequest::route('/{record}/edit'),
        ];
    }
}
