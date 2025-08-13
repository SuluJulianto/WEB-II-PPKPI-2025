<?php
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['User']);

require_once dirname(__DIR__) . '/module/dbconnect.php';

$site_root = $_SESSION['site_root'];
$user_id = $_SESSION['auth_id'];

// Ambil data user saat ini dari database untuk ditampilkan di form
try {
    $stmt = db()->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data pengguna: " . $e->getMessage());
}

// Menampilkan pesan flash (notifikasi) setelah update
$flash_message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil - Aplikasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar-header a { color: #fff; text-decoration: none; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
        .profile-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #dee2e6; }
    </style>
</head>
<body>
    <div class="main-content">
        <?php include '_user_sidebar.php'; // Memanggil sidebar user ?>

        <div class="content">
            <h2 class="mb-0">Ubah Profil Anda</h2>
            <p class="text-muted">Perbarui informasi pribadi Anda di bawah ini.</p>
            <hr>

            <?php if ($flash_message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash_message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="<?= $site_root ?>/user_actions.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="<?= $site_root ?>/public/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="profile-avatar mb-3">
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Ubah Foto Profil</label>
                                    <input class="form-control form-control-sm" type="file" id="avatar" name="avatar">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label>Username (tidak dapat diubah)</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Email (tidak dapat diubah)</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= htmlspecialchars($user['tempat_lahir']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= htmlspecialchars($user['alamat']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_tinggal" class="form-label">Tempat Tinggal</label>
                                    <input type="text" class="form-control" id="tempat_tinggal" name="tempat_tinggal" value="<?= htmlspecialchars($user['tempat_tinggal']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= htmlspecialchars($user['nomor_telepon']) ?>">
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>