<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterRegisterResource\Pages;
use App\Models\LetterRegister;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LetterRegisterResource extends Resource
{
    protected static ?string $model = LetterRegister::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Layanan Administrasi';

    protected static ?string $navigationLabel = 'Buku Agenda Surat (Permendagri)';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Entri Buku Register Surat')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('register_type')
                            ->label('Jenis Agenda')
                            ->options([
                                'incoming' => 'Surat Masuk',
                                'outgoing' => 'Surat Keluar',
                            ])
                            ->default('outgoing')
                            ->required(),
                        Forms\Components\DatePicker::make('letter_date')
                            ->label('Tanggal Surat')
                            ->default(now())
                            ->required(),
                        Forms\Components\TextInput::make('letter_number')
                            ->label('Nomor Surat')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('classification_code')
                            ->label('Kode Klasifikasi')
                            ->placeholder('e.g. 470')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('sender_or_recipient')
                            ->label('Pengirim / Tujuan Surat')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('subject')
                            ->label('Perihal Surat')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\Textarea::make('summary')
                            ->label('Ringkasan Isi Surat')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('document_file_path')
                            ->label('Berkas Dokumen / PDF Surat')
                            ->disk('public')
                            ->directory('registers')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('register_type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'incoming' => 'info',
                        'outgoing' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'incoming' => 'Surat Masuk',
                        'outgoing' => 'Surat Keluar',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('letter_number')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('letter_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender_or_recipient')
                    ->label('Pengirim / Tujuan')
                    ->searchable()
                    ->lineClamp(1),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Perihal')
                    ->searchable()
                    ->lineClamp(1),
                Tables\Columns\TextColumn::make('classification_code')
                    ->label('Klasifikasi')
                    ->badge()
                    ->placeholder('-'),
            ])
            ->defaultSort('letter_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('register_type')
                    ->label('Filter Jenis')
                    ->options([
                        'incoming' => 'Surat Masuk',
                        'outgoing' => 'Surat Keluar',
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
            'index' => Pages\ListLetterRegisters::route('/'),
            'create' => Pages\CreateLetterRegister::route('/create'),
            'edit' => Pages\EditLetterRegister::route('/{record}/edit'),
        ];
    }
}
