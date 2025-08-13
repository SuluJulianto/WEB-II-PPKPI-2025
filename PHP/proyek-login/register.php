<?php
require_once 'config/db.php';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (empty($username)) { $errors[] = "Username tidak boleh kosong."; }
    if (empty($email)) { $errors[] = "Email tidak boleh kosong."; }
    if (empty($password)) { $errors[] = "Password tidak boleh kosong."; }
    if ($password !== $confirm_password) { $errors[] = "Konfirmasi password tidak cocok."; }
    if (empty($errors)) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $errors[] = "Username atau Email sudah terdaftar.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt_insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                if ($stmt_insert->execute([$username, $email, $hashed_password])) {
                    header("Location: login.php?status=registered");
                    exit();
                } else {
                    $errors[] = "Terjadi kesalahan. Gagal mendaftar.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Error database: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <form action="register.php" method="post" class="auth-form">
            <h2><i class="fas fa-user-plus"></i> Buat Akun Baru</h2>
            <?php if (!empty($errors)): ?>
                <div class="error-box"><?php foreach ($errors as $error): ?><p><?php echo $error; ?></p><?php endforeach; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Pilih username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Masukkan email valid" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <i class="fas fa-key"></i>
                <input type="password" id="password" name="password" placeholder="Buat password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <i class="fas fa-key"></i>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn">Daftar</button>
            <p class="switch-form">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>
</body>
</html>