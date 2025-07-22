<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di Sistem Informasi Perpustakaan</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Perpustakaan</a>
            <div class="navbar-nav ml-auto">
                <a href="katalog_buku.php" class="nav-item nav-link">Katalog Buku</a>
                <a href="login.php" class="nav-item nav-link">Login</a>
                <a href="register.php" class="btn btn-light ml-2">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <div class="jumbotron text-center">
            <h1 class="display-4">Selamat Datang!</h1>
            <p class="lead">Ini adalah Sistem Informasi Perpustakaan berbasis web yang siap membantu Anda.</p>
            <hr class="my-4">
            <p>Temukan buku favorit Anda di katalog kami atau masuk untuk memulai peminjaman.</p>
            <a class="btn btn-primary btn-lg" href="katalog_buku.php" role="button">Lihat Katalog Buku</a>
            <a class="btn btn-success btn-lg" href="login.php" role="button">Login Anggota</a>
        </div>

        <div class="row text-center">
            <div class="col-md-4">
                <h4>Koleksi Lengkap</h4>
                <p>Ribuan judul buku dari berbagai kategori siap untuk Anda baca.</p>
            </div>
            <div class="col-md-4">
                <h4>Peminjaman Mudah</h4>
                <p>Proses peminjaman dan pengembalian yang cepat dan tercatat secara digital.</p>
            </div>
            <div class="col-md-4">
                <h4>Akses Di Mana Saja</h4>
                <p>Cek ketersediaan buku favorit Anda kapan saja dan di mana saja.</p>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4 p-3 bg-light">
        <p>&copy; <?php echo date('Y'); ?> Sistem Informasi Perpustakaan</p>
    </footer>
</body>
</html>