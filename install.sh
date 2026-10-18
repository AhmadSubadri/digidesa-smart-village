#!/usr/bin/env bash

# =========================================================================
#             DESAHUB — SMART VILLAGE ECOSYSTEM INSTALLER
#             Turnkey 1 Desa 1 Sistem Automated Linux Setup
# =========================================================================

set -e

echo "=== Memulai Instalasi Otomatis DesaHub ==="

if [ ! -f ".env" ]; then
    echo "[1/6] Membuat berkas .env dari .env.example..."
    cp .env.example .env
fi

echo "[2/6] Memasang dependensi Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "[3/6] Generate Application Encryption Key..."
php artisan key:generate --force

echo "[4/6] Menjalankan migrasi basis data..."
php artisan migrate --force

echo "[5/6] Menyuntikkan data katalog dan percontohan desa..."
php artisan db:seed --class=DatabaseSeeder --force
php artisan db:seed --class=ComprehensiveDemoSeeder --force

echo "[6/6] Menautkan folder penyimpanan berkas publik..."
php artisan storage:link || true

echo "Mengatur hak akses direktori storage dan cache..."
chmod -R 775 storage bootstrap/cache || true

echo ""
echo "========================================================================="
echo "                 INSTALASI DESAHUB TELAH SELESAI!"
echo "========================================================================="
echo "Admin Panel    : /admin"
echo "Email Admin    : admin@desa.id"
echo "Password Admin : password"
echo ""
echo "Portal Warga   : /warga/login"
echo "NIK Warga Demo : 3404071203850001"
echo "Password Warga : password"
echo "========================================================================="
