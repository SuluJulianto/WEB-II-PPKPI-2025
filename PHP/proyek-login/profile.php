<?php
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$message = '';
$error = '';
$pdo = db();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $target_dir = "uploads/";
            $file_extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $target_file = $target_dir . "user_" . $user_id . "_" . time() . "." . $file_extension;
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($file_extension), $allowed_types)) {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                    $avatar_path = basename($target_file);
                    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                    $stmt->execute([$avatar_path, $user_id]);
                } else { $error = "Gagal mengupload gambar."; }
            } else { $error = "Hanya format JPG, JPEG, PNG, & GIF yang diizinkan."; }
        }
        if (empty($error)) {
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $tempat_lahir = trim($_POST['tempat_lahir']);
            $alamat = trim($_POST['alamat']);
            $tempat_tinggal = trim($_POST['tempat_tinggal']);
            $nomor_telepon = trim($_POST['nomor_telepon']);
            $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, tempat_lahir = ?, alamat = ?, tempat_tinggal = ?, nomor_telepon = ? WHERE id = ?");
            $stmt->execute([$nama_lengkap, $tempat_lahir, $alamat, $tempat_tinggal, $nomor_telepon, $user_id]);
            $message = "Profil berhasil diperbarui!";
        }
    } catch (PDOException $e) {
        $error = "Error database: " . $e->getMessage();
    }
}
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (!$user) {
        header("Location: logout.php");
        exit();
    }
} catch (PDOException $e) {
    die("Tidak dapat mengambil data profil: " . $e->getMessage());
}
$is_admin = $_SESSION['is_admin'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil - Aplikasi Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-user-cog"></i> Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="<?php echo $is_admin ? 'admin_dashboard.php' : 'dashboard.php'; ?>"><i class="fas <?php echo $is_admin ? 'fa-users' : 'fa-tachometer-alt'; ?>"></i> Dashboard</a></li>
                    <li><a href="profile.php" class="active"><i class="fas fa-user-edit"></i> Ubah Profil</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <p>&copy; <?php echo date('Y'); ?> Aplikasi Pengguna</p>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <h1>Ubah Profil Anda</h1>
                <p>Perbarui informasi pribadi Anda di bawah ini.</p>
            </header>
            <div class="content-box">
                <form action="profile.php" method="post" enctype="multipart/form-data" class="profile-form">
                    <?php if ($message): ?><div class="success-box"><p><?php echo $message; ?></p></div><?php endif; ?>
                    <?php if ($error): ?><div class="error-box"><p><?php echo $error; ?></p></div><?php endif; ?>
                    <div class="profile-avatar"><img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar saat ini"></div>
                    <div class="form-group"><label for="avatar">Ubah Foto Profil</label><input type="file" id="avatar" name="avatar"></div>
                    <div class="form-group"><label for="username">Username (tidak dapat diubah)</label><input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled></div>
                    <div class="form-group"><label for="email">Email (tidak dapat diubah)</label><input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled></div>
                    <div class="form-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" placeholder="Isi nama lengkap Anda"></div>
                    <div class="form-group"><label for="tempat_lahir">Tempat Lahir</label><input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo htmlspecialchars($user['tempat_lahir']); ?>" placeholder="Kota tempat lahir"></div>
                    <div class="form-group"><label for="alamat">Alamat</label><textarea id="alamat" name="alamat" placeholder="Alamat lengkap sesuai KTP"><?php echo htmlspecialchars($user['alamat']); ?></textarea></div>
                    <div class="form-group"><label for="tempat_tinggal">Tempat Tinggal</label><input type="text" id="tempat_tinggal" name="tempat_tinggal" value="<?php echo htmlspecialchars($user['tempat_tinggal']); ?>" placeholder="Kota domisili saat ini"></div>
                    <div class="form-group"><label for="nomor_telepon">Nomor Telepon</label><input type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($user['nomor_telepon']); ?>" placeholder="Nomor telepon aktif"></div>
                    <button type="submit" class="btn">Simpan Perubahan</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>