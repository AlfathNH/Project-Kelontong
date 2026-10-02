<?php
// index.php - Login & Portal Toko Kelontong
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, langsung alihkan ke dashboard masing-masing
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
    <title>Kelontong Segar - Masuk Sistem & Toko Sembako</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">local_shipping</span>
        <span>Belanja Warung Serba Praktis! Pengantaran Cepat &amp; Gratis Ongkir min. belanja Rp 30.000 dengan kode: <strong>BERKAHWARUNG</strong></span>
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
                <span class="nav-user-badge">
                    <span class="icon" style="color: var(--accent-green); font-size: 16px;">schedule</span>
                    Buka Setiap Hari 06:00 - 22:00 WIB
                </span>
                <a href="register.php" class="btn btn-secondary btn-sm">
                    <span class="icon">person_add</span>
                    Daftar Pelanggan
                </a>
            </div>
        </div>
    </header>

    <!-- Main Golden Ratio Layout -->
    <main class="main-wrapper">
        
        <!-- Golden Hero Split: 61.8% Showcase / 38.2% Auth Card -->
        <section class="golden-hero-split">
            
            <!-- Left Hero Showcase (~61.8%) -->
            <div class="card-showcase fade-in">
                <div>
                    <div class="hero-badge">
                        <span class="icon" style="color: var(--primary);">verified</span>
                        <span>Sistem Informasi Toko Kelontong Modern</span>
                    </div>

                    <h1 class="hero-title">
                        Kebutuhan Dapur &amp; Sembako Lengkap, <br>
                        <span class="hero-title-highlight">Harga Warung Tetap Hemat.</span>
                    </h1>

                    <p class="hero-description">
                        Pesan kebutuhan harian keluarga mulai dari beras premium, minyak goreng, telur ayam negeri segar, hingga bumbu racik tradisional dengan jaminan harga jujur dan takaran pas.
                    </p>

                    <!-- Category Pills -->
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
                        <span class="role-badge-item">🌾 Beras &amp; Biji-bijian</span>
                        <span class="role-badge-item">🍳 Minyak &amp; Telur</span>
                        <span class="role-badge-item">🌶️ Bumbu &amp; Rempah</span>
                        <span class="role-badge-item">☕ Kopi, Teh &amp; Gula</span>
                        <span class="role-badge-item">🧼 Perawatan Rumah</span>
                    </div>
                </div>

                <!-- Golden Fibonacci Trust & Stats Matrix -->
                <div class="hero-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span class="icon">inventory_2</span>
                        </div>
                        <div>
                            <div class="feature-value">1.200+</div>
                            <div class="feature-label">Produk Warung</div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <span class="icon">timer</span>
                        </div>
                        <div>
                            <div class="feature-value">15 Menit</div>
                            <div class="feature-label">Layanan Cepat</div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <span class="icon">scale</span>
                        </div>
                        <div>
                            <div class="feature-value">100% Pas</div>
                            <div class="feature-label">Timbangan Akurat</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Authentication Card (~38.2%) -->
            <div class="card-glass fade-in" id="auth-box">
                <div class="auth-header">
                    <h2>Masuk ke Akun</h2>
                    <p>Silakan masuk menggunakan username &amp; password Anda</p>
                </div>

                <div class="promo-chip">
                    <span class="icon">celebration</span>
                    <span><strong>Promo Berkah:</strong> Akses kupon potongan belanja Rp 25.000 untuk pelanggan baru!</span>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <span class="icon">error</span>
                        <span>Username atau Password salah! Periksa kembali data login Anda.</span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['registered'])): ?>
                    <div class="alert alert-success">
                        <span class="icon">check_circle</span>
                        <span>Pendaftaran berhasil! Silakan masuk dengan akun baru Anda.</span>
                    </div>
                <?php endif; ?>

                <form action="login_proses.php" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-wrapper">
                            <span class="icon input-icon">person</span>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrapper">
                            <span class="icon input-icon">lock</span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 16px;">
                        <span>Masuk Sekarang</span>
                        <span class="icon">arrow_forward</span>
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; font-size: var(--font-sm); color: var(--text-secondary);">
                    Belum punya akun? <a href="register.php" style="font-weight: 700;">Daftar sebagai Pelanggan</a>
                </div>

                <!-- Akun Pengujian Cepat (Role Quick Guide) -->
                <div class="role-hint-card">
                    <div class="role-hint-title">
                        <span class="icon" style="font-size: 16px;">key</span>
                        Akun Uji Coba (Demo Credentials)
                    </div>
                    <div class="role-badges">
                        <div class="role-badge-item">
                            <strong>Pemilik:</strong> pemilik / admin123
                        </div>
                        <div class="role-badge-item">
                            <strong>Kasir:</strong> kasir / kasir123
                        </div>
                        <div class="role-badge-item">
                            <strong>Pelanggan:</strong> budi / budi123
                        </div>
                    </div>
                </div>

            </div>

        </section>

        <!-- Product Preview Section -->
        <section style="margin-top: var(--space-6);">
            <div class="catalog-header">
                <div class="catalog-title">
                    <h2>Etalase Produk Unggulan Warung</h2>
                    <p>Pilihan sembako berkualitas dengan harga terbaik setiap hari</p>
                </div>
                <a href="register.php" class="btn btn-secondary btn-sm">
                    <span class="icon">shopping_bag</span>
                    Mulai Belanja
                </a>
            </div>

            <div class="product-grid">
                <!-- Card 1 -->
                <div class="product-card">
                    <div class="product-thumb">
                        <span class="product-badge-fresh">Paling Laris</span>
                        <span class="icon">rice_bowl</span>
                    </div>
                    <div class="product-name">Beras Pandan Wangi Premium 5kg</div>
                    <div class="product-stock">
                        <span class="icon" style="font-size: 14px; color: var(--accent-green);">check_circle</span>
                        Stok Tersedia (25 Sak)
                    </div>
                    <div class="product-price">Rp 75.000</div>
                    <div class="product-actions">
                        <a href="index.php#auth-box" class="btn btn-secondary btn-block btn-sm">
                            <span class="icon">login</span>
                            Login untuk Beli
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="product-card">
                    <div class="product-thumb">
                        <span class="product-badge-fresh">Promo Hemat</span>
                        <span class="icon">oil_barrel</span>
                    </div>
                    <div class="product-name">Minyak Goreng Sania Royale 2 Liter</div>
                    <div class="product-stock">
                        <span class="icon" style="font-size: 14px; color: var(--accent-green);">check_circle</span>
                        Stok Tersedia (40 Pch)
                    </div>
                    <div class="product-price">Rp 34.500</div>
                    <div class="product-actions">
                        <a href="index.php#auth-box" class="btn btn-secondary btn-block btn-sm">
                            <span class="icon">login</span>
                            Login untuk Beli
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="product-card">
                    <div class="product-thumb">
                        <span class="product-badge-fresh">Segar Harian</span>
                        <span class="icon">egg</span>
                    </div>
                    <div class="product-name">Telur Ayam Negeri Segar 1kg</div>
                    <div class="product-stock">
                        <span class="icon" style="font-size: 14px; color: var(--accent-green);">check_circle</span>
                        Stok Tersedia (50 Kg)
                    </div>
                    <div class="product-price">Rp 28.000</div>
                    <div class="product-actions">
                        <a href="index.php#auth-box" class="btn btn-secondary btn-block btn-sm">
                            <span class="icon">login</span>
                            Login untuk Beli
                        </a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="product-card">
                    <div class="product-thumb">
                        <span class="icon">bakery_dining</span>
                    </div>
                    <div class="product-name">Gula Pasir Gulaku Tebu 1kg</div>
                    <div class="product-stock">
                        <span class="icon" style="font-size: 14px; color: var(--accent-green);">check_circle</span>
                        Stok Tersedia (60 Bks)
                    </div>
                    <div class="product-price">Rp 17.500</div>
                    <div class="product-actions">
                        <a href="index.php#auth-box" class="btn btn-secondary btn-block btn-sm">
                            <span class="icon">login</span>
                            Login untuk Beli
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Sistem Informasi &amp; E-Commerce Toko Kelontong Tradisional Modern.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Hak Cipta Dilindungi. Dibuat dengan Golden Ratio Rule &amp; Google Stitch Design System.
            </div>
        </div>
    </footer>

</body>
</html>