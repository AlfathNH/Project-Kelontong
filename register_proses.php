<?php
// register_proses.php
include 'config/koneksi.php';

$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password_dari_form = $_POST['password'];
$level = "pelanggan"; // Pendaftaran hanya untuk pelanggan

// Enkripsi password
$password_hashed = password_hash($password_dari_form, PASSWORD_DEFAULT);

// Query INSERT ke t_user (Panah: 1.2 Register -> User)
$query = "INSERT INTO t_user (nama_lengkap, username, password, level) 
          VALUES ('$nama_lengkap', '$username', '$password_hashed', '$level')";

if (mysqli_query($koneksi, $query)) {
    // Aliran data [Info Register] ke Kasir (jika diperlukan)
    // Untuk sekarang, kita kirim info ke pelanggan:
    echo "Registrasi berhasil! Silakan <a href='index.php'>login</a>.";
} else {
    echo "Registrasi gagal: " . mysqli_error($koneksi);
}
?>