<?php
// pelanggan/keranjang.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$nama_pelanggan = $_SESSION['nama_lengkap'];

// Ambil isi keranjang dari database untuk pelanggan ini (sesuai panah DFD: Pemesanan -> 1.4 Pemesanan)
$query_keranjang = "SELECT tp.id_pesanan, tp.jumlah, tprod.nama_produk, tprod.harga_jual, tprod.stok 
                    FROM t_pesanan tp
                    JOIN t_produk tprod ON tp.id_produk = tprod.id_produk
                    WHERE tp.id_user_pelanggan = '$id_user_pelanggan'";
$result_keranjang = mysqli_query($koneksi, $query_keranjang);

$total_semua_item = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Toko Kelontong</title>
</head>
<body>
    <h2>Keranjang Belanja Anda</h2>
    <p>Selamat datang, <?php echo $nama_pelanggan; ?>!</p>

    <p><a href="produk.php">Lanjut Belanja</a> | <a href="dashboard_pelanggan.php">Kembali ke Dashboard</a> | <a href="../logout.php">Logout</a></p>

    <?php if (mysqli_num_rows($result_keranjang) == 0) { ?>
        <p>Keranjang belanja Anda kosong. Yuk <a href="produk.php">belanja sekarang!</a></p>
    <?php } else { ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($data_keranjang = mysqli_fetch_assoc($result_keranjang)) {
                    $subtotal_item = $data_keranjang['jumlah'] * $data_keranjang['harga_jual'];
                    $total_semua_item += $subtotal_item;
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data_keranjang['nama_produk']; ?></td>
                    <td>Rp <?php echo number_format($data_keranjang['harga_jual'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="update_keranjang_proses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_pesanan" value="<?php echo $data_keranjang['id_pesanan']; ?>">
                            <input type="number" name="jumlah" value="<?php echo $data_keranjang['jumlah']; ?>" min="1" max="<?php echo $data_keranjang['stok']; ?>" style="width: 50px;">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>Rp <?php echo number_format($subtotal_item, 0, ',', '.'); ?></td>
                    <td>
                        <form action="hapus_keranjang_proses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_pesanan" value="<?php echo $data_keranjang['id_pesanan']; ?>">
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right"><strong>Total Belanja:</strong></td>
                    <td><strong>Rp <?php echo number_format($total_semua_item, 0, ',', '.'); ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <p><a href="checkout_proses.php"><button>Lanjut ke Pembayaran</button></a></p>
    <?php } ?>

</body>
</html>