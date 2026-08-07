<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmResource\Pages;
use App\Models\Umkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Potensi & Ekonomi';
    protected static ?string $navigationLabel = 'Katalog UMKM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi UMKM')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama UMKM / Usaha')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\TextInput::make('owner_name')
                            ->label('Nama Pemilik')
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'kuliner' => 'Kuliner & Makanan',
                                'kerajinan' => 'Kerajinan & Craft',
                                'fashion' => 'Fashion & Pakaian',
                                'jasa' => 'Jasa & Layanan',
                                'pertanian' => 'Pertanian & Agrobisnis',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. WhatsApp / HP'),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Usaha'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Produk / Usaha')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan ke Website')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama UMKM')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('owner_name')->label('Pemilik')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon'),
                Tables\Columns\IconColumn::make('is_published')->label('Publik')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options([
                    'kuliner' => 'Kuliner',
                    'kerajinan' => 'Kerajinan',
                    'fashion' => 'Fashion',
                    'jasa' => 'Jasa',
                    'pertanian' => 'Pertanian',
                ]),
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
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}
