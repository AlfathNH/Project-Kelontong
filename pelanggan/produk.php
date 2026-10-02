<?php
// pelanggan/produk.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya adalah pelanggan
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$nama_pelanggan = $_SESSION['nama_lengkap'];

// Ambil jumlah item di keranjang untuk badge di navbar
$q_cart = mysqli_query($koneksi, "SELECT SUM(jumlah) as total_qty FROM t_pesanan WHERE id_user_pelanggan='$id_user_pelanggan'");
$d_cart = mysqli_fetch_assoc($q_cart);
$total_qty_cart = $d_cart['total_qty'] ? $d_cart['total_qty'] : 0;

// Ambil semua produk dari database
$query_produk = "SELECT * FROM t_produk ORDER BY id_produk ASC";
$result_produk = mysqli_query($koneksi, $query_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk Sembako - Kelontong Segar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">local_shipping</span>
        <span>Stok Segar Setiap Hari! Belanja min. Rp 30.000 Gratis Biaya Kirim.</span>
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
                    <span class="brand-subtitle">Katalog Produk Sembako</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="dashboard_pelanggan.php" class="nav-link">
                    <span class="icon">dashboard</span>
                    Dashboard
                </a>
                <a href="produk.php" class="nav-link active">
                    <span class="icon">store</span>
                    Produk
                </a>
                <a href="keranjang.php" class="nav-link">
                    <span class="icon">shopping_cart</span>
                    Keranjang
                    <?php if ($total_qty_cart > 0): ?>
                        <span style="background: var(--primary); color: white; border-radius: var(--radius-pill); padding: 1px 7px; font-size: 11px; font-weight: 700;">
                            <?php echo $total_qty_cart; ?>
                        </span>
                    <?php endif; ?>
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
                <h2>Daftar Produk Sembako &amp; Kebutuhan Dapur</h2>
                <p>Silakan pilih barang kebutuhan harian Anda dengan harga terjangkau</p>
            </div>
            <div>
                <a href="keranjang.php" class="btn btn-primary btn-sm">
                    <span class="icon">shopping_cart</span>
                    Lihat Keranjang (<?php echo $total_qty_cart; ?>)
                </a>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger fade-in">
                <span class="icon">error</span>
                <span><?php echo htmlspecialchars($_GET['error']); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['sukses'])): ?>
            <div class="alert alert-success fade-in">
                <span class="icon">check_circle</span>
                <span>Produk berhasil ditambahkan ke keranjang belanja Anda!</span>
            </div>
        <?php endif; ?>

        <!-- Product Cards Grid -->
        <div class="product-grid fade-in">
            <?php 
            $no = 1;
            while ($data_produk = mysqli_fetch_assoc($result_produk)) {
                // Pilih ikon yang sesuai berdasarkan nama produk
                $nama_lower = strtolower($data_produk['nama_produk']);
                $icon_name = 'inventory_2';
                if (strpos($nama_lower, 'beras') !== false) $icon_name = 'rice_bowl';
                else if (strpos($nama_lower, 'minyak') !== false) $icon_name = 'oil_barrel';
                else if (strpos($nama_lower, 'telur') !== false) $icon_name = 'egg';
                else if (strpos($nama_lower, 'gula') !== false) $icon_name = 'bakery_dining';
                else if (strpos($nama_lower, 'tepung') !== false) $icon_name = 'grain';
                else if (strpos($nama_lower, 'mie') !== false || strpos($nama_lower, 'indomie') !== false) $icon_name = 'ramen_dining';
                else if (strpos($nama_lower, 'kopi') !== false) $icon_name = 'coffee';
                else if (strpos($nama_lower, 'teh') !== false) $icon_name = 'local_cafe';
                else if (strpos($nama_lower, 'kecap') !== false || strpos($nama_lower, 'bumbu') !== false) $icon_name = 'soup_kitchen';
                else if (strpos($nama_lower, 'susu') !== false) $icon_name = 'water_drop';
            ?>
            <div class="product-card">
                <div>
                    <div class="product-thumb">
                        <?php if ($data_produk['stok'] > 10): ?>
                            <span class="product-badge-fresh">Stok Banyak</span>
                        <?php elseif ($data_produk['stok'] > 0): ?>
                            <span class="product-badge-fresh" style="background: #D97706;">Sisa Sedikit</span>
                        <?php else: ?>
                            <span class="product-badge-fresh" style="background: var(--accent-red);">Habis</span>
                        <?php endif; ?>
                        
                        <span class="icon"><?php echo $icon_name; ?></span>
                    </div>

                    <div class="product-name"><?php echo htmlspecialchars($data_produk['nama_produk']); ?></div>

                    <div class="product-stock <?php echo ($data_produk['stok'] == 0) ? 'out-of-stock' : ''; ?>">
                        <?php if ($data_produk['stok'] > 0): ?>
                            <span class="icon" style="font-size: 14px; color: var(--accent-green);">check_circle</span>
                            Tersedia: <?php echo $data_produk['stok']; ?> pcs
                        <?php else: ?>
                            <span class="icon" style="font-size: 14px; color: var(--accent-red);">cancel</span>
                            Stok Saat Ini Habis
                        <?php endif; ?>
                    </div>

                    <div class="product-price">
                        Rp <?php echo number_format($data_produk['harga_jual'], 0, ',', '.'); ?>
                    </div>
                </div>

                <div class="product-actions">
                    <?php if ($data_produk['stok'] > 0): ?>
                        <form action="tambah_keranjang_proses.php" method="POST">
                            <input type="hidden" name="id_produk" value="<?php echo $data_produk['id_produk']; ?>">
                            <div class="qty-control-wrapper">
                                <input type="number" name="jumlah" value="1" min="1" max="<?php echo $data_produk['stok']; ?>" class="qty-input" title="Jumlah">
                                <button type="submit" class="btn btn-primary btn-sm" style="flex: 1;">
                                    <span class="icon">add_shopping_cart</span>
                                    <span>+ Keranjang</span>
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-block btn-sm" disabled style="opacity: 0.6; cursor: not-allowed;">
                            <span class="icon">block</span>
                            Stok Habis
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php } ?>
        </div>

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