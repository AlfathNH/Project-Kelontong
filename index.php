<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Kelontong</title>
</head>
<body>
    <h2>LOGIN SISTEM INFORMASI TOKO KELONTONG</h2>
    <p>Silakan login sesuai hak akses Anda.</p>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Username atau Password salah!</p>";
    }
    ?>

    <form action="login_proses.php" method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    
    <p>Belum punya akun? <a href="register.php">Daftar sebagai Pelanggan</a></p>
</body>
</html>