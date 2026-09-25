<?php
// pelanggan/update_keranjang_proses.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$id_pesanan = $_POST['id_pesanan'];
$jumlah_baru = $_POST['jumlah'];

// Ambil id_produk dari t_pesanan
$query_get_pesanan = "SELECT id_produk FROM t_pesanan WHERE id_pesanan = '$id_pesanan' AND id_user_pelanggan = '$id_user_pelanggan'";
$result_get_pesanan = mysqli_query($koneksi, $query_get_pesanan);
$data_pesanan = mysqli_fetch_assoc($result_get_pesanan);
$id_produk = $data_pesanan['id_produk'];

// Ambil stok produk dari t_produk
$query_get_stok = "SELECT stok FROM t_produk WHERE id_produk = '$id_produk'";
$result_get_stok = mysqli_query($koneksi, $query_get_stok);
$data_stok = mysqli_fetch_assoc($result_get_stok);
$stok_tersedia = $data_stok['stok'];

// Validasi stok
if ($jumlah_baru <= 0) {
    // Jika jumlah jadi 0 atau kurang, hapus saja
    $query_delete = "DELETE FROM t_pesanan WHERE id_pesanan = '$id_pesanan' AND id_user_pelanggan = '$id_user_pelanggan'";
    mysqli_query($koneksi, $query_delete);
} elseif ($jumlah_baru > $stok_tersedia) {
    echo "Jumlah yang diminta melebihi stok tersedia. Stok saat ini: " . $stok_tersedia;
    echo "<br><a href='keranjang.php'>Kembali ke Keranjang</a>";
    exit();
} else {
    $query_update = "UPDATE t_pesanan SET jumlah = '$jumlah_baru' 
                     WHERE id_pesanan = '$id_pesanan' AND id_user_pelanggan = '$id_user_pelanggan'";
    mysqli_query($koneksi, $query_update);
}

header("Location: keranjang.php");
exit();
?>