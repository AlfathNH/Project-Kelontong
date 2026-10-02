<?php
// admin/dashboard_pemilik.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'pemilik') {
    header("Location: ../index.php");
    exit();
}

$nama_pemilik = $_SESSION['nama_lengkap'];

// Ambil statistik ringkas untuk pemilik
$q_prod = mysqli_query($koneksi, "SELECT COUNT(*) as total_prod, SUM(stok) as total_stok, SUM(harga_jual * stok) as total_aset FROM t_produk");
$d_prod = mysqli_fetch_assoc($q_prod);

$q_user = mysqli_query($koneksi, "SELECT COUNT(*) as total_user FROM t_user");
$d_user = mysqli_fetch_assoc($q_user);

// Ambil daftar produk terkini
$q_list_prod = mysqli_query($koneksi, "SELECT * FROM t_produk ORDER BY stok ASC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - Toko Kelontong</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">admin_panel_settings</span>
        <span>Panel Administrasi &amp; Manajemen Pemilik Toko Kelontong Segar</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="dashboard_pemilik.php" class="brand-logo">
                <div class="brand-icon">
                    <span class="icon">storefront</span>
                </div>
                <div>
                    <span class="brand-title">Kelontong Segar</span>
                    <span class="brand-subtitle">Panel Pemilik Toko (Owner)</span>
                </div>
            </a>

            <div class="nav-links">
                <span class="nav-user-badge">
                    <span class="icon" style="color: var(--primary); font-size: 18px;">shield_person</span>
                    <?php echo htmlspecialchars($nama_pemilik); ?> (Pemilik)
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
                    <span class="icon" style="color: var(--primary);">verified</span>
                    <span>Hak Akses: Pemilik Toko</span>
                </div>
                <h1 class="hero-title">
                    Selamat Datang, <span class="hero-title-highlight"><?php echo htmlspecialchars($nama_pemilik); ?></span>!
                </h1>
                <p class="hero-description">
                    Pantau kinerja penjualan, ketersediaan inventaris sembako, dan operasional kasir secara terpusat dan real-time.
                </p>
            </div>
        </div>

        <!-- Metric Statistics Cards -->
        <div class="stats-grid fade-in">
            <div class="stat-tile">
                <div class="stat-icon">
                    <span class="icon">inventory_2</span>
                </div>
                <div>
                    <div class="stat-value"><?php echo $d_prod['total_prod']; ?> Macam</div>
                    <div class="stat-title">Jenis Produk Sembako</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(22, 163, 74, 0.1); color: var(--accent-green);">
                    <span class="icon">layers</span>
                </div>
                <div>
                    <div class="stat-value"><?php echo $d_prod['total_stok'] ? $d_prod['total_stok'] : 0; ?> Unit</div>
                    <div class="stat-title">Total Stok Gudang</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(2, 132, 199, 0.1); color: var(--accent-blue);">
                    <span class="icon">group</span>
                </div>
                <div>
                    <div class="stat-value"><?php echo $d_user['total_user']; ?> Akun</div>
                    <div class="stat-title">Pengguna Terdaftar</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(255, 107, 0, 0.12); color: var(--primary);">
                    <span class="icon">account_balance_wallet</span>
                </div>
                <div>
                    <div class="stat-value">Rp <?php echo number_format($d_prod['total_aset'] ? $d_prod['total_aset'] : 0, 0, ',', '.'); ?></div>
                    <div class="stat-title">Estimasi Nilai Aset Stok</div>
                </div>
            </div>
        </div>

        <!-- Management Menu Grid -->
        <div style="margin-top: var(--space-5);">
            <div class="catalog-title" style="margin-bottom: var(--space-4);">
                <h2>Modul Manajemen Operasional Toko</h2>
                <p>Pilih modul untuk mengelola data master, laporan, dan promosi</p>
            </div>

            <div class="menu-grid fade-in">
                <a href="#" class="menu-card" onclick="alert('Modul Kelola Data Produk'); return false;">
                    <div class="menu-icon">
                        <span class="icon">category</span>
                    </div>
                    <div>
                        <div class="menu-title">Kelola Data Produk</div>
                        <div class="menu-desc">Tambah, ubah harga, dan perbarui stok sembako</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Modul Kelola Data Pengguna'); return false;">
                    <div class="menu-icon">
                        <span class="icon">manage_accounts</span>
                    </div>
                    <div>
                        <div class="menu-title">Kelola Data Pengguna</div>
                        <div class="menu-desc">Manajemen akun kasir dan pelanggan terdaftar</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Modul Kelola Promosi'); return false;">
                    <div class="menu-icon">
                        <span class="icon">campaign</span>
                    </div>
                    <div>
                        <div class="menu-title">Kelola Promosi</div>
                        <div class="menu-desc">Buat kupon diskon dan potongan belanja warung</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Modul Laporan Penjualan'); return false;">
                    <div class="menu-icon">
                        <span class="icon">analytics</span>
                    </div>
                    <div>
                        <div class="menu-title">Laporan Penjualan</div>
                        <div class="menu-desc">Analisis omset harian, mingguan, dan bulanan</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Modul Laporan Pengeluaran Kasir'); return false;">
                    <div class="menu-icon">
                        <span class="icon">payments</span>
                    </div>
                    <div>
                        <div class="menu-title">Laporan Pengeluaran Kasir</div>
                        <div class="menu-desc">Audit catatan kas kecil dan biaya operasional</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Inventory Alert Preview Table -->
        <div style="margin-top: var(--space-6);">
            <div class="catalog-header">
                <div class="catalog-title">
                    <h2>Monitoring Stok Inventaris Terendah</h2>
                    <p>Periksa produk dengan stok sedikit yang perlu diisi ulang (restock)</p>
                </div>
            </div>

            <div class="table-container fade-in">
                <table class="kelontong-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Harga Jual</th>
                            <th>Sisa Stok</th>
                            <th>Status Inventaris</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($prod = mysqli_fetch_assoc($q_list_prod)): ?>
                        <tr>
                            <td>#<?php echo $prod['id_produk']; ?></td>
                            <td><strong><?php echo htmlspecialchars($prod['nama_produk']); ?></strong></td>
                            <td>Rp <?php echo number_format($prod['harga_jual'], 0, ',', '.'); ?></td>
                            <td><strong><?php echo $prod['stok']; ?> pcs</strong></td>
                            <td>
                                <?php if ($prod['stok'] <= 15): ?>
                                    <span style="background: var(--accent-red-bg); color: var(--accent-red); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700;">
                                        Perlu Restock
                                    </span>
                                <?php else: ?>
                                    <span style="background: var(--accent-green-bg); color: var(--accent-green); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700;">
                                        Aman
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Panel Administrasi Pemilik Toko.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>