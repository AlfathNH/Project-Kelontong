<?php
// register_proses.php
include 'config/koneksi.php';

$nama_lengkap = mysqli_real_escape_string($koneksi, trim($_POST['nama_lengkap']));
$username     = mysqli_real_escape_string($koneksi, trim($_POST['username']));
$password_raw = $_POST['password'];
$level        = "pelanggan"; // Pendaftaran hanya untuk pelanggan

// Cek apakah username sudah pernah digunakan
$cek_user = mysqli_query($koneksi, "SELECT * FROM t_user WHERE username='$username'");
if (mysqli_num_rows($cek_user) > 0) {
    header("Location: register.php?error=Username sudah terdaftar! Gunakan username lain.");
    exit();
}

// Enkripsi password
$password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

// Query INSERT ke t_user (Panah: 1.2 Register -> User)
$query = "INSERT INTO t_user (nama_lengkap, username, password, level) 
          VALUES ('$nama_lengkap', '$username', '$password_hashed', '$level')";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?registered=1");
    exit();
} else {
    header("Location: register.php?error=" . urlencode("Gagal mendaftar: " . mysqli_error($koneksi)));
    exit();
}
?>