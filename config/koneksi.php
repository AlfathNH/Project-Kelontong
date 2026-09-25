<?php
// config/koneksi.php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "Pdb_tokokkelontong";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Langsung aktifkan session di sini agar semua file terhubung
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>