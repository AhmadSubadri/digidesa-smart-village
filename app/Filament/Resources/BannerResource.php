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

                        Forms\Components\Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'image' => 'Foto / Gambar (JPG/PNG/WebP)',
                                'video' => 'Video File Lokal (MP4/WebM)',
                                'youtube' => 'Video YouTube URL',
                            ])
                            ->default('image')
                            ->live()
                            ->required(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label(fn (Forms\Get $get) => $get('media_type') === 'image' ? 'Gambar Banner' : 'Poster / Cover Gambar (Fallback)')
                            ->image()
                            ->directory('banners')
                            ->required(fn (Forms\Get $get) => $get('media_type') === 'image')
                            ->helperText('Disarankan rasio 16:9 atau 4:3 resolusi minimal 1280x720.'),

                        Forms\Components\FileUpload::make('video_path')
                            ->label('File Video (MP4 / WebM)')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->directory('banners/videos')
                            ->maxSize(20480) // 20MB
                            ->visible(fn (Forms\Get $get) => $get('media_type') === 'video')
                            ->required(fn (Forms\Get $get) => $get('media_type') === 'video')
                            ->helperText('Maksimal ukuran file 20 MB.'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Link / URL YouTube')
                            ->placeholder('misal: https://www.youtube.com/watch?v=...')
                            ->url()
                            ->visible(fn (Forms\Get $get) => $get('media_type') === 'youtube')
                            ->required(fn (Forms\Get $get) => $get('media_type') === 'youtube')
                            ->helperText('Masukkan tautan video YouTube resmi kalurahan.'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('cta_text')
                                    ->label('Teks Tombol Aksi (CTA)')
                                    ->placeholder('misal: Jelajahi Layanan')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('cta_url')
                                    ->label('URL Tujuan Tombol')
                                    ->placeholder('misal: /layanan/surat')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
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
                                    ->label('Aktifkan Banner')
                                    ->default(true)
                                    ->inline(false),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Cover'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(35),
                Tables\Columns\BadgeColumn::make('media_type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'video' => 'Video MP4',
                        'youtube' => 'YouTube',
                        default => 'Gambar',
                    })
                    ->colors([
                        'primary' => 'image',
                        'success' => 'video',
                        'danger' => 'youtube',
                    ]),
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
