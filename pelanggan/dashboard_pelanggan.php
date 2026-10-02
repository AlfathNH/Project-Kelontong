<?php
// pelanggan/dashboard_pelanggan.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$nama_pelanggan = $_SESSION['nama_lengkap'];

// Ambil jumlah item di keranjang
$q_cart = mysqli_query($koneksi, "SELECT SUM(jumlah) as total_qty FROM t_pesanan WHERE id_user_pelanggan='$id_user_pelanggan'");
$d_cart = mysqli_fetch_assoc($q_cart);
$total_qty_cart = $d_cart['total_qty'] ? $d_cart['total_qty'] : 0;

// Ambil total jenis produk tersedia
$q_total_prod = mysqli_query($koneksi, "SELECT COUNT(*) as total_prod FROM t_produk WHERE stok > 0");
$d_total_prod = mysqli_fetch_assoc($q_total_prod);
$total_prod = $d_total_prod['total_prod'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Kelontong Segar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Announcement Bar -->
    <div class="top-bar">
        <span class="icon">local_shipping</span>
        <span>Pesanan diantar langsung ke rumah Anda! Pengantaran kilat 15-30 menit.</span>
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
                    <span class="brand-subtitle">Portal Belanja Pelanggan</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="produk.php" class="nav-link">
                    <span class="icon">store</span>
                    Katalog Produk
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
        
        <!-- Welcome Hero Banner -->
        <div class="card-showcase fade-in" style="margin-bottom: var(--space-5);">
            <div>
                <div class="hero-badge">
                    <span class="icon" style="color: var(--primary);">waving_hand</span>
                    <span>Selamat Datang Kembali</span>
                </div>
                <h1 class="hero-title">
                    Halo, <span class="hero-title-highlight"><?php echo htmlspecialchars($nama_pelanggan); ?></span>!
                </h1>
                <p class="hero-description">
                    Siap penuhi kebutuhan dapur hari ini? Nikmati produk sembako segar, harga bersahabat, dan layanan antar cepat langsung ke depan pintu Anda.
                </p>
                <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                    <a href="produk.php" class="btn btn-primary">
                        <span class="icon">shopping_bag</span>
                        Belanja Sekarang
                    </a>
                    <a href="keranjang.php" class="btn btn-secondary">
                        <span class="icon">shopping_cart</span>
                        Lihat Keranjang (<?php echo $total_qty_cart; ?>)
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-tile">
                <div class="stat-icon">
                    <span class="icon">inventory_2</span>
                </div>
                <div>
                    <div class="stat-value"><?php echo $total_prod; ?> Produk</div>
                    <div class="stat-title">Tersedia &amp; Siap Dipesan</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(22, 163, 74, 0.1); color: var(--accent-green);">
                    <span class="icon">shopping_cart_checkout</span>
                </div>
                <div>
                    <div class="stat-value"><?php echo $total_qty_cart; ?> Item</div>
                    <div class="stat-title">Dalam Keranjang Belanja</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(2, 132, 199, 0.1); color: var(--accent-blue);">
                    <span class="icon">savings</span>
                </div>
                <div>
                    <div class="stat-value">Rp 25.000</div>
                    <div class="stat-title">Voucher Diskon Siap Pakai</div>
                </div>
            </div>
        </div>

        <!-- Quick Menu Grid -->
        <div style="margin-top: var(--space-5);">
            <div class="catalog-title" style="margin-bottom: var(--space-4);">
                <h2>Menu Navigasi Cepat</h2>
                <p>Akses fitur belanja dan kelola pesanan Anda dengan mudah</p>
            </div>

            <div class="menu-grid">
                <a href="produk.php" class="menu-card">
                    <div class="menu-icon">
                        <span class="icon">storefront</span>
                    </div>
                    <div>
                        <div class="menu-title">Katalog &amp; Daftar Produk</div>
                        <div class="menu-desc">Lihat beras, minyak, bumbu, telur, dan produk lainnya</div>
                    </div>
                </a>

                <a href="keranjang.php" class="menu-card">
                    <div class="menu-icon">
                        <span class="icon">shopping_cart</span>
                    </div>
                    <div>
                        <div class="menu-title">Keranjang Belanja</div>
                        <div class="menu-desc">Cek rincian pesanan dan total belanja Anda</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Fitur riwayat pemesanan akan segera hadir!'); return false;">
                    <div class="menu-icon">
                        <span class="icon">receipt_long</span>
                    </div>
                    <div>
                        <div class="menu-title">Riwayat Pesanan</div>
                        <div class="menu-desc">Lacak status pengiriman dan faktur pesanan terdahulu</div>
                    </div>
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Akun Pelanggan: <?php echo htmlspecialchars($nama_pelanggan); ?>
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Kelontong Segar.
            </div>
        </div>
    </footer>

</body>
</html>