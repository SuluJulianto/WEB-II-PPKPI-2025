<?php
// Selalu mulai session di awal untuk memeriksa status login
session_start();
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Katalog Buku - Perpustakaan</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Perpustakaan</a>
            <div class="navbar-nav ml-auto">
                <?php
                // Cek apakah pengguna sudah login sebagai anggota
                if (isset($_SESSION['status']) && $_SESSION['level'] == "anggota") {
                ?>
                    <a href="member/index.php" class="nav-item nav-link">Dashboard Saya</a>
                    <span class="nav-item nav-link text-white">|</span>
                    <span class="nav-item nav-link text-white">Halo, <b><?php echo htmlspecialchars($_SESSION['nama']); ?></b></span>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                <?php
                } else {
                ?>
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="login.php" class="btn btn-light ml-2">Login</a>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 20px;">
        <div class="page-header mb-4">
            <h3>Katalog Buku Tersedia</h3>
            <p>Berikut adalah daftar buku yang tersedia untuk dipinjam.</p>
        </div>

        <div class="row">
            <?php
            $query = "SELECT * FROM buku WHERE status_buku = '1' ORDER BY judul_buku ASC";
            $data = mysqli_query($koneksi, $query);
            if (mysqli_num_rows($data) > 0) {
                while ($b = mysqli_fetch_array($data)) {
            ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="assets/upload/<?php echo $b['gambar'] ? htmlspecialchars($b['gambar']) : 'default.png'; ?>" class="card-img-top" alt="Cover Buku" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($b['judul_buku']); ?></h5>
                                <p class="card-text small text-muted">
                                    <?php echo htmlspecialchars($b['pengarang']); ?>
                                </p>
                                <div class="mt-auto text-center">
                                    <a href="login.php?pesan=haruslogin" class="btn btn-primary btn-sm">Pinjam Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col-12'><div class='alert alert-warning'>Saat ini tidak ada buku yang tersedia untuk dipinjam.</div></div>";
            }
            ?>
        </div>
    </div>

    <footer class="text-center mt-4 p-3 bg-light">
        <p>&copy; <?php echo date('Y'); ?> Sistem Informasi Perpustakaan</p>
    </footer>
</body>
</html>