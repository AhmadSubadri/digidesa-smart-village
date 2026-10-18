<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterRequestResource\Pages;
use App\Models\LetterRequest;
use App\Services\LetterPdfService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class LetterRequestResource extends Resource
{
    protected static ?string $model = LetterRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'Layanan Administrasi';
    protected static ?string $navigationLabel = 'Permohonan Surat';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Permohonan Surat')
                    ->schema([
                        Forms\Components\TextInput::make('request_number')
                            ->label('Nomor Tiket Permohonan')
                            ->disabled(),
                        Forms\Components\TextInput::make('letter_number')
                            ->label('Nomor Surat Resmi (Permendagri)')
                            ->placeholder('Otomatis saat surat diterbitkan')
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
                                'submitted' => 'Diajukan Warga',
                                'rt_review' => 'Menunggu Verifikasi RT/RW',
                                'verifying' => 'Pemeriksaan Operator',
                                'processing' => 'Sedang Diproses',
                                'waiting_signature' => 'Menunggu TTD Kades',
                                'completed' => 'Selesai & Diterbitkan',
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
                Tables\Columns\TextColumn::make('letter_number')
                    ->label('No. Surat Resmi')
                    ->badge()
                    ->color('success')
                    ->placeholder(fn (LetterRequest $record) => $record->request_number)
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('resident.full_name')
                    ->label('Nama Pemohon')
                    ->placeholder(fn (LetterRequest $record) => $record->form_data['nama'] ?? 'Warga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resident.nik')
                    ->label('NIK')
                    ->placeholder(fn (LetterRequest $record) => $record->form_data['nik'] ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('letterType.name')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => fn ($state) => in_array($state, ['submitted', 'rt_review', 'verifying']),
                        'info' => 'processing',
                        'primary' => 'waiting_signature',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Diajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Diajukan',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('generate_official')
                    ->label('Terbitkan Surat')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terbitkan Surat Resmi Permendagri')
                    ->modalDescription('Sistem akan meng-generate nomor surat resmi, mencatat ke Buku Agenda Surat Keluar, dan menerbitkan berkas PDF/Word.')
                    ->action(function (LetterRequest $record) {
                        app(LetterPdfService::class)->generatePdf($record);
                        $record->refresh();

                        Notification::make()
                            ->title('Surat Berhasil Diterbitkan!')
                            ->body('Nomor Surat Resmi: ' . $record->letter_number)
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('download_pdf')
                    ->label('Unduh PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->visible(fn (LetterRequest $record) => !empty($record->pdf_path) && Storage::disk('public')->exists($record->pdf_path))
                    ->url(fn (LetterRequest $record) => Storage::disk('public')->url($record->pdf_path), shouldOpenInNewTab: true),

                Tables\Actions\Action::make('download_docx')
                    ->label('Unduh Word')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->visible(fn (LetterRequest $record) => !empty($record->docx_path) && Storage::disk('public')->exists($record->docx_path))
                    ->url(fn (LetterRequest $record) => Storage::disk('public')->url($record->docx_path), shouldOpenInNewTab: true),

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
