<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuickLinkResource\Pages;
use App\Models\QuickLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuickLinkResource extends Resource
{
    protected static ?string $model = QuickLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Media & Publikasi';
    protected static ?string $navigationLabel = 'Akses Cepat (Quick Links)';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akses Cepat Beranda')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Layanan / Menu')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(2)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('url')
                            ->label('URL / Route Tujuan')
                            ->required()
                            ->placeholder('misal: /layanan/surat atau https://...')
                            ->maxLength(255),

                        Forms\Components\Select::make('icon')
                            ->label('Ikon')
                            ->options([
                                'document-text' => '📄 Dokumen / Surat',
                                'users' => '👥 Kependudukan / Warga',
                                'banknotes' => '💰 Keuangan / APBDes',
                                'chat-bubble-left-right' => '💬 Pengaduan / Aspirasi',
                                'photo' => '🖼️ Galeri / Foto',
                                'calendar' => '📅 Agenda / Acara',
                                'folder-arrow-down' => '📂 PPID Dokumen',
                                'map-pin' => '📍 Peta Wilayah',
                            ])
                            ->default('document-text')
                            ->required(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(40),
                Tables\Columns\TextColumn::make('url')->label('URL'),
                Tables\Columns\TextColumn::make('icon')->label('Ikon'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
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
            'index' => Pages\ListQuickLinks::route('/'),
            'create' => Pages\CreateQuickLink::route('/create'),
            'edit' => Pages\EditQuickLink::route('/{record}/edit'),
        ];
    }
}
