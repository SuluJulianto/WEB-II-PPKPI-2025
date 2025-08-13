<?php
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id_to_view = $_GET['id'];
$pdo = db();

try {
    $stmt = $pdo->prepare("SELECT username, avatar, status FROM users WHERE id = ? AND is_admin = 0");
    $stmt->execute([$user_id_to_view]);
    $user = $stmt->fetch();
    if (!$user) {
        header("Location: dashboard.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error mengambil data profil: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile-card {
            text-align: center;
            padding: 40px;
        }
        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--primary-color);
            margin-bottom: 20px;
        }
        .profile-card h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .profile-card .status {
            font-size: 16px;
        }
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
                <h1>Detail Pengguna</h1>
                <a href="dashboard.php" style="text-decoration: underline;">&larr; Kembali ke Dashboard</a>
            </header>
            <div class="content-box">
                <div class="profile-card">
                    <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar">
                    <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                    <div class="status">
                        <span class="status-dot <?php echo $user['status']; ?>"></span>
                        <?php echo ucfirst($user['status']); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>