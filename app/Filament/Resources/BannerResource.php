<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Media & Publikasi';
    protected static ?string $navigationLabel = 'Hero Banner';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Banner Hero')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Banner')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('subtitle')
                            ->label('Subjudul / Deskripsi Singkat')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar Banner')
                            ->image()
                            ->directory('banners')
                            ->required(),

                        Forms\Components\TextInput::make('button_text')
                            ->label('Teks Tombol CTA')
                            ->placeholder('misal: Jelajahi Layanan')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('button_url')
                            ->label('URL Tujuan Tombol')
                            ->placeholder('misal: /layanan/surat')
                            ->maxLength(255),

                        Forms\Components\Select::make('text_position')
                            ->label('Posisi Teks')
                            ->options([
                                'left' => 'Kiri',
                                'center' => 'Tengah',
                                'right' => 'Kanan',
                            ])
                            ->default('left'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('text_position')
                    ->label('Posisi'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
