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

// Ambil isi keranjang dari database untuk pelanggan ini
$query_keranjang = "SELECT tp.id_pesanan, tp.jumlah, tprod.nama_produk, tprod.harga_jual, tprod.stok 
                    FROM t_pesanan tp
                    JOIN t_produk tprod ON tp.id_produk = tprod.id_produk
                    WHERE tp.id_user_pelanggan = '$id_user_pelanggan'";
$result_keranjang = mysqli_query($koneksi, $query_keranjang);

$total_semua_item = 0;
$total_jumlah_qty = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Kelontong Segar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">local_shipping</span>
        <span>Pesanan Anda akan diantar langsung dengan kemasan higienis dan rapi.</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="dashboard_pelanggan.php" class="brand-logo">
                <div class="brand-icon">
                    <span class="icon">storefront</span>
                </div>
                <div>
                    <span class="brand-title">Kelontong Segar</span>
                    <span class="brand-subtitle">Keranjang Belanja</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="dashboard_pelanggan.php" class="nav-link">
                    <span class="icon">dashboard</span>
                    Dashboard
                </a>
                <a href="produk.php" class="nav-link">
                    <span class="icon">store</span>
                    Katalog Produk
                </a>
                <a href="keranjang.php" class="nav-link active">
                    <span class="icon">shopping_cart</span>
                    Keranjang
                </a>
                <span class="nav-user-badge">
                    <span class="icon" style="color: var(--accent-green); font-size: 18px;">account_circle</span>
                    <?php echo htmlspecialchars($nama_pelanggan); ?>
                </span>
                <a href="../logout.php" class="btn btn-secondary btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                    <span class="icon">logout</span>
                    Keluar
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-wrapper">
        
        <div class="catalog-header fade-in">
            <div class="catalog-title">
                <h2>Keranjang Belanja Anda</h2>
                <p>Periksa kembali produk yang ingin dibeli sebelum lanjut ke kasir / pembayaran</p>
            </div>
            <div>
                <a href="produk.php" class="btn btn-secondary btn-sm">
                    <span class="icon">arrow_back</span>
                    Tambah Belanjaan Lain
                </a>
            </div>
        </div>

        <?php if (mysqli_num_rows($result_keranjang) == 0): ?>
            <!-- Empty Cart State -->
            <div class="card-glass fade-in" style="text-align: center; padding: 60px 20px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--surface-tint); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <span class="icon" style="font-size: 40px;">shopping_basket</span>
                </div>
                <h3 style="margin-bottom: 8px;">Keranjang Belanja Masih Kosong</h3>
                <p style="color: var(--text-secondary); margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Yuk penuhi persediaan dapur Anda dengan beras, minyak goreng, telur, dan bumbu dapur berkualitas di Kelontong Segar.
                </p>
                <a href="produk.php" class="btn btn-primary">
                    <span class="icon">store</span>
                    Mulai Belanja Sekarang
                </a>
            </div>
        <?php else: ?>
            
            <!-- Golden Split Layout: Left Table (~61.8%) & Right Summary (~38.2%) -->
            <div class="golden-hero-split fade-in">
                
                <!-- Left: Table of Items -->
                <div class="table-container">
                    <table class="kelontong-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th style="width: 140px;">Jumlah</th>
                                <th>Subtotal</th>
                                <th style="text-align: center; width: 60px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($data_keranjang = mysqli_fetch_assoc($result_keranjang)) {
                                $subtotal_item = $data_keranjang['jumlah'] * $data_keranjang['harga_jual'];
                                $total_semua_item += $subtotal_item;
                                $total_jumlah_qty += $data_keranjang['jumlah'];
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($data_keranjang['nama_produk']); ?></strong>
                                    <div style="font-size: 11px; color: var(--text-muted);">Tersedia: <?php echo $data_keranjang['stok']; ?> unit</div>
                                </td>
                                <td>Rp <?php echo number_format($data_keranjang['harga_jual'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="update_keranjang_proses.php" method="POST" style="display:flex; align-items:center; gap: 6px;">
                                        <input type="hidden" name="id_pesanan" value="<?php echo $data_keranjang['id_pesanan']; ?>">
                                        <input type="number" name="jumlah" value="<?php echo $data_keranjang['jumlah']; ?>" min="1" max="<?php echo $data_keranjang['stok']; ?>" class="qty-input">
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Perbarui Jumlah" style="padding: 6px 10px;">
                                            <span class="icon" style="font-size: 16px;">refresh</span>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <strong style="color: var(--primary);">Rp <?php echo number_format($subtotal_item, 0, ',', '.'); ?></strong>
                                </td>
                                <td style="text-align: center;">
                                    <form action="hapus_keranjang_proses.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_pesanan" value="<?php echo $data_keranjang['id_pesanan']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" style="padding: 6px 10px;" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')" title="Hapus Item">
                                            <span class="icon" style="font-size: 16px;">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Right: Summary Card -->
                <div>
                    <div class="cart-summary-card">
                        <h3 style="font-size: var(--font-md); margin-bottom: 8px;">Ringkasan Belanja</h3>
                        
                        <div class="cart-summary-row">
                            <span>Total Item</span>
                            <strong><?php echo $total_jumlah_qty; ?> barang</strong>
                        </div>

                        <div class="cart-summary-row">
                            <span>Subtotal Belanja</span>
                            <span>Rp <?php echo number_format($total_semua_item, 0, ',', '.'); ?></span>
                        </div>

                        <div class="cart-summary-row">
                            <span>Biaya Pengantaran</span>
                            <span style="color: var(--accent-green); font-weight: 700;">GRATIS</span>
                        </div>

                        <div class="cart-summary-row cart-summary-total">
                            <span>Total Pembayaran</span>
                            <span>Rp <?php echo number_format($total_semua_item, 0, ',', '.'); ?></span>
                        </div>

                        <div class="promo-chip" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="icon">verified</span>
                            <span>Jaminan Timbang Pas &amp; Segar</span>
                        </div>

                        <a href="checkout_proses.php" class="btn btn-primary btn-block" style="margin-top: 10px;">
                            <span>Lanjut ke Pembayaran</span>
                            <span class="icon">payment</span>
                        </a>

                        <a href="produk.php" class="btn btn-secondary btn-block">
                            <span class="icon">add_shopping_cart</span>
                            Lanjut Pilih Produk
                        </a>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Belanja Nyaman, Dekat, dan Bersahabat.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Kelontong Segar.
            </div>
        </div>
    </footer>

</body>
</html>