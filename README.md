# Project-Kelontong

Aplikasi manajemen dan penjualan toko kelontong berbasis Web menggunakan PHP dan MySQL (Native).

## Fitur Utama

- **Autentikasi Pengguna**:
  - Login multi-role (Pemilik/Admin, Kasir, Pelanggan)
  - Registrasi akun pelanggan
  - Logout aman
- **Dashboard Multi-Role**:
  - **Dashboard Pemilik/Admin**: Monitoring dan pengelolaan operasional toko.
  - **Dashboard Kasir**: Pengelolaan transaksi kasir.
  - **Dashboard Pelanggan**: Akses katalog produk dan belanja online.
- **Modul Pelanggan & Keranjang Belanja**:
  - Katalog produk
  - Penambahan produk ke keranjang belanja
  - Update jumlah produk & hapus dari keranjang

## Persyaratan Sistem

- PHP >= 7.4 / 8.x
- MySQL / MariaDB (XAMPP / Laragon)
- Web Server Apache

## Panduan Instalasi

1. Clone repositori ini ke folder root web server Anda (contoh untuk XAMPP: `c:/xampp/htdocs/`):
   ```bash
   git clone https://github.com/AlfathNH/Project-Kelontong.git toko-kelontong
   ```
2. Pastikan service Apache dan MySQL aktif pada XAMPP Control Panel.
3. Buat database di phpMyAdmin dengan nama `Pdb_tokokkelontong` (atau sesuaikan pada file `config/koneksi.php`).
4. Buka browser dan akses:
   ```
   http://localhost/toko-kelontong
   ```
