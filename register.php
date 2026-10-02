<?php
// register.php - Pendaftaran Pelanggan Toko Kelontong
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['level'])) {
    if ($_SESSION['level'] == 'pemilik') {
        header("Location: admin/dashboard_pemilik.php");
        exit();
    } else if ($_SESSION['level'] == 'kasir') {
        header("Location: kasir/dashboard_kasir.php");
        exit();
    } else if ($_SESSION['level'] == 'pelanggan') {
        header("Location: pelanggan/dashboard_pelanggan.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Kelontong Segar</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">local_shipping</span>
        <span>Daftar Akun Pelanggan Sekarang &amp; Nikmati Kemudahan Belanja Kebutuhan Dapur!</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="brand-logo">
                <div class="brand-icon">
                    <span class="icon">storefront</span>
                </div>
                <div>
                    <span class="brand-title">Kelontong Segar</span>
                    <span class="brand-subtitle">Sembako Harian &amp; Sayur Segar</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="index.php" class="btn btn-secondary btn-sm">
                    <span class="icon">login</span>
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Golden Ratio Layout -->
    <main class="main-wrapper">
        <div style="max-width: 540px; margin: 0 auto;">
            
            <div class="card-glass fade-in">
                <div class="auth-header">
                    <h2>Daftar Akun Pelanggan</h2>
                    <p>Lengkapi formulir berikut untuk mulai berbelanja di Kelontong Segar</p>
                </div>

                <div class="promo-chip">
                    <span class="icon">loyalty</span>
                    <span><strong>Keuntungan Akun:</strong> Simpan riwayat pesanan, keranjang belanja, &amp; dapatkan harga promo khusus!</span>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <span class="icon">error</span>
                        <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="register_proses.php" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <span class="icon input-icon">badge</span>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-wrapper">
                            <span class="icon input-icon">person</span>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Gunakan huruf kecil atau angka tanpa spasi" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrapper">
                            <span class="icon input-icon">lock</span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 20px;">
                        <span>Daftar Sekarang</span>
                        <span class="icon">how_to_reg</span>
                    </button>
                </form>

                <div style="text-align: center; margin-top: 24px; font-size: var(--font-sm); color: var(--text-secondary);">
                    Sudah terdaftar? <a href="index.php" style="font-weight: 700;">Masuk di sini</a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Sistem Informasi &amp; E-Commerce Toko Kelontong Tradisional Modern.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>