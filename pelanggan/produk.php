<?php
// pelanggan/produk.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user']; // ID pelanggan yang sedang login
$nama_pelanggan = $_SESSION['nama_lengkap'];

// Ambil semua produk dari database (sesuai panah DFD: Daftar Produk -> 1.4 Pemesanan)
$query_produk = "SELECT * FROM t_produk";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk - Toko Kelontong</title>
</head>
<body>
    <h2>Daftar Produk yang Tersedia</h2>
    <p>Selamat datang, <?php echo $nama_pelanggan; ?>! Silakan pilih produk.</p>

    <p><a href="dashboard_pelanggan.php">Kembali ke Dashboard</a> | <a href="keranjang.php">Lihat Keranjang</a> | <a href="../logout.php">Logout</a></p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($data_produk = mysqli_fetch_assoc($result_produk)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_produk['nama_produk']; ?></td>
                <td>Rp <?php echo number_format($data_produk['harga_jual'], 0, ',', '.'); ?></td>
                <td><?php echo $data_produk['stok']; ?></td>
                <td>
                    <?php if ($data_produk['stok'] > 0) { ?>
                        <form action="tambah_keranjang_proses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_produk" value="<?php echo $data_produk['id_produk']; ?>">
                            <input type="number" name="jumlah" value="1" min="1" max="<?php echo $data_produk['stok']; ?>" style="width: 50px;">
                            <button type="submit">Tambah ke Keranjang</button>
                        </form>
                    <?php } else { ?>
                        <span style="color: red;">Stok Habis</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>