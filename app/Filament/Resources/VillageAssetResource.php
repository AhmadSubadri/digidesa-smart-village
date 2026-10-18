<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillageAssetResource\Pages;
use App\Models\VillageAsset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VillageAssetResource extends Resource
{
    protected static ?string $model = VillageAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Pertanahan & Aset';
    protected static ?string $navigationLabel = 'Buku Inventaris Aset Desa';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Aset Desa (Permendagri No. 1/2016)')
                    ->schema([
                        Forms\Components\TextInput::make('asset_code')
                            ->label('Kode Barang / Aset')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: 01.01.01.001'),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Barang / Aset')
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label('Kategori Aset')
                            ->options([
                                'tanah' => 'Tanah Kas Desa / Bangunan',
                                'bangunan' => 'Gedung dan Bangunan (Kantor, Balai, Posyandu)',
                                'kendaraan' => 'Kendaraan Bermotor (Ambulans, Siaga, Dinas)',
                                'peralatan' => 'Peralatan dan Mesin (Komputer, Traktor, Genset)',
                                'aset_tetap_lainnya' => 'Aset Tetap Lainnya (Buku, Kesenian, dll)',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi Keberadaan Aset')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        Forms\Components\TextInput::make('unit')
                            ->label('Satuan')
                            ->placeholder('Unit / Bidang / Buah')
                            ->default('Unit')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Perolehan & Kondisi')
                    ->schema([
                        Forms\Components\DatePicker::make('acquisition_date')
                            ->label('Tanggal Perolehan'),
                        Forms\Components\TextInput::make('acquisition_value')
                            ->label('Nilai Perolehan (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        Forms\Components\Select::make('source_fund')
                            ->label('Asal-usul / Sumber Dana')
                            ->options([
                                'APBDes (Dana Desa / ADD)' => 'APBDes (Dana Desa / ADD)',
                                'Kekayaan Asli Desa' => 'Kekayaan Asli Desa',
                                'Bantuan Pemerintah Pusat' => 'Bantuan Pemerintah Pusat',
                                'Bantuan Pemprov / Pemkab' => 'Bantuan Pemprov / Pemkab',
                                'Sumbangan / Hibah Masyarakat' => 'Sumbangan / Hibah Masyarakat',
                            ])
                            ->required(),
                        Forms\Components\Select::make('current_condition')
                            ->label('Kondisi Saat Ini')
                            ->options([
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                                'hilang' => 'Hilang / Dihapus',
                            ])
                            ->default('baik')
                            ->required(),
                        Forms\Components\TextInput::make('responsible_person')
                            ->label('Penanggung Jawab / Pemegang Barang')
                            ->placeholder('Nama Perangkat Desa / Kaur Keuangan / Sekdes'),
                        Forms\Components\FileUpload::make('photo_path')
                            ->label('Foto Dokumentasi Aset')
                            ->image()
                            ->directory('assets/photos'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Spesifikasi Barang')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Mutasi / Keterangan Tambahan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_code')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_condition')
                    ->label('Kondisi')
                    ->badge()
                    ->colors([
                        'success' => 'baik',
                        'warning' => 'rusak_ringan',
                        'danger' => 'rusak_berat',
                        'secondary' => 'hilang',
                    ]),
                Tables\Columns\TextColumn::make('acquisition_value')
                    ->label('Nilai (Rp)')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('source_fund')
                    ->label('Sumber Dana')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('current_condition')
                    ->label('Kondisi'),
            ])
            ->actions([
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
            'index' => Pages\ListVillageAssets::route('/'),
            'create' => Pages\CreateVillageAsset::route('/create'),
            'edit' => Pages\EditVillageAsset::route('/{record}/edit'),
        ];
    }
}
