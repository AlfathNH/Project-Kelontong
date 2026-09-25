<?php
// login_proses.php
include 'config/koneksi.php';

$username = $_POST['username'];
$password_dari_form = $_POST['password'];

// Query SELECT dari t_user (Panah: User -> 1.1 Login)
$query = "SELECT * FROM t_user WHERE username='$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $password_dari_db = $data['password'];

    // Verifikasi password
    if (password_verify($password_dari_form, $password_dari_db)) {
        // [Info Login] dikirim ke session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['level'] = $data['level'];

        // Alihkan (redirect) halaman berdasarkan level
        if ($data['level'] == "pemilik") {
            header("Location: admin/dashboard_pemilik.php");
        } else if ($data['level'] == "kasir") {
            header("Location: kasir/dashboard_kasir.php");
        } else if ($data['level'] == "pelanggan") {
            header("Location: pelanggan/dashboard_pelanggan.php");
        }
    } else {
        // Password salah
        header("Location: index.php?error=1");
    }
} else {
    // Username tidak ditemukan
    header("Location: index.php?error=1");
}
?>