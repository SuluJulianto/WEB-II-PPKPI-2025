<?php
// Mulai session
session_start();

// Cek apakah user sudah login dan levelnya adalah anggota
if (!isset($_SESSION['status']) || $_SESSION['level'] != "anggota") {
    // Arahkan kembali ke halaman login dengan pesan
    header("location:../login.php?pesan=belumlogin");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Anggota</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Dashboard Anggota</a>
            <div class="navbar-nav ml-auto">
                <a href="../katalog_buku.php" class="nav-item nav-link">Katalog Buku</a>
                <span class="nav-item nav-link text-white">Halo, <b><?php echo htmlspecialchars($_SESSION['nama']); ?></b></span>
                <a href="ganti_password.php" class="nav-item nav-link">Ganti Password</a>
                <a href="../logout.php" class="nav-item nav-link">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 20px;">