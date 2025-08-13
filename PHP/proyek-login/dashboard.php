<?php
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 1) {
        header("Location: admin_dashboard.php");
        exit();
    }
    header("Location: login.php");
    exit();
}

try {
    $pdo = db();
    $stmt = $pdo->query("SELECT id, username, avatar, status FROM users WHERE is_admin = 0 ORDER BY username ASC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data pengguna: " . $e->getMessage());
}

$current_user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        tbody tr { cursor: pointer; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-user-shield"></i> User Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="profile.php"><i class="fas fa-user-edit"></i> Ubah Profil</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <h1>Halo, <?php echo htmlspecialchars($current_user); ?>!</h1>
                <p>Lihat pengguna lain yang ada di sistem. Klik nama pengguna untuk melihat detail.</p>
            </header>

            <div class="content-box">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach($users as $row): ?>
                                    <tr onclick="window.location='view_profile.php?id=<?php echo $row['id']; ?>'">
                                        <td>
                                            <div class="user-info">
                                                <img src="uploads/<?php echo htmlspecialchars($row['avatar']); ?>" alt="Avatar" class="avatar-sm">
                                                <div class="username-text"><?php echo htmlspecialchars($row['username']); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-dot <?php echo $row['status']; ?>"></span>
                                            <?php echo ucfirst($row['status']); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="2">Belum ada pengguna lain.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>