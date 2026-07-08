@echo off
echo =================================
echo Script Pembersih & Sinkronisasi
echo =================================
echo.

echo [1/7] Pull kode terbaru dari Git...
git pull

echo.
echo [2/7] Membersihkan cache Laravel...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear

echo.
echo [3/7] Reload Composer autoload...
composer dump-autoload -o

echo.
echo [4/7] Menjalankan migrasi database...
php artisan migrate

echo.
echo [5/7] Membersihkan browser cache...
echo Silakan tekan Ctrl+Shift+Delete di browser Anda

echo.
echo [6/7] Merestart Node/Vite...
echo Tekan Ctrl+C untuk menghentikan npm dev (jika sedang berjalan), lalu jalankan ulang

echo.
echo [7/7] Checking data di database...
php check_courses.php

echo.
echo =================================
echo ✓ Selesai! Coba refresh browser
echo =================================

pause
