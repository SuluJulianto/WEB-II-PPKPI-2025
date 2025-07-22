<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['level'] != "admin") {
    header("location:../login.php?pesan=belumlogin");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Aplikasi Perpustakaan</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/datatable/datatables.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="buku.php">Data Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="anggota.php">Data Anggota</a></li>
                    <li class="nav-item"><a class="nav-link" href="peminjaman.php">Transaksi Peminjaman</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Laporan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                            <a class="dropdown-item" href="laporan_buku.php">Laporan Data Buku</a>
                            <a class="dropdown-item" href="laporan_anggota.php">Laporan Data Anggota</a>
                            <a class="dropdown-item" href="laporan_transaksi.php">Laporan Transaksi</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Halo, <b><?php echo htmlspecialchars($_SESSION['nama']); ?></b>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="ganti_password.php">Ganti Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 20px;">