<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first();
        $berita = Category::where('slug', 'berita')->first();
        $kegiatan = Category::where('slug', 'kegiatan')->first();
        $pemerintahan = Category::where('slug', 'pemerintahan')->first();

        $articles = [
            [
                'title' => 'Musyawarah Kalurahan Condongcatur 2025: Penetapan RKP Kalurahan',
                'excerpt' => 'Kalurahan Condongcatur mengadakan Musyawarah Kalurahan untuk menetapkan Rencana Kerja Pemerintah Kalurahan tahun 2025 dengan melibatkan seluruh komponen masyarakat.',
                'content' => '<p>Musyawarah Kalurahan (Muskal) Condongcatur tahun 2025 telah resmi digelar di Balai Kalurahan Condongcatur. Acara yang dihadiri oleh lebih dari 200 warga ini membahas program pembangunan yang akan dilaksanakan sepanjang tahun 2025.</p><p>Lurah Condongcatur dalam sambutannya menyampaikan bahwa musyawarah ini merupakan wujud nyata dari demokrasi desa dalam menentukan arah pembangunan bersama.</p><p>Beberapa program prioritas yang disepakati antara lain: pembangunan infrastruktur jalan, peningkatan layanan kesehatan, dan pemberdayaan UMKM lokal.</p>',
                'status' => 'published',
                'is_featured' => true,
                'is_headline' => true,
                'category_id' => $pemerintahan?->id,
                'published_at' => now()->subDays(3),
                'view_count' => 245,
                'reading_time' => 3,
            ],
            [
                'title' => 'Condongcatur Raih Predikat Kalurahan Mandiri dalam IDM 2024',
                'excerpt' => 'Berdasarkan hasil penilaian Indeks Desa Membangun (IDM) tahun 2024, Kalurahan Condongcatur berhasil mempertahankan predikat Desa Mandiri dengan skor 0.8756.',
                'content' => '<p>Kabar membanggakan datang dari Kalurahan Condongcatur. Berdasarkan penetapan Indeks Desa Membangun (IDM) tahun 2024 oleh Kementerian Desa, Condongcatur kembali meraih predikat tertinggi yaitu Desa Mandiri.</p><p>Skor IDM Condongcatur tahun ini mencapai 0.8756, meningkat dari tahun sebelumnya yang mencapai 0.8512. Peningkatan ini didorong oleh tiga indikator utama yaitu Indeks Ketahanan Ekonomi (IKE), Indeks Ketahanan Lingkungan (IKL), dan Indeks Ketahanan Sosial (IKS).</p>',
                'status' => 'published',
                'is_featured' => true,
                'category_id' => $berita?->id,
                'published_at' => now()->subDays(7),
                'view_count' => 412,
                'reading_time' => 4,
            ],
            [
                'title' => 'Peluncuran Program Posyandu Digital Condongcatur',
                'excerpt' => 'Dalam rangka meningkatkan kualitas layanan kesehatan, Condongcatur meluncurkan program Posyandu Digital yang memudahkan pemantauan kesehatan balita dan ibu hamil.',
                'content' => '<p>Kalurahan Condongcatur bersama Puskesmas Depok II resmi meluncurkan program Posyandu Digital pada awal bulan ini. Program inovatif ini memanfaatkan teknologi informasi untuk memantau pertumbuhan balita dan kesehatan ibu hamil secara lebih efektif.</p><p>Dengan Posyandu Digital, kader dapat langsung memasukkan data penimbangan dan pemeriksaan ke dalam sistem, sehingga memudahkan monitoring oleh petugas kesehatan.</p>',
                'status' => 'published',
                'category_id' => $kegiatan?->id,
                'published_at' => now()->subDays(14),
                'view_count' => 189,
                'reading_time' => 3,
            ],
            [
                'title' => 'Kegiatan Gotong Royong Pembersihan Sungai Gajahwong',
                'excerpt' => 'Ratusan warga Condongcatur bersama perangkat kalurahan bergotong royong membersihkan aliran Sungai Gajahwong dari sampah dan eceng gondok.',
                'content' => '<p>Semangat gotong royong kembali ditunjukkan oleh warga Kalurahan Condongcatur. Pada hari Minggu pagi, ratusan warga bersama perangkat kalurahan, Babinsa, dan Bhabinkamtibmas turun bersama untuk membersihkan aliran Sungai Gajahwong.</p><p>Kegiatan ini merupakan program rutin bulanan yang diprakarsai oleh Karang Taruna setempat bekerja sama dengan pemerintah kalurahan.</p>',
                'status' => 'published',
                'category_id' => $kegiatan?->id,
                'published_at' => now()->subDays(21),
                'view_count' => 156,
                'reading_time' => 2,
            ],
            [
                'title' => 'Festival UMKM Condongcatur 2025: Wadah Promosi Produk Lokal',
                'excerpt' => 'Lebih dari 50 pelaku UMKM dari 18 padukuhan berpartisipasi dalam Festival UMKM Condongcatur 2025 yang berlangsung selama tiga hari.',
                'content' => '<p>Festival UMKM Condongcatur 2025 resmi dibuka oleh Lurah Condongcatur di Lapangan Condongcatur. Festival yang dihadiri ribuan pengunjung ini menampilkan berbagai produk unggulan dari 18 padukuhan yang ada di Condongcatur.</p><p>Beragam produk dipamerkan mulai dari kuliner khas, kerajinan tangan, fashion lokal, hingga produk pertanian organik. Festival ini juga dimeriahkan oleh pertunjukan seni budaya dari berbagai kelompok seni yang ada di Condongcatur.</p>',
                'status' => 'published',
                'is_featured' => true,
                'category_id' => $berita?->id,
                'published_at' => now()->subDays(28),
                'view_count' => 523,
                'reading_time' => 4,
            ],
        ];

        foreach ($articles as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']);
            Article::firstOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'slug' => $slug,
                    'author_id' => $author?->id,
                    'meta_title' => $data['title'],
                    'meta_description' => $data['excerpt'],
                ])
            );
        }
    }
}
