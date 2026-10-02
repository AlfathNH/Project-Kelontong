<?php
// kasir/dashboard_kasir.php
include '../config/koneksi.php';

// Cek apakah sudah login dan levelnya benar
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: ../index.php");
    exit();
}

$nama_kasir = $_SESSION['nama_lengkap'];

// Ambil info produk untuk kasir
$q_prod = mysqli_query($koneksi, "SELECT COUNT(*) as total_prod FROM t_produk");
$d_prod = mysqli_fetch_assoc($q_prod);

$q_list = mysqli_query($koneksi, "SELECT * FROM t_produk ORDER BY nama_produk ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Kelontong Segar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span class="icon">point_of_sale</span>
        <span>Sistem Kasir (Point of Sale) Aktif &bull; Tanggal: <?php echo date('d M Y'); ?></span>
    </div>

    <!-- Main Navigation Header -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="dashboard_kasir.php" class="brand-logo">
                <div class="brand-icon">
                    <span class="icon">storefront</span>
                </div>
                <div>
                    <span class="brand-title">Kelontong Segar</span>
                    <span class="brand-subtitle">Terminal Layanan Kasir</span>
                </div>
            </a>

            <div class="nav-links">
                <span class="nav-user-badge">
                    <span class="icon" style="color: var(--primary); font-size: 18px;">badge</span>
                    <?php echo htmlspecialchars($nama_kasir); ?> (Kasir)
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
                    <span class="icon" style="color: var(--primary);">store</span>
                    <span>Terminal Kasir Siap Melayani</span>
                </div>
                <h1 class="hero-title">
                    Selamat Bertugas, <span class="hero-title-highlight"><?php echo htmlspecialchars($nama_kasir); ?></span>!
                </h1>
                <p class="hero-description">
                    Layani transaksi belanja pelanggan toko kelontong dengan cepat, ramah, dan teliti. Gunakan tabel pencarian cepat di bawah untuk mengecek harga barang.
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
                    <div class="stat-value"><?php echo $d_prod['total_prod']; ?> Item</div>
                    <div class="stat-title">Produk Terdaftar</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(22, 163, 74, 0.1); color: var(--accent-green);">
                    <span class="icon">check_circle</span>
                </div>
                <div>
                    <div class="stat-value">Aktif</div>
                    <div class="stat-title">Status Shift Kasir</div>
                </div>
            </div>

            <div class="stat-tile">
                <div class="stat-icon" style="background: rgba(2, 132, 199, 0.1); color: var(--accent-blue);">
                    <span class="icon">receipt</span>
                </div>
                <div>
                    <div class="stat-value">Siap Cetak</div>
                    <div class="stat-title">Printer Struk Kasir</div>
                </div>
            </div>
        </div>

        <!-- Cashier Actions Menu -->
        <div style="margin-top: var(--space-5);">
            <div class="catalog-title" style="margin-bottom: var(--space-4);">
                <h2>Aksi Transaksi Kasir</h2>
                <p>Pilih operasi yang ingin dilakukan pada meja kasir</p>
            </div>

            <div class="menu-grid fade-in">
                <a href="#" class="menu-card" onclick="alert('Menu Input Transaksi Kasir POS'); return false;">
                    <div class="menu-icon">
                        <span class="icon">add_shopping_cart</span>
                    </div>
                    <div>
                        <div class="menu-title">Input Transaksi Penjualan (POS)</div>
                        <div class="menu-desc">Scan barcode atau pilih barang belanjaan pelanggan</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="alert('Menu Catat Pengeluaran Operasional'); return false;">
                    <div class="menu-icon">
                        <span class="icon">paid</span>
                    </div>
                    <div>
                        <div class="menu-title">Catat Pengeluaran Kasir</div>
                        <div class="menu-desc">Catat kas kecil, pembelian kantong plastik, atau es batu</div>
                    </div>
                </a>

                <a href="#" class="menu-card" onclick="document.getElementById('quick-search').focus();">
                    <div class="menu-icon">
                        <span class="icon">search</span>
                    </div>
                    <div>
                        <div class="menu-title">Cek Cepat Harga Produk</div>
                        <div class="menu-desc">Cari nama produk untuk mengetahui harga dan sisa stok</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Price Lookup Table -->
        <div style="margin-top: var(--space-6);">
            <div class="catalog-header">
                <div class="catalog-title">
                    <h2>Referensi Cepat Harga &amp; Stok Produk</h2>
                    <p>Daftar harga jual untuk panduan kasir</p>
                </div>
                <div style="width: 280px;">
                    <input type="text" id="quick-search" placeholder="Cari nama produk..." class="form-control" onkeyup="filterTable()">
                </div>
            </div>

            <div class="table-container fade-in">
                <table class="kelontong-table" id="productTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Nama Produk Sembako</th>
                            <th>Harga Jual</th>
                            <th>Sisa Stok</th>
                            <th>Status Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($q_list)): ?>
                        <tr>
                            <td>#<?php echo $item['id_produk']; ?></td>
                            <td><strong><?php echo htmlspecialchars($item['nama_produk']); ?></strong></td>
                            <td><strong style="color: var(--primary);">Rp <?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></strong></td>
                            <td><?php echo $item['stok']; ?> unit</td>
                            <td>
                                <?php if ($item['stok'] > 0): ?>
                                    <span style="background: var(--accent-green-bg); color: var(--accent-green); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700;">
                                        Tersedia
                                    </span>
                                <?php else: ?>
                                    <span style="background: var(--accent-red-bg); color: var(--accent-red); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700;">
                                        Habis
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

    <script>
    function filterTable() {
        var input = document.getElementById("quick-search");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("productTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                var txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
    </script>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div>
                <strong>Kelontong Segar</strong> &bull; Terminal Kasir Toko.
            </div>
            <div>
                &copy; <?php echo date('Y'); ?> Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>