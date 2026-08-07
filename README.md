# 🏛️ DigiDesa — Smart Village Information System v2.0

> **Platform Sistem Informasi Desa & Portal Layanan Mandiri Digital Terpadu**.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3.x-FDAE4B?style=for-the-badge&logo=laravel)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.style=for-the-badge)](#lisensi)

---

## 📌 Ikhtisar Sistem

**DigiDesa (Smart Village System v2.0)** adalah platform web terpadu modern yang dirancang untuk mewujudkan transparansi tata kelola pemerintahan desa, efisiensi pelayanan administrasi kependudukan mandiri bagi warga, penyajian publikasi berita, serta potensi ekonomi desa secara efisien dan aman.

Seluruh data identitas desa (Nama Desa/Kalurahan, Kecamatan/Kapanewon, Kabupaten, Logo, Kontak, Jam Kerja, hingga Alamat) bersifat **100% Dinamis** dan dapat dikelola secara fleksibel melalui Panel Admin.

---

## ✨ Fitur Utama

### 🌐 1. Portal Informasi Publik & Beranda Dinamis
- **Hero Swiper Banner**: Slider pengumuman & berita utama.
- **Running Text Ticker**: Pengumuman penting berjalan secara real-time.
- **Quick Links Grid**: Akses cepat ke layanan prioritas warga.
- **Berita & Artikel**: Fitur pencarian, filter kategori, estimasi waktu baca, serta tombol *share* ke WhatsApp/Sosmed.
- **Agenda Kegiatan & Pengumuman**: Jadwal acara desa & modal popup pengumuman *urgent*.
- **Galeri Dokumentasi**: Album foto kegiatan desa.
- **PPID Dokumen Publik**: Transparansi publikasi dokumen desa dengan fitur unduh PDF.

### 👤 2. Portal Warga & Layanan Mandiri Digital
- **Autentikasi NIK E-KTP**: Login & Pendaftaran mandiri warga berbasis NIK (16 Digit).
- **Form Permohonan Surat Online**: Pengajuan Surat Keterangan Domisili (SKD), Usaha (SKU), Tidak Mampu (SKTM), dll. dengan pengunggahan berkas persyaratan.
- **Penerbitan Surat PDF & TTE QR Code**: Generator otomatis dokumen PDF ber-Kop Resmi Desa, Stempel Digital, serta **QR Code Verifikasi Keabsahan Surat** (`/layanan/verifikasi/{token}`).
- **Tracking Status Surat**: Pemantauan progres surat secara real-time (Pending ➔ Processing ➔ Approved ➔ Completed).

### 📊 3. Data, Visualisasi, & Transparansi
- **Statistik Kependudukan Interaktif**: Visualisasi **ApexCharts** untuk komposisi Jenis Kelamin & Pyramida Kelompok Usia.
- **Peta Interaktif Leaflet.js**: Peta spasial batas wilayah dusun/padukuhan, lokasi UMKM, dan objek wisata.
- **IDM & SDGs Dashboard**: Pemantauan skor Indeks Desa Membangun (Status Desa Mandiri) dan 18 Goals SDGs Desa.
- **Transparansi APBDes & Pembangunan**: Rincian Anggaran Pendapatan & Belanja Desa serta data progres proyek fisik.

### 📣 4. Layanan Pengaduan & Tamu Digital
- **Pengaduan Online Warga**: Pelaporan masalah publik dengan nomor tiket unik (`ADU-XXXX`).
- **Buku Tamu Digital**: Pencatatan kehadiran dan maksud kunjungan tamu kantor desa.

### ⚙️ 5. Admin Panel Filament 3
- Dashboard statistik real-time dengan widget ringkasan permohonan surat & pengaduan.
- Manajemen CRUD lengkap untuk Berita, Pengumuman, Agenda, Pamong Desa, UMKM, Pengaduan, dan Pengaturan Website.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
| --- | --- |
| **Framework Backend** | Laravel 12.x (PHP 8.2+) |
| **Admin Panel** | Filament v3 |
| **Frontend UI** | Blade Templating + Livewire v3 + Alpine.js |
| **Styling & Design System** | Tailwind CSS v4 (Custom Design Tokens) |
| **Database** | MySQL 8.0 / MariaDB (Laragon Compatible) |
| **Grafik & Visualisasi** | ApexCharts.js + Leaflet.js |
| **PDF Generator** | DomPDF |
| **Icons & Typography** | Heroicons + Google Fonts (*Plus Jakarta Sans* & *Inter*) |

---

## 🚀 Panduan Instalasi Lokal

### Prasyarat
- PHP 8.2+
- Composer 2.x
- Node.js 20+ & NPM
- MySQL Database / Laragon

### Langkah-langkah

1. **Clone Repository**
   ```bash
   git clone https://github.com/USERNAME/digidesa-smart-village.git
   cd digidesa-smart-village
   ```

2. **Install Dependensi PHP & Node**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin `.env.example` ke `.env` dan atur koneksi database:
   ```bash
   cp .env.example .env
   ```
   Edit `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=digidesa_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key & Storage Link**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

5. **Migrasi Database & Seeder Data Awal**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Aset Frontend**
   ```bash
   npm run build
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```

   Akses aplikasi di browser:
   - **Website Publik:** `http://127.0.0.1:8000`
   - **Portal Warga:** `http://127.0.0.1:8000/warga/login`
   - **Panel Admin:** `http://127.0.0.1:8000/admin` *(Email: `admin@digidesa.id` | Password: `Admin@1234`)*

---

## 🔐 Keamanan & Enkripsi Data

- Data kependudukan sensitif (NIK, Nomor KK, Nama Warga) di-enkripsi di tingkat database menggunakan `Crypt::encryptString()` sesuai standar perlindungan data pribadi.
- Proteksi CSRF, Sanitasi Input XSS, Enkripsi Kata Sandi Bcrypt/Argon2.
- Pemisahan guard autentikasi antara Admin (`web`) dan Warga (`warga`).

---

## 📄 Lisensi

Proyek ini dilesensikan di bawah [MIT License](LICENSE).
