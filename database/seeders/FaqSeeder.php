<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja syarat mengurus surat keterangan domisili?',
                'answer' => 'Syarat mengurus surat keterangan domisili di Kalurahan Condongcatur: 1) KTP asli dan fotokopi, 2) Kartu Keluarga asli dan fotokopi, 3) Surat pengantar dari RT dan RW, 4) Mengisi formulir permohonan yang tersedia di kantor kalurahan atau bisa diunduh di website ini.',
                'category' => 'pelayanan',
                'keywords' => ['surat keterangan', 'domisili', 'syarat', 'persyaratan'],
                'sort_order' => 1,
            ],
            [
                'question' => 'Berapa lama proses pembuatan surat keterangan?',
                'answer' => 'Proses pembuatan surat keterangan di Kalurahan Condongcatur diselesaikan dalam 1 hari kerja apabila persyaratan lengkap. Untuk beberapa jenis surat yang memerlukan persetujuan lurah, maksimal 3 hari kerja.',
                'category' => 'pelayanan',
                'keywords' => ['lama', 'proses', 'waktu', 'surat keterangan'],
                'sort_order' => 2,
            ],
            [
                'question' => 'Bagaimana cara mengajukan permohonan surat secara online?',
                'answer' => 'Untuk mengajukan surat secara online: 1) Buat akun di Portal Warga, 2) Login dengan NIK dan password, 3) Pilih menu "Permohonan Surat", 4) Pilih jenis surat yang dibutuhkan, 5) Isi formulir dan upload persyaratan, 6) Kirim permohonan. Anda akan mendapat notifikasi perkembangan permohonan via email/WhatsApp.',
                'category' => 'layanan_online',
                'keywords' => ['online', 'permohonan surat', 'portal warga', 'cara'],
                'sort_order' => 3,
            ],
            [
                'question' => 'Apa jam operasional kantor kalurahan?',
                'answer' => 'Kantor Kalurahan Condongcatur beroperasi pada: Senin s/d Jumat: 07.30 - 16.00 WIB, Sabtu: 08.00 - 12.00 WIB. Tutup pada hari Minggu dan hari libur nasional.',
                'category' => 'umum',
                'keywords' => ['jam', 'operasional', 'buka', 'tutup', 'kantor'],
                'sort_order' => 4,
            ],
            [
                'question' => 'Dimana letak kantor Kalurahan Condongcatur?',
                'answer' => 'Kantor Kalurahan Condongcatur beralamat di Jl. Manggis No. 1, Condongcatur, Kecamatan Depok, Kabupaten Sleman, D.I. Yogyakarta 55283. Dapat dicapai dengan mudah menggunakan kendaraan pribadi atau transportasi umum.',
                'category' => 'umum',
                'keywords' => ['lokasi', 'alamat', 'kantor', 'dimana'],
                'sort_order' => 5,
            ],
            [
                'question' => 'Bagaimana cara mengecek status permohonan surat saya?',
                'answer' => 'Status permohonan surat dapat dicek melalui: 1) Login ke Portal Warga di website ini, 2) Pilih menu "Riwayat Permohonan", 3) Pilih permohonan yang ingin dicek. Anda juga akan mendapatkan notifikasi otomatis via email atau WhatsApp setiap ada perubahan status.',
                'category' => 'layanan_online',
                'keywords' => ['cek', 'status', 'permohonan', 'tracking'],
                'sort_order' => 6,
            ],
            [
                'question' => 'Bagaimana cara menyampaikan pengaduan atau aspirasi?',
                'answer' => 'Pengaduan dan aspirasi dapat disampaikan melalui: 1) Menu "Pengaduan" di website ini, 2) Datang langsung ke kantor kalurahan, 3) Telepon ke (0274) 881094, 4) Email ke condongcatur1946@gmail.com. Setiap pengaduan akan mendapatkan nomor tiket untuk memudahkan tracking.',
                'category' => 'pengaduan',
                'keywords' => ['pengaduan', 'aspirasi', 'laporan', 'keluhan'],
                'sort_order' => 7,
            ],
            [
                'question' => 'Apa saja program bantuan sosial yang ada di Condongcatur?',
                'answer' => 'Program bantuan sosial di Condongcatur meliputi: PKH (Program Keluarga Harapan), BPNT (Bantuan Pangan Non Tunai), BLT Dana Desa, BST (Bantuan Sosial Tunai), dan berbagai program lokal dari kalurahan. Data penerima bantuan dapat dilihat di menu Transparansi > Bantuan Sosial.',
                'category' => 'bansos',
                'keywords' => ['bantuan sosial', 'program', 'PKH', 'BPNT', 'BLT'],
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $data) {
            Faq::firstOrCreate(
                ['question' => $data['question']],
                array_merge($data, ['is_published' => true])
            );
        }
    }
}
