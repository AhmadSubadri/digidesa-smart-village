<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandRecordResource\Pages;
use App\Filament\Resources\LandRecordResource\RelationManagers\MutationsRelationManager;
use App\Models\LandRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LandRecordResource extends Resource
{
    protected static ?string $model = LandRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Pertanahan & Aset';

    protected static ?string $navigationLabel = 'Buku Tanah & Letter C';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Letter C & Persil')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('kohir_number')
                            ->label('Nomor Kohir / Buku C')
                            ->placeholder('e.g. C. 124')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('persil_number')
                            ->label('Nomor Persil')
                            ->placeholder('e.g. 14 / D.I')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('land_class')
                            ->label('Kelas Tanah')
                            ->placeholder('e.g. S.I, S.II, D.I')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('certificate_number')
                            ->label('Nomor Sertifikat (SHM/HGB)'),
                        Forms\Components\TextInput::make('tax_number')
                            ->label('Nomor SPPT PBB / NOP'),
                        Forms\Components\TextInput::make('area_m2')
                            ->label('Luas Bidang (m²)')
                            ->numeric()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Kepemilikan & Pemanfaatan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('owner_resident_id')
                            ->label('Warga Pemilik (Terkoneksi NIK)')
                            ->relationship('owner', 'full_name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('owner_name')
                            ->label('Nama Pemilik / Atas Nama di Buku C')
                            ->required(),
                        Forms\Components\Select::make('usage_type')
                            ->label('Peruntukan / Kategori Tanah')
                            ->options([
                                'milik_warga' => 'Milik Warga / Adat',
                                'tanah_kas_desa' => 'Tanah Kas Desa (TKD)',
                                'bengkok' => 'Tanah Bengkok / Jabatan',
                                'pelungguh' => 'Tanah Pelungguh',
                                'fasilitas_umum' => 'Fasilitas Umum (Masjid, Sekolah, Jalan)',
                                'makam' => 'Makam Desa',
                                'lainnya' => 'Lainnya',
                            ])
                            ->default('milik_warga')
                            ->required(),
                        Forms\Components\Select::make('ownership_type')
                            ->label('Status Hak Kepemilikan')
                            ->options([
                                'hak_milik' => 'Hak Milik',
                                'hak_guna' => 'Hak Guna Bangunan (HGB)',
                                'hak_pakai' => 'Hak Pakai',
                                'tanah_desa' => 'Tanah Desa',
                                'tanah_negara' => 'Tanah Negara',
                            ])
                            ->default('hak_milik')
                            ->required(),
                        Forms\Components\Select::make('padukuhan_id')
                            ->label('Wilayah Dusun / Padukuhan')
                            ->relationship('padukuhan', 'name')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status Sengketa')
                            ->options([
                                'active' => 'Aktif / Bersih',
                                'disputed' => 'Dalam Sengketa',
                                'sold' => 'Sudah Beralih Hak Seluruhnya',
                            ])
                            ->default('active')
                            ->required(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat / Lokasi / Blok')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Batas-Batas Bidang (Utara, Timur, Selatan, Barat)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kohir_number')
                    ->label('No. Kohir')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('persil_number')
                    ->label('Persil / Kelas')
                    ->formatStateUsing(fn ($record) => $record->persil_number . ($record->land_class ? ' (' . $record->land_class . ')' : ''))
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Nama Pemilik')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_type')
                    ->label('Peruntukan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tanah_kas_desa', 'bengkok' => 'warning',
                        'fasilitas_umum' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('area_m2')
                    ->label('Luas (m²)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('padukuhan.name')
                    ->label('Dusun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'disputed' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('usage_type')
                    ->label('Kategori')
                    ->options([
                        'milik_warga' => 'Milik Warga',
                        'tanah_kas_desa' => 'Tanah Kas Desa',
                        'bengkok' => 'Bengkok',
                        'fasilitas_umum' => 'Fasilitas Umum',
                    ]),
                Tables\Filters\SelectFilter::make('padukuhan_id')
                    ->label('Dusun')
                    ->relationship('padukuhan', 'name'),
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

    public static function getRelations(): array
    {
        return [
            MutationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLandRecords::route('/'),
            'create' => Pages\CreateLandRecord::route('/create'),
            'edit' => Pages\EditLandRecord::route('/{record}/edit'),
        ];
    }
}
