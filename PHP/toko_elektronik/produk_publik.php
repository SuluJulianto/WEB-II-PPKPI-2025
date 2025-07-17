<?php
include 'koneksi.php';

// Menyiapkan dasar query
$query_str = "SELECT id, thumbnail, produk, kategori, harga, stok FROM produk";
$params = [];
$types = "";
$where_clauses = [];

// Menangani filter kategori
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $where_clauses[] = "kategori = ?";
    $params[] = $_GET['kategori'];
    $types .= "s";
}

// Menangani pencarian
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where_clauses[] = "produk LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
    $types .= "s";
}

// Menggabungkan klausa WHERE jika ada filter atau pencarian
if (!empty($where_clauses)) {
    $query_str .= " WHERE " . implode(" AND ", $where_clauses);
}

$query_str .= " ORDER BY id DESC";

// Menjalankan query
$stmt = mysqli_prepare($koneksi, $query_str);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daftar Produk Elektronik</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
            <div class="card-header bg-white text-primary font-weight-bold">
                Daftar Produk Kami
            </div>
            <div class="card-body">
                <form action="produk_publik.php" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari nama produk..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr><th>#</th><th>Gambar</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if(mysqli_num_rows($result) > 0) {
                                while($data = mysqli_fetch_assoc($result)) { 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><img src="img/<?php echo htmlspecialchars($data['thumbnail']); ?>" width="120" alt="<?php echo htmlspecialchars($data['produk']); ?>"></td>
                                <td><a href="detail_produk.php?id=<?php echo $data['id']; ?>"><?php echo htmlspecialchars($data['produk']); ?></a></td>
                                <td><a href="produk_publik.php?kategori=<?php echo urlencode($data['kategori']); ?>"><?php echo htmlspecialchars($data['kategori']); ?></a></td>
                                <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($data['stok'] > 0) { ?>
                                        <span class="badge badge-success">Tersedia</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger">Stok Habis</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } } else { 
                                echo '<tr><td colspan="6" class="text-center">Produk tidak ditemukan.</td></tr>'; 
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-5 mb-4"><p>Copyright &copy; Toko Elektronik 2025</p></footer>
</body>
</html>