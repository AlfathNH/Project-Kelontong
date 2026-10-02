<?php
// pelanggan/checkout_proses.php
include '../config/koneksi.php';

// Cek autentikasi
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$id_user_pelanggan = $_SESSION['id_user'];
$nama_pelanggan = $_SESSION['nama_lengkap'];

// Ambil item pesanan
$query_keranjang = "SELECT tp.id_pesanan, tp.jumlah, tp.id_produk, tprod.nama_produk, tprod.harga_jual, tprod.stok 
                    FROM t_pesanan tp
                    JOIN t_produk tprod ON tp.id_produk = tprod.id_produk
                    WHERE tp.id_user_pelanggan = '$id_user_pelanggan'";
$result_keranjang = mysqli_query($koneksi, $query_keranjang);

$items = [];
$total_bayar = 0;
while ($row = mysqli_fetch_assoc($result_keranjang)) {
    $items[] = $row;
    $total_bayar += ($row['jumlah'] * $row['harga_jual']);
    // Kurangi stok di database
    $id_prod = $row['id_produk'];
    $qty = $row['jumlah'];
    mysqli_query($koneksi, "UPDATE t_produk SET stok = GREATEST(0, stok - $qty) WHERE id_produk = '$id_prod'");
}

// Bersihkan keranjang belanja
mysqli_query($koneksi, "DELETE FROM t_pesanan WHERE id_user_pelanggan = '$id_user_pelanggan'");

$no_invoice = "INV-" . date("Ymd") . "-" . rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Kelontong Segar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">check_circle</span>
        <span>Pesanan Anda berhasil dikonfirmasi dan sedang disiapkan oleh petugas toko!</span>
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
                    <span class="brand-subtitle">Status Pembayaran</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="dashboard_pelanggan.php" class="nav-link">
                    <span class="icon">dashboard</span>
                    Dashboard
                </a>
                <a href="../logout.php" class="btn btn-secondary btn-sm">
                    <span class="icon">logout</span>
                    Keluar
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-wrapper">
        <div style="max-width: 600px; margin: 0 auto;">
            
            <div class="card-glass fade-in" style="text-align: center; padding: var(--space-5);">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--accent-green-bg); color: var(--accent-green); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-3);">
                    <span class="icon" style="font-size: 38px;">task_alt</span>
                </div>

                <h2>Pesanan Berhasil Diterima!</h2>
                <p style="color: var(--text-secondary); margin-top: 6px; margin-bottom: var(--space-4);">
                    Terima kasih, <strong><?php echo htmlspecialchars($nama_pelanggan); ?></strong>. Pesanan Anda akan segera diproses oleh kasir dan kurir kami.
                </p>

                <!-- Invoice Details Box -->
                <div style="background: var(--surface-alt); border-radius: var(--radius-md); padding: var(--space-4); text-align: left; margin-bottom: var(--space-4);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: var(--font-sm);">
                        <span style="color: var(--text-muted);">Nomor Invoice:</span>
                        <strong><?php echo $no_invoice; ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: var(--font-sm);">
                        <span style="color: var(--text-muted);">Waktu Pemesanan:</span>
                        <span><?php echo date("d M Y, H:i"); ?> WIB</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: var(--font-sm);">
                        <span style="color: var(--text-muted);">Metode Pembayaran:</span>
                        <span>Bayar di Tempat (COD / QRIS)</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-top: 1px dashed var(--surface-border); padding-top: 10px; margin-top: 10px;">
                        <span style="font-weight: 700;">Total Pembayaran:</span>
                        <strong style="color: var(--primary); font-size: var(--font-md);">Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></strong>
                    </div>
                </div>

                <div style="display: flex; gap: var(--space-3); justify-content: center;">
                    <a href="produk.php" class="btn btn-primary">
                        <span class="icon">shopping_bag</span>
                        Belanja Lagi
                    </a>
                    <a href="dashboard_pelanggan.php" class="btn btn-secondary">
                        <span class="icon">home</span>
                        Ke Dashboard
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Pesanan Segar &amp; Terpercaya.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Kelontong Segar.
            </div>
        </div>
    </footer>

</body>
</html>
