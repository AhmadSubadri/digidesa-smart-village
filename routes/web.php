<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GovController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TransparencyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PotentialController;
use App\Http\Controllers\Warga\AuthController as WargaAuthController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\LetterController;
use Illuminate\Support\Facades\Route;

// ============================================================
//  PUBLIC ROUTES
// ============================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil Desa
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/visi-misi', [ProfileController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/sejarah', [ProfileController::class, 'sejarah'])->name('sejarah');
    Route::get('/geografis', [ProfileController::class, 'geografis'])->name('geografis');
    Route::get('/demografi', [ProfileController::class, 'demografi'])->name('demografi');
});

// Pemerintahan
Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
    Route::get('/struktur', [GovController::class, 'struktur'])->name('struktur');
    Route::get('/perangkat', [GovController::class, 'perangkat'])->name('perangkat');
    Route::get('/lembaga', [GovController::class, 'lembaga'])->name('lembaga');
});

// Berita & Artikel
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/kategori/{slug}', [ArticleController::class, 'kategori'])->name('kategori');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('show');
});

// Agenda Kegiatan
Route::prefix('agenda')->name('agenda.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{slug}', [EventController::class, 'show'])->name('show');
});

// Pengumuman
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/{id}', [AnnouncementController::class, 'show'])->name('show');
});

// Galeri
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});

// Statistik & Data
Route::prefix('statistik')->name('statistik.')->group(function () {
    Route::get('/kependudukan', [StatisticController::class, 'kependudukan'])->name('kependudukan');
    Route::get('/wilayah', [StatisticController::class, 'wilayah'])->name('wilayah');
    Route::get('/idm', [StatisticController::class, 'idm'])->name('idm');
    Route::get('/sdgs', [StatisticController::class, 'sdgs'])->name('sdgs');
    // API endpoints for charts
    Route::get('/api/kependudukan', [StatisticController::class, 'apiKependudukan'])->name('api.kependudukan');
    Route::get('/api/wilayah', [StatisticController::class, 'apiWilayah'])->name('api.wilayah');
    Route::get('/api/idm', [StatisticController::class, 'apiIdm'])->name('api.idm');
    Route::get('/api/sdgs', [StatisticController::class, 'apiSdgs'])->name('api.sdgs');
});

// Peta Interaktif
Route::get('/peta', [MapController::class, 'index'])->name('peta');
Route::get('/peta/api/geojson', [MapController::class, 'geojson'])->name('peta.geojson');

// Transparansi
Route::prefix('transparansi')->name('transparansi.')->group(function () {
    Route::get('/apbkal', [TransparencyController::class, 'apbkal'])->name('apbkal');
    Route::get('/apbkal/{year}', [TransparencyController::class, 'apbkalYear'])->name('apbkal.year');
    Route::get('/pembangunan', [TransparencyController::class, 'pembangunan'])->name('pembangunan');
    Route::get('/pembangunan/{slug}', [TransparencyController::class, 'pembangunanDetail'])->name('pembangunan.detail');
    Route::get('/bansos', [TransparencyController::class, 'bansos'])->name('bansos');
});

// PPID
Route::prefix('ppid')->name('ppid.')->group(function () {
    Route::get('/', [PpidController::class, 'index'])->name('index');
    Route::get('/{slug}', [PpidController::class, 'show'])->name('show');
    Route::get('/{slug}/download', [PpidController::class, 'download'])->name('download');
});

// Potensi Desa
Route::prefix('potensi')->name('potensi.')->group(function () {
    Route::get('/umkm', [PotentialController::class, 'umkm'])->name('umkm');
    Route::get('/umkm/{slug}', [PotentialController::class, 'umkmDetail'])->name('umkm.detail');
    Route::get('/wisata', [PotentialController::class, 'wisata'])->name('wisata');
    Route::get('/wisata/{slug}', [PotentialController::class, 'wisataDetail'])->name('wisata.detail');
});

// Layanan
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/surat', [ServiceController::class, 'surat'])->name('surat');
    Route::get('/verifikasi/{token}', [ServiceController::class, 'verifikasi'])->name('verifikasi');
});

// Pengaduan
Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
    Route::get('/', [ComplaintController::class, 'index'])->name('index');
    Route::post('/', [ComplaintController::class, 'store'])->name('store');
    Route::get('/tracking', [ComplaintController::class, 'tracking'])->name('tracking');
    Route::get('/tracking/{ticket}', [ComplaintController::class, 'trackingDetail'])->name('tracking.detail');
});

// Buku Tamu
Route::prefix('buku-tamu')->name('buku-tamu.')->group(function () {
    Route::get('/', [GuestBookController::class, 'index'])->name('index');
    Route::post('/', [GuestBookController::class, 'store'])->name('store');
});

// Kontak
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'send'])->name('kontak.send');

// ============================================================
//  PORTAL WARGA AUTH ROUTES
// ============================================================

Route::prefix('warga')->name('warga.')->group(function () {
    // Guest routes
    Route::middleware('guest:warga')->group(function () {
        Route::get('/login', [WargaAuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [WargaAuthController::class, 'login'])->name('login.post');
        Route::get('/register', [WargaAuthController::class, 'registerForm'])->name('register');
        Route::post('/register', [WargaAuthController::class, 'register'])->name('register.post');
    });

    // Authenticated routes
    Route::middleware('auth:warga')->group(function () {
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [WargaDashboardController::class, 'profil'])->name('profil');
        Route::put('/profil', [WargaDashboardController::class, 'updateProfil'])->name('profil.update');

        // Permohonan surat
        Route::prefix('/surat')->name('surat.')->group(function () {
            Route::get('/', [LetterController::class, 'index'])->name('index');
            Route::get('/ajukan', [LetterController::class, 'create'])->name('create');
            Route::get('/ajukan/{type}', [LetterController::class, 'form'])->name('form');
            Route::post('/ajukan/{type}', [LetterController::class, 'store'])->name('store');
            Route::get('/{id}', [LetterController::class, 'show'])->name('show');
            Route::get('/{id}/download', [LetterController::class, 'download'])->name('download');
            Route::delete('/{id}', [LetterController::class, 'cancel'])->name('cancel');
        });

        Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout');
    });
});

// ============================================================
//  API ROUTES (for AJAX / Livewire)
// ============================================================

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/announcements/ticker', [AnnouncementController::class, 'ticker'])->name('announcements.ticker');
    Route::get('/weather', [HomeController::class, 'weather'])->name('weather');
});
