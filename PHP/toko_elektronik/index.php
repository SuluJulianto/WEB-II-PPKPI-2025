<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php?pesan=belum_login");
}
include 'koneksi.php';

// --- LOGIKA PAGINATION ---
// 1. Tentukan batas data per halaman
$batas_per_halaman = 5;

// 2. Ambil nomor halaman dari URL, jika tidak ada, defaultnya adalah halaman 1
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman < 1) {
    $halaman = 1;
}

// 3. Hitung posisi data pertama di halaman
$posisi_awal = ($halaman - 1) * $batas_per_halaman;

// 4. Ambil total jumlah data produk
$query_total = mysqli_query($koneksi, "SELECT COUNT(id) as total FROM produk");
$total_data = mysqli_fetch_assoc($query_total)['total'];
$total_halaman = ceil($total_data / $batas_per_halaman);


// 5. Query untuk mengambil data produk sesuai dengan batas halaman
$query = "SELECT id, thumbnail, produk, kategori, harga, stok FROM produk ORDER BY id DESC LIMIT ?, ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ii", $posisi_awal, $batas_per_halaman);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manajemen Produk</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Manajemen Data Produk</h1>
                    <a href="tambah.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Produk</a>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data Produk</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th><th>Thumbnail</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(mysqli_num_rows($result) > 0) {
                                            while($data = mysqli_fetch_assoc($result)) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $data['id']; ?></td>
                                            <td><img src="img/<?php echo $data['thumbnail']; ?>" width="100" alt="<?php echo $data['produk']; ?>"></td>
                                            <td><?php echo $data['produk']; ?></td>
                                            <td><?php echo $data['kategori']; ?></td>
                                            <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                            <td><?php echo $data['stok']; ?></td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="hapus.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">Delete</a>
                                            </td>
                                        </tr>
                                        <?php } } else { echo '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>'; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php if($halaman <= 1){ echo 'disabled'; } ?>">
                                        <a class="page-link" href="<?php if($halaman > 1){ echo "?halaman=".($halaman - 1); } ?>">Previous</a>
                                    </li>
                                    <?php for($i = 1; $i <= $total_halaman; $i++ ): ?>
                                        <li class="page-item <?php if($halaman == $i) {echo 'active'; } ?>">
                                            <a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php if($halaman >= $total_halaman) { echo 'disabled'; } ?>">
                                        <a class="page-link" href="<?php if($halaman < $total_halaman) { echo "?halaman=".($halaman + 1); } ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto"><div class="copyright text-center my-auto"><span>Copyright &copy; Your Website 2024</span></div></div>
            </footer>
        </div>
    </div>
</body>
</html>