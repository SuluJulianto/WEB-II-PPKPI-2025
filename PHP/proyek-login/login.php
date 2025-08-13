<?php

require_once 'config/db.php';
$errors = [];

if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['is_admin'] == 1 ? 'admin_dashboard.php' : 'dashboard.php'));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "Username dan Password tidak boleh kosong.";
    } else {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT id, username, password, is_admin FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];

                $now = date('Y-m-d H:i:s');
                $update_stmt = $pdo->prepare("UPDATE users SET status = 'online', last_login = ? WHERE id = ?");
                $update_stmt->execute([$now, $user['id']]);

                header("Location: " . ($user['is_admin'] == 1 ? 'admin_dashboard.php' : 'dashboard.php'));
                exit();
            } else {
                $errors[] = "Username atau Password salah.";
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
    <title>Login - Aplikasi Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <form action="login.php" method="post" class="auth-form">
            <h2><i class="fas fa-lock"></i> Secure Login</h2>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'registered'): ?>
                <div class="success-box"><p>Registrasi berhasil! Silakan login.</p></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="error-box"><?php foreach ($errors as $error): ?><p><?php echo $error; ?></p><?php endforeach; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <i class="fas fa-key"></i>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p class="switch-form">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </form>
    </div>
</body>
</html>