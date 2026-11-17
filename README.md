🎟️ WorkshopTix — Platform Pendaftaran & E-Ticketing Workshop IT

WorkshopTix adalah aplikasi web berbasis Laravel untuk mengelola pendaftaran acara workshop dan seminar IT. Aplikasi ini dilengkapi dengan sistem manajemen kuota otomatis, integrasi payment gateway menggunakan Midtrans Sandbox, penerbitan E-Tiket berbentuk PDF (DomPDF), serta proteksi keamanan otorisasi pengguna (ownership verification).

✨ Fitur Utama

1. Manajemen Workshop & Kategori (Admin/Pemateri)

Pengelolaan data workshop (CRUD: judul, deskripsi, pemateri, jadwal, harga, dan kuota).

Pengelompokan workshop berdasarkan kategori IT.

2. Alur Pendaftaran & Pembayaran Otomatis (Peserta)

Pengecekan Kuota & Duplikasi: Menggunakan Database Transaction dan lockForUpdate() untuk mencegah pendaftaran ganda dan memastikan kuota berkurang secara akurat.

Integrasi Midtrans Sandbox: Mendukung pembayaran online secara otomatis melalui Midtrans Snap API beserta mekanisme pembaruan token (renewToken) dan konfirmasi status pembayaran (paid / pending).

3. E-Ticketing & Keamanan Data

Generator E-Tiket PDF: Peserta dapat langsung mengunduh tiket resmi berformat PDF yang memuat kode tiket unik (TIX-XXXXXXXX), informasi acara, dan status pembayaran.

Proteksi Otorisasi (Anti ID-Guessing): Penerapan validasi kepemilikan berbasis Auth::id() pada setiap akses tiket untuk mencegah pengguna lain mengakses atau mengunduh tiket milik peserta lain melalui manipulasi URL.

4. Antarmuka Modern & Responsif

Dibangun menggunakan Tailwind CSS dengan desain modern bertema Dark & Emerald, lengkap dengan indikator navigasi aktif dan umpan balik status yang informatif.

🛠️ Teknologi yang Digunakan

Backend: PHP 8.x, Laravel Framework

Frontend: Blade Templating, Tailwind CSS

Database: MySQL / MariaDB

Payment Gateway: Midtrans PHP SDK (Sandbox Mode)

PDF Generator: barryvdh/laravel-dompdf

🚀 Cara Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal (localhost):

1. Clone Repositori

git clone https://github.com/username/workshoptix.git
cd workshoptix


2. Instalasi Dependensi PHP & Frontend

composer install
npm install && npm run build


3. Konfigurasi File Environment (.env)

Salin file .env.example menjadi .env, lalu buat application key:

cp .env.example .env
php artisan key:generate


4. Konfigurasi Database & Midtrans

Buka file .env dan sesuaikan pengaturan database serta kunci API Midtrans Sandbox kamu:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=workshoptix
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false


5. Migrasi Database (dan Seeder jika ada)

php artisan migrate --seed


6. Jalankan Server Lokal

php artisan serve


Buka browser dan akses aplikasi melalui alamat: http://127.0.0.1:8000

🔒 Catatan Keamanan (Security Highlight)

Setiap endpoint sensitif yang berkaitan dengan transaksi dan pengunduhan e-tiket telah dilindungi menggunakan middleware auth dan pengecekan kepemilikan record (user_id === Auth::id()), sehingga permintaan tidak sah akan otomatis ditolak dengan respons 403 Unauthorized.