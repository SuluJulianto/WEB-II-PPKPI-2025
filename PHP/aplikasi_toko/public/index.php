<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['site_root'])) {
    $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
}
$site_root = $_SESSION['site_root'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Aplikasi Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(to right, rgba(22, 34, 57, 0.9), rgba(67, 83, 113, 0.9)), url('https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=2070&auto=format&fit=crop') center center no-repeat;
            background-size: cover;
            color: white;
            padding: 120px 0;
        }
        .hero-section h1 { font-weight: 700; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-store-alt text-primary"></i> Aplikasi Toko</a>
        </div>
    </nav>

    <header id="home" class="hero-section text-center">
        <div class="container">
            <h1 class="display-4">Manajemen Toko Menjadi Mudah</h1>
            <p class="lead">Pilih jenis login yang sesuai dengan Anda.</p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="<?= $site_root ?>/public/auth/admin_login.php" class="btn btn-success btn-lg px-4 gap-3">
                    <i class="fas fa-user-shield me-2"></i> Login Karyawan
                </a>
                <a href="<?= $site_root ?>/public/auth/login.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-user me-2"></i> Login atau Daftar User
                </a>
            </div>
        </div>
    </header>

    <footer class="footer py-4 bg-dark text-white">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Aplikasi Toko.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>