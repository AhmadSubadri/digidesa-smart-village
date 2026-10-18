<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicDocumentResource\Pages;
use App\Models\PublicDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PublicDocumentResource extends Resource
{
    protected static ?string $model = PublicDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationGroup = 'Regulasi & PPID';
    protected static ?string $navigationLabel = 'Buku Perdes & Dokumen Hukum';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen Hukum Desa (Permendagri No. 47/2016)')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Peraturan / Dokumen')
                            ->required()
                            ->placeholder('Contoh: Peraturan Desa Nomor 2 Tahun 2026 tentang APBDes'),
                        Forms\Components\Select::make('category')
                            ->label('Jenis Regulasi / Dokumen')
                            ->options([
                                'peraturan_kalurahan' => 'Peraturan Desa (Perdes)',
                                'sk_lurah' => 'Keputusan Kepala Desa (SK Kades)',
                                'produk_hukum' => 'Produk Hukum & Regulasi Desa',
                                'laporan_keuangan' => 'Laporan Keuangan & APBDes',
                                'rkp_kalurahan' => 'Rencana Kerja Pemerintah Desa (RKPDes)',
                                'lppd' => 'Laporan Penyelenggaraan Pemerintahan Desa (LPPD)',
                                'laporan_bpkal' => 'Laporan BPD / BPKal',
                                'profil_kalurahan' => 'Profil Desa',
                                'data_statistik' => 'Data Statistik Desa',
                                'lainnya' => 'Dokumen Publik Lainnya',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('fiscal_year')
                            ->label('Tahun Anggaran / Terbit')
                            ->numeric()
                            ->default(date('Y'))
                            ->required(),
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Berkas Dokumen Resmi (PDF)')
                            ->directory('documents/public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(20480)
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Ringkasan / Abstrak Peraturan')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan di Portal Website Desa')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->colors([
                        'primary' => 'perdes',
                        'info' => 'perkades',
                        'success' => 'kepkades',
                        'warning' => 'lppd',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('fiscal_year')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publik')
                    ->boolean(),
                Tables\Columns\TextColumn::make('download_count')
                    ->label('Diunduh')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Upload')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('fiscal_year')
                    ->label('Tahun'),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Unduh')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->visible(fn (PublicDocument $record) => !empty($record->file_path) && Storage::disk('public')->exists($record->file_path))
                    ->url(fn (PublicDocument $record) => Storage::disk('public')->url($record->file_path), shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPublicDocuments::route('/'),
            'create' => Pages\CreatePublicDocument::route('/create'),
            'edit' => Pages\EditPublicDocument::route('/{record}/edit'),
        ];
    }
}
