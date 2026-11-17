# 🎟️ WorkshopTix — Platform Pendaftaran & E-Ticketing Workshop IT

**WorkshopTix** adalah aplikasi web berbasis Laravel untuk mengelola pendaftaran acara workshop dan seminar IT secara profesional. Aplikasi ini dirancang untuk memenuhi kebutuhan praktikum maupun uji kompetensi, dilengkapi dengan manajemen kuota otomatis, integrasi *payment gateway* **Midtrans Sandbox**, penerbitan E-Tiket berformat PDF (**DomPDF**), serta proteksi keamanan otorisasi pengguna (*ownership verification*).

---

## ✨ Fitur Utama & Alur Sistem

1. **Manajemen Role & Hak Akses (Middleware & Otorisasi)**
   * **Panitia / Admin:** Mengelola data workshop (CRUD: tambah, ubah, hapus) serta memantau data pendaftaran peserta secara keseluruhan.
   * **Peserta:** Melakukan pendaftaran akun, memilih workshop yang tersedia, memproses pembayaran, serta mengunduh e-tiket milik pribadi.

2. **Alur Pendaftaran & Validasi Ketat**
   * **Pencegahan Pendaftaran Ganda:** Sistem secara otomatis memvalidasi agar peserta tidak dapat mendaftar pada workshop yang sama dua kali.
   * **Manajemen Kuota:** Memastikan kuota peserta pada setiap workshop berkurang secara akurat dan sinkron.

3. **Integrasi Pembayaran Midtrans Sandbox**
   * Pembuatan transaksi online secara otomatis dengan status awal `pending`.
   * Pembaruan status otomatis menjadi `paid` setelah pembayaran berhasil diverifikasi melalui sistem *backend*.

4. **E-Ticketing & Keamanan Data (Anti ID-Guessing)**
   * Peserta dapat mengunduh e-tiket resmi berformat PDF yang memuat kode unik (`TIX-XXXXXXXX`), nama peserta, judul workshop, dan jadwal acara.
   * Dilindungi dengan validasi kepemilikan berbasis `Auth::id()` sehingga upaya manipulasi URL oleh akun lain akan langsung ditolak dengan respons **403 Unauthorized**.

5. **Optimasi Performa Query (Eager Loading)**
   * Penerapan relasi menggunakan `with('workshop')` guna menghindari masalah *N+1 query problem* pada daftar pendaftaran peserta.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.x, Laravel Framework
* **Frontend:** Blade Templating, Tailwind CSS
* **Database:** MySQL / MariaDB
* **Payment Gateway:** Midtrans PHP SDK (Sandbox Mode)
* **PDF Generator:** `barryvdh/laravel-dompdf`

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal (*localhost*):

### 1. Clone Repositori
```bash
git clone https://github.com/username/workshoptix.git
cd workshoptix
```

### 2. Instalasi Dependensi PHP & Frontend
```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi File Environment (`.env`)
Salin file `.env.example` menjadi `.env`, lalu buat *application key*:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database & Midtrans
Buka file `.env` di text editor pilihanmu, lalu sesuaikan pengaturan database dan kunci API Midtrans Sandbox:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=workshoptix
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

### 5. Migrasi & Seeding Database
Jalankan perintah migrasi database untuk membuat tabel yang dibutuhkan:
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Buka browser kesayanganmu dan akses aplikasi melalui alamat: **`http://127.0.0.1:8000`**

---

## 🔒 Catatan Keamanan
Setiap endpoint sensitif yang berkaitan dengan transaksi dan pengunduhan e-tiket telah dilindungi oleh sistem otorisasi ketat. Akses yang tidak sah akan dicegah secara otomatis untuk menjaga integritas data masing-masing pengguna.

