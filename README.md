## Sistem Gudang API

Proyek ini adalah aplikasi Laravel 11 yang dikonfigurasi untuk berjalan menggunakan Docker dan Laravel Sanctum. Panduan ini akan membantu Anda menjalankan aplikasi ini di lingkungan lokal setelah melakukan clone dari repository GitHub.

## Dokumen Postman

Untuk pengujian API, Anda dapat melihat dokumen Postman yang telah disediakan. Klik link di bawah untuk melihat dokumen Postman:

[**Dokumen Postman**](https://documenter.getpostman.com/view/17405806/2sA3sAioRL)

apabila ingin menggunakan koleksi postman. klik link dibawah ini:

[**link collection Postman**](https://api.postman.com/collections/17405806-100f097b-b36d-424a-91c1-65633ad716f4?access_key=PMAT-01J5TB8MC4MEZZ6T6R5YBCQKXS)

setelah itu pilih `import` yang ada di pojok kanan atas pada menu `collections` dan copy json yang ada dalam link tersebut. 

## Persyaratan

Pastikan Anda telah menginstal perangkat lunak berikut di komputer Anda:

- **Git**: Untuk meng-clone repository.
- **Docker**: Untuk menjalankan container aplikasi.

## Langkah-langkah Menjalankan Aplikasi

1. **Clone Repository**

   Pertama, clone repository dari GitHub ke komputer Anda dan masuk ke direktori proyek anda:

    ```bash
   git clone https://github.com/nagzcupz/app-sisgudang.git
   cd app-sisgudang

2. **Salin FIle `.env`**

   Salin file .env.example menjadi .env:

    ```bash
   cp .env.example .env

3. **Konfigurasi Database pada File `.env`**

   konfigurasi database file .env yang telah di salin menjadi:

    ```bash
   # .env
   DB_CONNECTION=mysql
   DB_HOST=sis_gudang_mysql
   DB_PORT=3306
   DB_DATABASE=db_sisGudang
   DB_USERNAME=userdocker
   DB_PASSWORD=rootdocker

4. **Build Docker Image**
   
   Setelah aplikasi Docker Desktop dibuka, jalankan perintah berikut untuk membangun image Docker berdasarkan Dockerfile:

    ```bash
   docker-compose build

5. **Jalankan Docker**
   
   Setelah image selesai dibangun, jalankan perintah berikut untuk menjalankan container Docker:
   
         docker-compose up -d
   
   perintah ini akan menjalankan container secara terpisah untuk aplikasi laravel dan database.

6. **Install Dependensi Composer**
   
   Setelah itu pergi ke direktori aplikasi laravel dan jalankan perintah berikut untuk menjalankan container Docker:
   
         cd app/sis-gudang-backend
         docker-compose exec sis_gudang_app bash
   
   Setelah masuk ke dalam container, jalankan perintah berikut untuk menginstal dependensi:

         composer install

7. **Generate Key Aplikasi**
   
   Masih di dalam container aplikasi, jalankan perintah berikut untuk menghasilkan 'Key' aplikasi:
   
         php artisan key:generate
   
8. **Membuat Symbolic Link untuk Storage**

   Jalankan perintah berikut untuk membuat symbolic link dari `storage` ke `public`:

         php artisan storage:link

9. **Migrasi Database**
   
   Jalankan migrasi untuk membuat tabel-tabel di database:
   
         php artisan migrate

10. **Akses Aplikasi**

      Setelah semua langkah di atas selesai, Anda dapat mengakses aplikasi Laravel di browser dengan membuka:
   
         http://localhost:8000

      Apabila ingin mengakses phpMyAdmin, Anda dapat membuka:

         http://localhost:3001

      berikut username dan password untuk mengakses phpMyadmin:
         - **Git**: Untuk meng-clone repository.
         - **Docker**: Untuk menjalankan container aplikasi.
   
## Penghentian Container

Untuk menghentikan semua container Docker yang sedang berjalan, jalankan perintah berikut:

      docker-compose down
