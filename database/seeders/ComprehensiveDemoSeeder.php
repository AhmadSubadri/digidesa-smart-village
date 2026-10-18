<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\LandMutation;
use App\Models\LandRecord;
use App\Models\LetterRegister;
use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Models\Padukuhan;
use App\Models\PublicDocument;
use App\Models\Resident;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\User;
use App\Models\VillageAsset;
use App\Services\LetterPdfService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComprehensiveDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $adminId = $user ? $user->id : 1;

        // 1. Pastikan Wilayah Padukuhan / RT / RW Ada
        $padukuhan = Padukuhan::firstOrCreate(
            ['name' => 'Dusun Krajan'],
            ['code' => 'KRAJAN', 'head_name' => 'Sutrisno', 'area_size' => 120.5, 'sort_order' => 1]
        );

        $rw = Rw::firstOrCreate(
            ['padukuhan_id' => $padukuhan->id, 'number' => '01'],
            ['head_name' => 'Bambang Supriyanto']
        );

        $rt = Rt::firstOrCreate(
            ['padukuhan_id' => $padukuhan->id, 'rw_id' => $rw->id, 'number' => '01'],
            ['head_name' => 'Agus Setiawan']
        );

        // 2. Sample Kartu Keluarga & Penduduk
        $kk1 = Family::firstOrCreate(
            ['address' => 'Jl. Mawar No. 12, RT 01 / RW 01'],
            [
                'kk_number' => '3404071508900001',
                'padukuhan_id' => $padukuhan->id,
                'rt_id' => $rt->id,
                'rw_id' => $rw->id,
                'economic_status' => 'sejahtera',
                'status' => 'active',
            ]
        );

        $resident1 = Resident::firstOrCreate(
            ['address' => 'Jl. Mawar No. 12, RT 01 / RW 01', 'full_name' => 'Budi Santoso, S.T.'],
            [
                'nik' => '3404071203850001',
                'kk_number' => '3404071508900001',
                'family_id' => $kk1->id,
                'padukuhan_id' => $padukuhan->id,
                'rt_id' => $rt->id,
                'rw_id' => $rw->id,
                'gender' => 'L',
                'birth_place' => 'Sleman',
                'birth_date' => '1985-03-12',
                'religion' => 'islam',
                'education_level' => 's1',
                'occupation' => 'Wiraswasta',
                'marital_status' => 'kawin',
                'is_head_of_family' => true,
                'citizenship' => 'WNI',
                'status' => 'active',
            ]
        );

        // Akun Login Demo Layanan Mandiri Warga
        \App\Models\WargaUser::firstOrCreate(
            ['nik' => '3404071203850001'],
            [
                'resident_id' => $resident1->id,
                'name' => 'Budi Santoso, S.T.',
                'email' => 'budi.santoso@warga.desa.id',
                'phone' => '081234567890',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_verified' => true,
                'verified_at' => now(),
                'is_active' => true,
            ]
        );

        // 3. Sample Buku Tanah & Letter C (Permendagri No. 47/2016)
        $land1 = LandRecord::firstOrCreate(
            ['kohir_number' => '0128', 'persil_number' => '14-A'],
            [
                'padukuhan_id' => $padukuhan->id,
                'land_type' => 'pekarangan',
                'ownership_type' => 'hak_milik',
                'owner_name' => 'Budi Santoso, S.T.',
                'owner_resident_id' => $resident1->id,
                'area_m2' => 850.00,
                'land_class' => 'D.II',
                'address' => 'Jl. Mawar No. 12, RT 01 / RW 01',
                'notes' => 'Peralihan hak waris dari almarhum Martodiharjo tahun 2021',
                'status' => 'active',
            ]
        );

        // Sample Mutasi Tanah
        LandMutation::firstOrCreate(
            ['land_record_id' => $land1->id, 'mutation_type' => 'waris'],
            [
                'mutation_date' => '2021-08-15',
                'old_owner_name' => 'Alm. Martodiharjo (Ayah)',
                'new_owner_name' => 'Budi Santoso, S.T.',
                'new_owner_nik' => '3404071203850001',
                'area_transferred_m2' => 850.00,
                'remaining_area_m2' => 850.00,
                'deed_number' => 'SKW-2021/08/DESA',
                'notary_name' => 'Sekretaris Desa',
                'notes' => 'Berdasarkan Surat Keterangan Ahli Waris Desa',
            ]
        );

        // Tanah Kas Desa
        LandRecord::firstOrCreate(
            ['kohir_number' => '0001', 'persil_number' => '01-TKD'],
            [
                'padukuhan_id' => $padukuhan->id,
                'land_type' => 'pekarangan',
                'ownership_type' => 'tanah_desa',
                'owner_name' => 'Pemerintah Desa',
                'area_m2' => 3500.00,
                'land_class' => 'D.I',
                'address' => 'Kompleks Kantor Balai Desa',
                'notes' => 'Aset Tanah Asal Usul Desa bersertifikat Hak Pakai Pemerintah Desa',
                'status' => 'active',
            ]
        );

        // 4. Sample Inventaris Aset Desa (Permendagri No. 1/2016)
        VillageAsset::firstOrCreate(
            ['asset_code' => '01.01.01.001'],
            [
                'name' => 'Tanah Kantor dan Balai Desa',
                'category' => 'tanah',
                'description' => 'Bidang tanah kompleks balai kantor pemerintahan desa seluas 3.500 m2',
                'acquisition_date' => '1950-01-01',
                'acquisition_value' => 1500000000.00,
                'current_condition' => 'baik',
                'location' => 'Pusat Pemerintahan Desa',
                'quantity' => 1,
                'unit' => 'Bidang',
                'source_fund' => 'Kekayaan Asli Desa',
                'responsible_person' => 'Kaur Tata Usaha & Umum',
            ]
        );

        VillageAsset::firstOrCreate(
            ['asset_code' => '02.03.01.005'],
            [
                'name' => 'Mobil Ambulans / Siaga Desa APV',
                'category' => 'kendaraan',
                'description' => 'Kendaraan operasional tanggap darurat dan siaga kesehatan warga desa (Nomor Polisi: AB 1234 XY)',
                'acquisition_date' => '2023-04-10',
                'acquisition_value' => 245000000.00,
                'current_condition' => 'baik',
                'location' => 'Garasi Balai Desa',
                'quantity' => 1,
                'unit' => 'Unit',
                'source_fund' => 'APBDes (Dana Desa / ADD)',
                'responsible_person' => 'Kaur Pelayanan & Relawan Siaga',
            ]
        );

        VillageAsset::firstOrCreate(
            ['asset_code' => '03.01.01.002'],
            [
                'name' => 'Gedung Serbaguna & Balai Pertemuan',
                'category' => 'bangunan',
                'description' => 'Gedung balai pertemuan warga, rembug desa, dan kegiatan olahraga',
                'acquisition_date' => '2022-11-20',
                'acquisition_value' => 480000000.00,
                'current_condition' => 'baik',
                'location' => 'Kompleks Balai Desa',
                'quantity' => 1,
                'unit' => 'Unit',
                'source_fund' => 'Bantuan Pemkab',
                'responsible_person' => 'Kasi Kesejahteraan',
            ]
        );

        // 5. Sample Regulasi Desa (Perdes & Kepkades)
        PublicDocument::firstOrCreate(
            ['title' => 'Peraturan Desa Nomor 1 Tahun 2026 tentang Rencana Kerja Pemerintah Desa (RKPDes) Tahun 2026'],
            [
                'slug' => 'perdes-rkpdes-2026',
                'category' => 'rkp_kalurahan',
                'description' => 'Dokumen perencanaan tahunan desa yang memuat arah kebijakan pembangunan dan pemberdayaan masyarakat.',
                'file_path' => 'documents/public/sample_perdes.pdf',
                'fiscal_year' => 2026,
                'uploaded_by' => $adminId,
                'is_published' => true,
                'download_count' => 45,
            ]
        );

        PublicDocument::firstOrCreate(
            ['title' => 'Peraturan Desa Nomor 2 Tahun 2026 tentang Anggaran Pendapatan dan Belanja Desa (APBDes) TA 2026'],
            [
                'slug' => 'perdes-apbdes-2026',
                'category' => 'laporan_keuangan',
                'description' => 'Keterbukaan informasi publik rincian alokasi Dana Desa, ADD, Pendapatan Asli Desa, dan pos belanja desa tahun 2026.',
                'file_path' => 'documents/public/sample_apbdes.pdf',
                'fiscal_year' => 2026,
                'uploaded_by' => $adminId,
                'is_published' => true,
                'download_count' => 128,
            ]
        );

        // 6. Sample Surat Resmi Terbit (Permendagri)
        $skdType = LetterType::where('code', 'SKD')->first() ?? LetterType::first();
        if ($skdType) {
            $sampleToken = 'VERIF-DEMO-SAMPLE-2026';
            $req = LetterRequest::firstOrCreate(
                ['request_number' => 'REQ-' . date('Ymd') . '-0001'],
                [
                    'letter_type_id' => $skdType->id,
                    'resident_id' => $resident1->id,
                    'status' => 'completed',
                    'form_data' => [
                        'purpose' => 'Persyaratan Kelengkapan Administrasi Bank & NPWP',
                        'applicant_name' => $resident1->full_name,
                        'nik' => $resident1->nik,
                        'phone' => '081234567890',
                    ],
                    'qr_code_token' => $sampleToken,
                    'notes' => 'Permohonan lengkap dan telah divalidasi oleh pamong desa',
                    'completed_at' => now(),
                    'signed_at' => now(),
                    'signed_by' => $adminId,
                    'wa_notification_sent' => true,
                ]
            );

            // Generate nomor surat dan register jika belum ada
            if (empty($req->letter_number)) {
                try {
                    app(LetterPdfService::class)->generatePdf($req);
                } catch (\Throwable $e) {
                    $req->update([
                        'letter_number' => '470/001/' . setting('village_code', '34.04.07.2001') . '/' . Carbon::now()->format('m') . '/' . Carbon::now()->format('Y'),
                    ]);
                }
            }
        }
    }
}
