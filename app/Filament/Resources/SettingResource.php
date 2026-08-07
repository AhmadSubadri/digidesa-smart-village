<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan Sistem';
    protected static ?string $navigationLabel = 'Pengaturan Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Website')
                    ->schema([
                        Forms\Components\TextInput::make('group')
                            ->label('Grup Pengaturan')
                            ->required(),
                        Forms\Components\TextInput::make('key')
                            ->label('Kunci (Key)')
                            ->disabled(),
                        Forms\Components\TextInput::make('label')
                            ->label('Label Display')
                            ->required(),
                        Forms\Components\Textarea::make('value')
                            ->label('Nilai / Konten Value')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')->label('Grup')->sortable(),
                Tables\Columns\TextColumn::make('label')->label('Nama Pengaturan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('key')->label('Kunci')->fontMono()->searchable(),
                Tables\Columns\TextColumn::make('value')->label('Nilai')->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')->options([
                    'general' => 'General',
                    'contact' => 'Kontak',
                    'social' => 'Sosial Media',
                    'office' => 'Jam Kerja',
                    'stats' => 'Statistik Ringkas',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
