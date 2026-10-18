<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyResource\Pages;
use App\Models\Family;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Layanan Kependudukan';
    protected static ?string $navigationLabel = 'Buku Kartu Keluarga (KK)';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Kartu Keluarga')
                    ->schema([
                        Forms\Components\TextInput::make('kk_number')
                            ->label('Nomor Kartu Keluarga (No. KK)')
                            ->required()
                            ->maxLength(16),
                        Forms\Components\Select::make('padukuhan_id')
                            ->label('Padukuhan / Dusun')
                            ->relationship('padukuhan', 'name')
                            ->required(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap KK')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Select::make('economic_status')
                            ->label('Status Ekonomi')
                            ->options([
                                'mampu' => 'Mampu',
                                'menengah' => 'Menengah',
                                'rentan' => 'Rentan / Menengah ke Bawah',
                                'miskin' => 'Keluarga Miskin (Penerima Bansos)',
                            ]),
                        Forms\Components\Select::make('status')
                            ->label('Status KK')
                            ->options([
                                'active' => 'Aktif Berdomisili',
                                'moved' => 'Pindah Keluar Desa',
                                'dissolved' => 'Bubarkan / Pecah KK',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kk_number')
                    ->label('Nomor KK')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('head.full_name')
                    ->label('Kepala Keluarga')
                    ->placeholder('Belum ditandai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('padukuhan.name')
                    ->label('Padukuhan / Dusun')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('residents_count')
                    ->label('Jml Anggota')
                    ->counts('residents')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'moved',
                        'danger' => 'dissolved',
                    ]),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(35)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('padukuhan_id')
                    ->label('Padukuhan')
                    ->relationship('padukuhan', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'moved' => 'Pindah',
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
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}
