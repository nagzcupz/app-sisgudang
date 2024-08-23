w# Sistem Gudang API

Proyek ini adalah aplikasi Laravel 11 yang dikonfigurasi untuk berjalan menggunakan Docker dan Laravel Sanctum. Panduan ini akan membantu Anda menjalankan aplikasi ini di lingkungan lokal setelah melakukan clone dari repository GitHub.

## Persyaratan

Pastikan Anda telah menginstal perangkat lunak berikut di komputer Anda:

- **Git**: Untuk meng-clone repository.
- **Docker**: Untuk menjalankan container aplikasi.

## Langkah-langkah Menjalankan Aplikasi

1. **Clone Repository**

   Pertama, clone repository dari GitHub ke komputer Anda dan masuk ke direktori proyek anda:

    ```bash
   git clone https://github.com/nagzcupz/app-sisgudang.git
   cd app-sisgudang/app/sis-gudang-backend

2. **Salin FIle `.env`**

   Salin file .env.example menjadi .env:

    ```bash
   cp .env.example .env

2. **Konfigurasi Database pada File `.env`**

   konfigurasi database file .env yang telah di salin menjadi:

    ```bash
   # .env
   DB_CONNECTION=mysql
   DB_HOST=sis_gudang_mysql
   DB_PORT=3306
   DB_DATABASE=db_sisGudang
   DB_USERNAME=userdocker
   DB_PASSWORD=rootdocker
    



