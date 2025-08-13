<?php
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = db();
    $stmt = $pdo->query("SELECT id, username, email, avatar, tgl_register, last_login, status, is_admin FROM users ORDER BY id ASC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data pengguna: " . $e->getMessage());
}

$current_admin = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title>Admin Dashboard - Aplikasi Pengguna</title>
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
            <div class="sidebar-footer">
                <p>&copy; <?php echo date('Y'); ?> Aplikasi Pengguna</p>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <h1>Manajemen Pengguna</h1>
                <p>Selamat datang, <?php echo htmlspecialchars($current_admin); ?>. Kelola pengguna dari sini.</p>
            </header>

            <div class="content-box">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 60px;">Avatar</th>
                                <th>Username & Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Tgl Registrasi</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach($users as $row): ?>
                                    <tr>
                                        <td>
                                            <?php if ($row['is_admin'] == 1): ?>
                                                <img src="assets/images/admin_avatar.jpg" alt="Admin" class="avatar-sm" style="margin-right: 0;">
                                            <?php else: ?>
                                                <img src="uploads/<?php echo htmlspecialchars($row['avatar']); ?>" alt="Avatar" class="avatar-sm" style="margin-right: 0;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="username-text"><?php echo htmlspecialchars($row['username']); ?></div>
                                            <div class="email-text"><?php echo htmlspecialchars($row['email']); ?></div>
                                        </td>
                                        <td><?php echo ($row['is_admin'] == 1) ? 'Admin' : 'User'; ?></td>
                                        <td>
                                            <span class="status-dot <?php echo $row['status']; ?>"></span>
                                            <?php echo ucfirst($row['status']); ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($row['tgl_register'])); ?></td>
                                        <td>
                                            <?php echo $row['last_login'] ? date('d M Y, H:i', strtotime($row['last_login'])) : '-'; ?>
                                        </td>
                                        
                                        <td>
                                            <?php if ($row['is_admin'] == 0): ?>
                                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" title="Edit User"><i class="fas fa-pen"></i></a>
                                            <?php endif; ?>
                                            
                                            <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" title="Hapus User" style="color: var(--danger-color); margin-left:10px;"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7">Tidak ada data pengguna.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>