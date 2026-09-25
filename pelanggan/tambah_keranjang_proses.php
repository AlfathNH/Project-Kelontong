<?php
// pelanggan/tambah_keranjang_proses.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

// Ambil informasi produk (harga dan stok) dari t_produk
$query_get_produk = "SELECT harga_jual, stok FROM t_produk WHERE id_produk = '$id_produk'";
$result_get_produk = mysqli_query($koneksi, $query_get_produk);
$data_produk = mysqli_fetch_assoc($result_get_produk);

$harga_jual_produk = $data_produk['harga_jual'];
$stok_tersedia = $data_produk['stok'];

// Validasi stok
if ($jumlah > $stok_tersedia) {
    echo "Jumlah yang diminta melebihi stok tersedia. Stok saat ini: " . $stok_tersedia;
    echo "<br><a href='produk.php'>Kembali ke Daftar Produk</a>";
    exit();
}

// Cek apakah produk sudah ada di keranjang pelanggan yang sama
$query_cek_keranjang = "SELECT * FROM t_pesanan WHERE id_user_pelanggan = '$id_user_pelanggan' AND id_produk = '$id_produk'";
$result_cek_keranjang = mysqli_query($koneksi, $query_cek_keranjang);

if (mysqli_num_rows($result_cek_keranjang) > 0) {
    // Jika produk sudah ada, update jumlahnya
    $data_keranjang = mysqli_fetch_assoc($result_cek_keranjang);
    $new_jumlah = $data_keranjang['jumlah'] + $jumlah;

    // Pastikan update tidak melebihi stok
    if ($new_jumlah > $stok_tersedia) {
        echo "Penambahan ke keranjang melebihi stok tersedia. Stok saat ini: " . $stok_tersedia;
        echo "<br><a href='produk.php'>Kembali ke Daftar Produk</a>";
        exit();
    }

    $query_update_keranjang = "UPDATE t_pesanan SET jumlah = '$new_jumlah' 
                               WHERE id_user_pelanggan = '$id_user_pelanggan' AND id_produk = '$id_produk'";
    mysqli_query($koneksi, $query_update_keranjang);
} else {
    // Jika produk belum ada, tambahkan baru
    $query_insert_keranjang = "INSERT INTO t_pesanan (id_user_pelanggan, id_produk, jumlah) 
                               VALUES ('$id_user_pelanggan', '$id_produk', '$jumlah')";
    mysqli_query($koneksi, $query_insert_keranjang);
}

// Redirect kembali ke halaman produk atau keranjang
header("Location: keranjang.php");
exit();
?>