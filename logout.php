<?php
include 'config/koneksi.php'; // Panggil koneksi untuk memastikan session_start() sudah terpanggil

session_unset();

session_destroy();

header("Location: index.php");
exit();
?>