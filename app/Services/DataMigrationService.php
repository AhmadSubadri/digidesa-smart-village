<?php

namespace App\Services;

use App\Models\Family;
use App\Models\Padukuhan;
use App\Models\Resident;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataMigrationService
{
    /**
     * Import data kependudukan dari file Excel SIAK Disdukcapil (Format F-1.01).
     */
    public function importSiakExcel(UploadedFile $file): array
    {
        $rows = Excel::toArray([], $file);
        $sheet = $rows[0] ?? [];

        if (count($sheet) < 2) {
            return ['status' => false, 'message' => 'File Excel kosong atau format tidak sesuai.'];
        }

        // Header berada di baris 1 (index 0)
        $header = array_map(fn($col) => strtolower(trim((string)$col)), $sheet[0]);

        $colNik = array_search('nik', $header);
        $colKk = array_search('no_kk', $header) !== false ? array_search('no_kk', $header) : array_search('nokk', $header);
        $colNama = array_search('nama', $header) !== false ? array_search('nama', $header) : array_search('nama_lengkap', $header);
        $colJk = array_search('jk', $header) !== false ? array_search('jk', $header) : array_search('jenis_kelamin', $header);
        $colTempatLahir = array_search('tempat_lahir', $header);
        $colTglLahir = array_search('tanggal_lahir', $header) !== false ? array_search('tanggal_lahir', $header) : array_search('tgl_lahir', $header);
        $colAgama = array_search('agama', $header);
        $colPekerjaan = array_search('pekerjaan', $header);
        $colAlamat = array_search('alamat', $header);
        $colRt = array_search('rt', $header);
        $colRw = array_search('rw', $header);
        $colDusun = array_search('dusun', $header) !== false ? array_search('dusun', $header) : array_search('padukuhan', $header);

        if ($colNik === false || $colNama === false) {
            return ['status' => false, 'message' => 'Kolom NIK dan Nama Lengkap wajib ada di baris pertama Excel.'];
        }

        $imported = 0;
        $familiesCount = 0;
        $dataRows = array_slice($sheet, 1);

        DB::beginTransaction();
        try {
            foreach ($dataRows as $row) {
                $nik = trim((string)($row[$colNik] ?? ''));
                $nama = trim((string)($row[$colNama] ?? ''));

                if (empty($nik) || empty($nama)) {
                    continue;
                }

                $kk = $colKk !== false ? trim((string)($row[$colKk] ?? '')) : null;
                $gender = 'L';
                if ($colJk !== false) {
                    $rawJk = strtoupper(trim((string)($row[$colJk] ?? '')));
                    $gender = (str_starts_with($rawJk, 'P') || str_contains($rawJk, 'PEREMPUAN')) ? 'P' : 'L';
                }

                $dusunName = $colDusun !== false ? trim((string)($row[$colDusun] ?? '')) : 'Pusat Desa';
                $padukuhan = !empty($dusunName)
                    ? Padukuhan::firstOrCreate(['name' => $dusunName], ['code' => strtoupper(substr($dusunName, 0, 3))])
                    : null;

                // Buat / ambil data keluarga (KK)
                $family = null;
                if (!empty($kk)) {
                    $family = Family::firstOrCreate(
                        ['kk_number' => $kk],
                        [
                            'address' => $colAlamat !== false ? ($row[$colAlamat] ?? null) : null,
                            'rt' => $colRt !== false ? ($row[$colRt] ?? null) : null,
                            'rw' => $colRw !== false ? ($row[$colRw] ?? null) : null,
                            'padukuhan_id' => $padukuhan?->id,
                            'status' => 'active',
                        ]
                    );
                    $familiesCount++;
                }

                // Buat data penduduk
                Resident::updateOrCreate(
                    ['nik' => $nik],
                    [
                        'kk_number' => $kk,
                        'full_name' => $nama,
                        'birth_place' => $colTempatLahir !== false ? ($row[$colTempatLahir] ?? null) : null,
                        'birth_date' => $colTglLahir !== false ? ($row[$colTglLahir] ?? null) : null,
                        'gender' => $gender,
                        'religion' => $colAgama !== false ? ($row[$colAgama] ?? 'Islam') : 'Islam',
                        'occupation' => $colPekerjaan !== false ? ($row[$colPekerjaan] ?? 'Belum/Tidak Bekerja') : null,
                        'address' => $colAlamat !== false ? ($row[$colAlamat] ?? null) : null,
                        'rt' => $colRt !== false ? ($row[$colRt] ?? null) : null,
                        'rw' => $colRw !== false ? ($row[$colRw] ?? null) : null,
                        'padukuhan_id' => $padukuhan?->id,
                        'family_id' => $family?->id,
                        'citizenship' => 'WNI',
                        'status' => 'active',
                    ]
                );

                $imported++;
            }

            DB::commit();

            return [
                'status' => true,
                'imported_residents' => $imported,
                'imported_families' => $familiesCount,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Gagal memproses file Excel: ' . $e->getMessage(),
            ];
        }
    }
}
