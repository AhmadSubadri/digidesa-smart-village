<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterTypeResource\Pages;
use App\Models\LetterType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LetterTypeResource extends Resource
{
    protected static ?string $model = LetterType::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Layanan Administrasi';

    protected static ?string $navigationLabel = 'Katalog Jenis Surat';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar Surat')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Jenis Surat')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Singkat (e.g. SKD, SKU)')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('classification_code')
                            ->label('Kode Klasifikasi Permendagri')
                            ->placeholder('e.g. 470 (Kependudukan), 510 (Usaha)')
                            ->maxLength(20),
                        Forms\Components\Select::make('approval_level')
                            ->label('Level Pengesahan Terakhir')
                            ->options([
                                'operator' => 'Staf Pelayanan',
                                'sekretaris' => 'Sekretaris Desa (Sekdes)',
                                'lurah' => 'Kepala Desa / Lurah',
                            ])
                            ->default('lurah')
                            ->required(),
                        Forms\Components\TextInput::make('estimated_days')
                            ->label('Estimasi Pengerjaan (Hari)')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        Forms\Components\TextInput::make('fee')
                            ->label('Biaya / Retribusi (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0.00),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi & Manfaat Surat')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Format & Template Dokumen')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('template_type')
                            ->label('Tipe Template')
                            ->options([
                                'blade' => 'Template Kode HTML/Blade (Bawaan Sistem)',
                                'docx' => 'Template Microsoft Word (.docx)',
                            ])
                            ->default('blade')
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('template_path')
                            ->label('View Blade Path')
                            ->placeholder('pdf.letter')
                            ->visible(fn (Forms\Get $get) => $get('template_type') === 'blade'),
                        Forms\Components\FileUpload::make('docx_template_path')
                            ->label('Unggah Berkas Template Word (.docx)')
                            ->disk('public')
                            ->directory('templates/docx')
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->helperText('Variabel tag yang didukung: ${nama}, ${nik}, ${alamat}, ${keperluan}, ${nomor_surat}, ${tanggal_surat}, ${nama_pejabat}')
                            ->visible(fn (Forms\Get $get) => $get('template_type') === 'docx')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Validasi & Persyaratan Warga')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('requires_rt_approval')
                            ->label('Wajib Pengantar RT/RW')
                            ->default(false),
                        Forms\Components\Toggle::make('needs_approval')
                            ->label('Perlu Verifikasi Admin')
                            ->default(true),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('classification_code')
                    ->label('Klasifikasi')
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Surat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('template_type')
                    ->label('Format')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'docx' => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('approval_level')
                    ->label('Pengesahan')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('template_type')
                    ->options([
                        'blade' => 'Blade PDF',
                        'docx' => 'Word .docx',
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetterTypes::route('/'),
            'create' => Pages\CreateLetterType::route('/create'),
            'edit' => Pages\EditLetterType::route('/{record}/edit'),
        ];
    }
}
