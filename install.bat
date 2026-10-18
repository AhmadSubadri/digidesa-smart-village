@echo off
chcp 65001 >nul
title DesaHub - 1-Click Installer (Smart Village Ecosystem)
color 0A

echo =========================================================================
echo               DESAHUB — SMART VILLAGE ECOSYSTEM INSTALLER
echo               Turnkey 1 Desa 1 Sistem Automated Setup
echo =========================================================================
echo.

IF NOT EXIST ".env" (
    echo [1/6] Menduplikasi berkas .env.example menjadi .env...
    copy .env.example .env >nul
    echo       Berhasil dibuat!
) ELSE (
    echo [1/6] Berkas .env sudah tersedia.
)

echo.
echo [2/6] Memeriksa dependensi Composer...
call composer install --no-interaction --prefer-dist --optimize-autoloader

echo.
echo [3/6] Generate Application Encryption Key...
call php artisan key:generate --force

echo.
echo [4/6] Menjalankan migrasi basis data...
call php artisan migrate --force

echo.
echo [5/6] Menyuntikkan data katalog dan percontohan (Seeder)...
call php artisan db:seed --class=DatabaseSeeder --force
call php artisan db:seed --class=ComprehensiveDemoSeeder --force

echo.
echo [6/6] Menautkan folder penyimpanan berkas publik (Storage Symlink)...
call php artisan storage:link

echo.
echo =========================================================================
echo                  INSTALASI DESAHUB TELAH SELESAI!
echo =========================================================================
echo.
echo Website Publik : http://localhost:8000/
echo Admin Panel    : http://localhost:8000/admin
echo Email Admin    : admin@desa.id
echo Password Admin : password
echo.
echo Portal Warga   : http://localhost:8000/warga/login
echo NIK Warga Demo : 3404071203850001
echo Password Warga : password
echo.
echo Silakan buka Setup Wizard di http://localhost:8000/admin/setup-wizard
echo untuk menyesuaikan identitas nama desa, logo, dan pamong desa baru.
echo =========================================================================
echo.
pause
