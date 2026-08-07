<?php

namespace Database\Seeders;

use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'SKD',
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan yang menyatakan bahwa seseorang berdomisili di wilayah Kalurahan Condongcatur.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Surat Pengantar RT', 'type' => 'file', 'required' => true],
                    ['label' => 'Keperluan Surat', 'type' => 'text', 'required' => true],
                ],
                'estimated_days' => 1,
                'approval_level' => 'lurah',
                'sort_order' => 1,
            ],
            [
                'code' => 'SKU',
                'name' => 'Surat Keterangan Usaha',
                'description' => 'Surat keterangan yang menyatakan bahwa pemohon memiliki usaha di wilayah Kalurahan Condongcatur.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Foto Usaha/Toko', 'type' => 'file', 'required' => true],
                    ['label' => 'Nama Usaha', 'type' => 'text', 'required' => true],
                    ['label' => 'Jenis Usaha', 'type' => 'text', 'required' => true],
                ],
                'estimated_days' => 2,
                'approval_level' => 'lurah',
                'sort_order' => 2,
            ],
            [
                'code' => 'SKKM',
                'name' => 'Surat Keterangan Kurang Mampu',
                'description' => 'Surat keterangan yang menyatakan bahwa seseorang tergolong kurang mampu secara ekonomi.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Surat Pengantar RT/RW', 'type' => 'file', 'required' => true],
                    ['label' => 'Keperluan Surat', 'type' => 'text', 'required' => true],
                    ['label' => 'Foto Rumah Tampak Depan', 'type' => 'file', 'required' => false],
                ],
                'estimated_days' => 2,
                'approval_level' => 'lurah',
                'sort_order' => 3,
            ],
            [
                'code' => 'SKL',
                'name' => 'Surat Keterangan Lahir',
                'description' => 'Surat keterangan kelahiran sebagai dasar pengurusan akte kelahiran.',
                'requirements' => [
                    ['label' => 'KTP Orang Tua', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Surat Kelahiran dari Bidan/RS', 'type' => 'file', 'required' => true],
                    ['label' => 'Buku Nikah Orang Tua', 'type' => 'file', 'required' => true],
                    ['label' => 'Nama Bayi', 'type' => 'text', 'required' => true],
                    ['label' => 'Tanggal Lahir', 'type' => 'date', 'required' => true],
                ],
                'estimated_days' => 1,
                'approval_level' => 'operator',
                'sort_order' => 4,
            ],
            [
                'code' => 'SKCK_PENGANTAR',
                'name' => 'Surat Pengantar SKCK',
                'description' => 'Surat pengantar dari kalurahan untuk keperluan pengurusan SKCK di Polsek.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Pas Foto 4x6 (2 lembar)', 'type' => 'file', 'required' => true],
                    ['label' => 'Keperluan SKCK', 'type' => 'text', 'required' => true],
                ],
                'estimated_days' => 1,
                'approval_level' => 'sekretaris',
                'sort_order' => 5,
            ],
            [
                'code' => 'SKPINDAH',
                'name' => 'Surat Keterangan Pindah',
                'description' => 'Surat keterangan untuk warga yang akan pindah keluar dari wilayah Kalurahan Condongcatur.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Alamat Tujuan Pindah', 'type' => 'text', 'required' => true],
                    ['label' => 'Alasan Pindah', 'type' => 'text', 'required' => true],
                ],
                'estimated_days' => 3,
                'approval_level' => 'lurah',
                'sort_order' => 6,
            ],
            [
                'code' => 'SKSKT',
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'description' => 'Surat untuk keperluan beasiswa, keringanan biaya pengobatan, atau fasilitas publik lainnya.',
                'requirements' => [
                    ['label' => 'KTP Asli', 'type' => 'file', 'required' => true],
                    ['label' => 'Kartu Keluarga', 'type' => 'file', 'required' => true],
                    ['label' => 'Surat Pengantar RT/RW', 'type' => 'file', 'required' => true],
                    ['label' => 'Keperluan/Tujuan', 'type' => 'text', 'required' => true],
                ],
                'estimated_days' => 1,
                'approval_level' => 'lurah',
                'sort_order' => 7,
            ],
        ];

        foreach ($types as $data) {
            LetterType::firstOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['is_active' => true, 'fee' => 0, 'needs_approval' => true])
            );
        }
    }
}
