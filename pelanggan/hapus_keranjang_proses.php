<?php
// pelanggan/hapus_keranjang_proses.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$id_pesanan = $_POST['id_pesanan'];

$query_delete = "DELETE FROM t_pesanan 
                 WHERE id_pesanan = '$id_pesanan' AND id_user_pelanggan = '$id_user_pelanggan'";
mysqli_query($koneksi, $query_delete);

header("Location: keranjang.php");
exit();
?>