@echo off
title DentaEase - Laravel Server
cd /d "%~dp0"
echo Starting Laravel server...
php artisan serve
pause
