<?php
// admin/dashboard_pemilik.php
include '../config/koneksi.php'; // Perhatikan path-nya: naik satu folder lalu masuk config

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pemilik') {
    header("Location: ../index.php"); // Jika belum login atau level salah, tendang ke login
    exit();
}

$nama_pemilik = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemilik - Toko Kelontong</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $nama_pemilik; ?>! (Pemilik)</h2>
    <p>Ini adalah halaman Dashboard khusus untuk pemilik toko.</p>

    <ul>
        <li><a href="#">Kelola Data Produk</a></li>
        <li><a href="#">Kelola Data Pengguna (Kasir & Pelanggan)</a></li>
        <li><a href="#">Kelola Promosi</a></li>
        <li><a href="#">Lihat Laporan Penjualan</a></li>
        <li><a href="#">Lihat Laporan Pengeluaran Kasir</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>

    </body>
</html>