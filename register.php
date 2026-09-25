<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Akun - Toko Kelontong</title>
</head>
<body>
    <h2>Daftar Akun Pelanggan Baru</h2>

    <form action="register_proses.php" method="POST">
        <div>
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" required>
        </div>
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Daftar Sekarang</button>
        </div>
    </form>
    
    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
</body>
</html>