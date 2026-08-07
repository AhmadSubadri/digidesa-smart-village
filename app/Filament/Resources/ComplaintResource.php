<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Layanan Kependudukan';
    protected static ?string $navigationLabel = 'Pengaduan Warga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Penanganan Pengaduan')
                    ->schema([
                        Forms\Components\TextInput::make('ticket_number')
                            ->label('No. Tiket')
                            ->disabled(),
                        Forms\Components\TextInput::make('reporter_name')
                            ->label('Pelapor')
                            ->disabled(),
                        Forms\Components\TextInput::make('reporter_phone')
                            ->label('No HP')
                            ->disabled(),
                        Forms\Components\TextInput::make('category')
                            ->label('Kategori')
                            ->disabled(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Pengaduan')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('content')
                            ->label('Isi Laporan')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('Status Pengaduan')
                            ->options([
                                'pending' => 'Pending',
                                'process' => 'Dalam Proses',
                                'resolved' => 'Selesai / Selesai Ditolak',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('response')
                            ->label('Tanggapan / Tindak Lanjut Pemkal')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')->label('No Tiket')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Judul Laporan')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('reporter_name')->label('Pelapor')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'process',
                        'success' => 'resolved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('Tgl Masuk')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'process' => 'Proses',
                    'resolved' => 'Selesai',
                    'rejected' => 'Ditolak',
                ]),
            ])
            ->actions([
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
