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

$user_id_to_edit = $_GET['id'];
$message = '';
$error = '';
$pdo = db();

try {
    $stmt_check = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt_check->execute([$user_id_to_edit]);
    $user_to_edit = $stmt_check->fetch();

    if ($user_to_edit && $user_to_edit['is_admin'] == 1) {
        header("Location: admin_dashboard.php"); 
        exit();
    }
} catch (PDOException $e) {

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nama_lengkap = trim($_POST['nama_lengkap']);
        $email = trim($_POST['email']);
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
        $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, email = ?, is_admin = ? WHERE id = ?");
        $stmt->execute([$nama_lengkap, $email, $is_admin, $user_id_to_edit]);
        $message = "Data pengguna berhasil diperbarui!";

    } catch (PDOException $e) {
        $error = "Error database: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id_to_edit]);
    $user = $stmt->fetch();
    if (!$user) {
        header("Location: admin_dashboard.php");
        exit();
    }
} catch (PDOException $e) {
    die("Tidak dapat mengambil data profil: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-user-cog"></i> Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="admin_dashboard.php" class="active"><i class="fas fa-users"></i> Manajemen User</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="page-header">
                <h1>Edit Pengguna: <?php echo htmlspecialchars($user['username']); ?></h1>
                <p>Ubah informasi pengguna di bawah ini.</p>
            </header>
            <div class="content-box">
                <div class="profile-avatar" style="text-align: left; margin-bottom: 25px;">
                    <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar Pengguna">
                </div>

                <form action="edit_user.php?id=<?php echo $user_id_to_edit; ?>" method="post" class="profile-form">
                    <?php if ($message): ?><div class="success-box"><p><?php echo $message; ?></p></div><?php endif; ?>
                    <?php if ($error): ?><div class="error-box"><p><?php echo $error; ?></p></div><?php endif; ?>
                    
                    <div class="form-group"><label>Username (tidak dapat diubah)</label><input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled></div>
                    <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></div>
                    <div class="form-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>"></div>
                    
                    <div class="form-group">
                        <label>Role Pengguna</label>
                        <div>
                            <input type="checkbox" id="is_admin" name="is_admin" value="1" <?php echo ($user['is_admin'] == 1) ? 'checked' : ''; ?>>
                            <label for="is_admin">Jadikan Admin</label>
                        </div>
                    </div>

                    <button type="submit" class="btn">Simpan Perubahan</button>
                    <a href="admin_dashboard.php" style="display:inline-block; margin-top:15px;">Batal</a>
                </form>
            </div>
        </main>
    </div>
</body>
</html>