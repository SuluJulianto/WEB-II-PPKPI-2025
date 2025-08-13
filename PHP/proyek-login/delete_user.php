<?php
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$user_id_to_delete = $_GET['id'];
$pdo = db();

if ($user_id_to_delete == $_SESSION['user_id']) {
    header("Location: admin_dashboard.php?error=selfdelete");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id_to_delete]);
        header("Location: admin_dashboard.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        die("Error menghapus pengguna: " . $e->getMessage());
    }
}

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id_to_delete]);
$user = $stmt->fetch();
if (!$user) {
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pengguna - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h2 style="color: var(--danger-color);">Konfirmasi Penghapusan</h2>
            <p style="text-align: center; margin-bottom: 20px;">
                Anda yakin ingin menghapus pengguna dengan username: <strong><?php echo htmlspecialchars($user['username']); ?></strong>?
                <br>
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <form method="post">
                <input type="hidden" name="confirm_delete" value="1">
                <button type="submit" class="btn" style="background-color: var(--danger-color);">Ya, Hapus Pengguna Ini</button>
                <a href="admin_dashboard.php" style="display: block; text-align: center; margin-top: 15px;">Tidak, Batal</a>
            </form>
        </div>
    </div>
</body>
</html>