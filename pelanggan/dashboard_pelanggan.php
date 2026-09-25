<?php
// pelanggan/dashboard_pelanggan.php
include '../config/koneksi.php'; // Perhatikan path-nya

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$nama_pelanggan = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelanggan - Toko Kelontong</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $nama_pelanggan; ?>! (Pelanggan)</h2>
    <p>Ini adalah halaman Dashboard khusus untuk pelanggan.</p>

<ul>
        <li><a href="produk.php">Lihat Daftar Produk</a></li>
        <li><a href="keranjang.php">Keranjang Belanja</a></li>
        <li><a href="#">Riwayat Pemesanan</a></li> 
        <li><a href="../logout.php">Logout</a></li>
    </ul>

    </body>
</html>