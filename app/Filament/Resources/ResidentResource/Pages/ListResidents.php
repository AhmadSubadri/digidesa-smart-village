<?php

namespace App\Filament\Resources\ResidentResource\Pages;

use App\Filament\Resources\ResidentResource;
use App\Services\DataMigrationService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Http\UploadedFile;

class ListResidents extends ListRecords
{
    protected static string $resource = ResidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import_siak')
                ->label('Import SIAK / Excel (1-Click)')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Pilih Berkas Excel Kependudukan (.xlsx / .csv)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->helperText('Format standar SIAK Disdukcapil (F-1.01). Kolom wajib baris pertama: NIK, Nama Lengkap, No_KK, Jenis_Kelamin.')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $uploadedPath = storage_path('app/public/' . $data['file']);
                    if (!file_exists($uploadedPath)) {
                        Notification::make()->title('Berkas tidak ditemukan.')->danger()->send();
                        return;
                    }

                    $uploadedFile = new UploadedFile($uploadedPath, basename($uploadedPath));
                    $result = app(DataMigrationService::class)->importSiakExcel($uploadedFile);

                    if ($result['status']) {
                        Notification::make()
                            ->title('Migrasi Data Selesai!')
                            ->body("Berhasil mengimpor {$result['imported_residents']} data penduduk dan {$result['imported_families']} kepala keluarga.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Migrasi Gagal')
                            ->body($result['message'] ?? 'Terjadi kesalahan saat memproses data.')
                            ->danger()
                            ->send();
                    }
                }),

            Actions\CreateAction::make()->label('Tambah Penduduk'),
        ];
    }
}
