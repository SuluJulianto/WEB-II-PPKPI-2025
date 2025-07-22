<?php
// /detail_produk.php

include 'core/koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: produk_publik.php');
    exit();
}

$id_produk = $_GET['id'];

$query = "SELECT * FROM produk WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_produk);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    header('Location: produk_publik.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($produk['produk']); ?> - Detail Produk</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="produk_publik.php"><i class="fas fa-robot"></i> TOKO ELEKTRONIK</a>
            <div class="ml-auto"><a class="btn btn-outline-light" href="login.php"><i class="fas fa-sign-in-alt"></i> Admin Login</a></div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="assets/img/<?php echo htmlspecialchars($produk['thumbnail']); ?>" class="card-img" alt="<?php echo htmlspecialchars($produk['produk']); ?>">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($produk['produk']); ?></h2>
                        <p class="card-text"><small class="text-muted">Kategori: <?php echo htmlspecialchars($produk['kategori']); ?></small></p>
                        <h3 class="text-primary mb-3">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></h3>
                        <div class="mb-3">
                            Status: <?php if ($produk['stok'] > 0) { ?><span class="badge badge-success">Tersedia</span><?php } else { ?><span class="badge badge-danger">Stok Habis</span><?php } ?>
                        </div>
                        <h5 class="mt-4">Deskripsi Produk</h5>
                        <p class="card-text"><?php echo !empty($produk['deskripsi']) ? nl2br(htmlspecialchars($produk['deskripsi'])) : 'Deskripsi untuk produk ini belum tersedia.'; ?></p>
                        <a href="produk_publik.php" class="btn btn-secondary mt-4">← Kembali ke Daftar Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-5 mb-4"><p>Copyright &copy; Toko Elektronik 2025</p></footer>
</body>
</html>