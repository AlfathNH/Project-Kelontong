<?php
// kasir/dashboard_kasir.php
include '../config/koneksi.php'; // Perhatikan path-nya

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: ../index.php");
    exit();
}

$nama_kasir = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir - Toko Kelontong</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $nama_kasir; ?>! (Kasir)</h2>
    <p>Ini adalah halaman Dashboard khusus untuk kasir.</p>

    <ul>
        <li><a href="#">Input Transaksi Penjualan</a></li>
        <li><a href="#">Catat Pengeluaran Kecil</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>

    </body>
</html>