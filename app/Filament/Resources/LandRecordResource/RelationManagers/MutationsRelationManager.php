<?php

namespace App\Filament\Resources\LandRecordResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MutationsRelationManager extends RelationManager
{
    protected static string $relationship = 'mutations';

    protected static ?string $title = 'Riwayat Mutasi Bidang Tanah';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('mutation_date')
                    ->label('Tanggal Mutasi')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('mutation_type')
                    ->label('Jenis Mutasi')
                    ->options([
                        'jual_beli' => 'Jual Beli',
                        'waris' => 'Waris / Pembagian',
                        'hibah' => 'Hibah',
                        'tukar_menukar' => 'Tukar Menukar',
                        'wakaf' => 'Wakaf',
                        'pemecahan' => 'Pemecahan Bidang',
                        'penggabungan' => 'Penggabungan Bidang',
                        'lainnya' => 'Lainnya',
                    ])
                    ->default('jual_beli')
                    ->required(),
                Forms\Components\TextInput::make('old_owner_name')
                    ->label('Nama Pemilik Lama')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('new_owner_name')
                    ->label('Nama Pemilik Baru')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('new_owner_nik')
                    ->label('NIK Pemilik Baru')
                    ->maxLength(20),
                Forms\Components\TextInput::make('area_transferred_m2')
                    ->label('Luas Dimutasikan (m²)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('remaining_area_m2')
                    ->label('Sisa Luas Bidang (m²)')
                    ->numeric(),
                Forms\Components\TextInput::make('deed_number')
                    ->label('Nomor Akta / Surat Bukti')
                    ->maxLength(100),
                Forms\Components\TextInput::make('notary_name')
                    ->label('Nama PPAT / Pejabat')
                    ->maxLength(100),
                Forms\Components\Textarea::make('notes')
                    ->label('Keterangan / Batas Tanah')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('document_scan_path')
                    ->label('Scan Dokumen Akta / Leter C')
                    ->disk('public')
                    ->directory('land_documents')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mutation_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mutation_type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\TextColumn::make('old_owner_name')
                    ->label('Dari (Lama)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_owner_name')
                    ->label('Kepada (Baru)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area_transferred_m2')
                    ->label('Luas (m²)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deed_number')
                    ->label('No. Akta')
                    ->placeholder('-'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Catat Mutasi Baru'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
