<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterRequestResource\Pages;
use App\Models\LetterLog;
use App\Models\LetterRequest;
use App\Services\LetterPdfService;
use App\Services\WhatsappService;
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
                            ->label('NIK Pemohon')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. WhatsApp Pemohon')
                            ->disabled(),
                        Forms\Components\Select::make('letter_type_id')
                            ->label('Jenis Surat')
                            ->relationship('letterType', 'name')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status Permohonan')
                            ->options([
                                'submitted' => 'Diajukan',
                                'rt_review' => 'Verifikasi RT/RW',
                                'verifying' => 'Pemeriksaan Berkas Desa',
                                'processing' => 'Sedang Diproses',
                                'waiting_signature' => 'Menunggu TTD Kepala Desa',
                                'completed' => 'Selesai & Diterbitkan',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('purpose')
                            ->label('Keperluan')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (Jika ditolak)')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('letter_number')
                    ->label('No. Surat Resmi')
                    ->placeholder('Belum terbit')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('applicant_name')
                    ->label('Nama Pemohon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('WhatsApp')
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
                Tables\Columns\IconColumn::make('wa_notification_sent')
                    ->label('WA Sent')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
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
                    ->visible(fn (LetterRequest $record) => $record->status !== 'completed' && $record->status !== 'rejected')
                    ->modalHeading('Terbitkan Surat Resmi Permendagri')
                    ->modalDescription('Sistem akan meng-generate nomor surat resmi, mencatat ke Buku Agenda Surat Keluar, menerbitkan berkas PDF/Word, dan mengirim notifikasi WhatsApp ke warga.')
                    ->action(function (LetterRequest $record) {
                        app(LetterPdfService::class)->generatePdf($record);
                        $record->refresh();

                        LetterLog::create([
                            'letter_request_id' => $record->id,
                            'action' => 'Surat resmi disahkan dan diterbitkan oleh petugas desa',
                            'old_status' => $record->status,
                            'new_status' => 'completed',
                            'notes' => 'Nomor Surat Resmi: ' . $record->letter_number,
                            'created_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Surat Berhasil Diterbitkan!')
                            ->body('Nomor Surat Resmi: ' . $record->letter_number . '. Notifikasi WA otomatis dikirim.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject_request')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (LetterRequest $record) => $record->status !== 'completed' && $record->status !== 'rejected')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('Contoh: Berkas KTP buram, silakan lampirkan scan KTP yang lebih jelas.')
                            ->required(),
                    ])
                    ->action(function (LetterRequest $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['reason'],
                        ]);

                        LetterLog::create([
                            'letter_request_id' => $record->id,
                            'action' => 'Permohonan surat ditolak oleh petugas desa',
                            'old_status' => $record->status,
                            'new_status' => 'rejected',
                            'notes' => 'Alasan: ' . $data['reason'],
                            'created_at' => now(),
                        ]);

                        app(WhatsappService::class)->sendLetterRejected($record, $data['reason']);

                        Notification::make()
                            ->title('Permohonan Surat Ditolak')
                            ->body('Status diperbarui dan notifikasi penolakan telah dikirimkan ke pemohon.')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\Action::make('send_wa')
                    ->label('Kirim Ulang WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Notifikasi WhatsApp')
                    ->modalDescription('Kirim pembaruan status surat ini ke nomor WhatsApp pemohon.')
                    ->action(function (LetterRequest $record) {
                        $wa = app(WhatsappService::class);
                        if ($record->status === 'completed') {
                            $res = $wa->sendLetterApproved($record);
                        } elseif ($record->status === 'rejected') {
                            $res = $wa->sendLetterRejected($record);
                        } else {
                            $res = $wa->sendLetterSubmitted($record);
                        }

                        if ($res['status'] ?? false) {
                            Notification::make()
                                ->title('WhatsApp Terkirim!')
                                ->body($res['message'] ?? 'Pesan berhasil diteruskan ke gateway.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('WhatsApp Gagal Terkirim')
                                ->body($res['message'] ?? 'Terjadi kendala pengiriman.')
                                ->danger()
                                ->send();
                        }
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
