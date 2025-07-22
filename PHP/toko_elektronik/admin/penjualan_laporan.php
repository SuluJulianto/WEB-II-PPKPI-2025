<?php
// /admin/penjualan_laporan.php

session_start();
if(!isset($_SESSION['status']) || $_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}
require_once '../core/koneksi.php';

// --- LOGIKA FILTER DAN PAGINATION ---
$batas_per_halaman = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$posisi_awal = ($halaman - 1) * $batas_per_halaman;

$where_clauses = [];
$params = [];
$types = "";
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';
$url_params = ''; 

if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
    $where_clauses[] = "DATE(pj.tanggal_transaksi) BETWEEN ? AND ?";
    $params[] = $tanggal_mulai;
    $params[] = $tanggal_selesai;
    $types .= "ss";
    $url_params = "&tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai";
}
$where_sql = !empty($where_clauses) ? " WHERE " . implode(" AND ", $where_clauses) : "";

$query_total_str = "SELECT COUNT(pj.id_transaksi) as total FROM tabel_penjualan AS pj" . $where_sql;
$stmt_total = mysqli_prepare($koneksi, $query_total_str);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_total, $types, ...$params);
}
mysqli_stmt_execute($stmt_total);
$total_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_total))['total'];
$total_halaman = ceil($total_data / $batas_per_halaman);

$query_data_str = "SELECT pj.id_transaksi, pj.tanggal_transaksi, p.produk AS nama_produk, p.harga AS harga_satuan, pj.jumlah_terjual, pj.total_harga FROM tabel_penjualan AS pj JOIN produk AS p ON pj.id_produk = p.id" . $where_sql . " ORDER BY pj.tanggal_transaksi DESC LIMIT ?, ?";
$stmt_data = mysqli_prepare($koneksi, $query_data_str);
$params_data = array_merge($params, [$posisi_awal, $batas_per_halaman]);
$types_data = $types . "ii";
mysqli_stmt_bind_param($stmt_data, $types_data, ...$params_data);
mysqli_stmt_execute($stmt_data);
$result = mysqli_stmt_get_result($stmt_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include '../templates/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Laporan Transaksi Penjualan</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header">Filter Berdasarkan Tanggal</div>
                        <div class="card-body">
                            <form method="GET" action="penjualan_laporan.php">
                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-4"><label>Dari Tanggal</label><input type="date" class="form-control" name="tanggal_mulai" value="<?php echo htmlspecialchars($tanggal_mulai); ?>"></div>
                                    <div class="form-group col-md-4"><label>Sampai Tanggal</label><input type="date" class="form-control" name="tanggal_selesai" value="<?php echo htmlspecialchars($tanggal_selesai); ?>"></div>
                                    <div class="form-group col-md-4"><button type="submit" class="btn btn-primary">Filter</button> <a href="penjualan_laporan.php" class="btn btn-secondary">Reset</a></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <?php 
                                        if(mysqli_num_rows($result) > 0) {
                                            while($data = mysqli_fetch_assoc($result)) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $data['id_transaksi']; ?></td>
                                            <td><?php echo date('d-m-Y H:i', strtotime($data['tanggal_transaksi'])); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama_produk']); ?></td>
                                            <td>Rp <?php echo number_format($data['harga_satuan'], 0, ',', '.'); ?></td>
                                            <td><?php echo $data['jumlah_terjual']; ?></td>
                                            <td>Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <?php } } else { echo '<tr><td colspan="6" class="text-center">Tidak ada data penjualan.</td></tr>'; } ?>
                                    </tbody>
                                </table>
                            </div>
                             <nav><ul class="pagination justify-content-center">
                                <li class="page-item <?php if($halaman <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($halaman > 1){ echo "?halaman=".($halaman - 1) . $url_params; } ?>">Previous</a></li>
                                <?php for($i = 1; $i <= $total_halaman; $i++ ): ?><li class="page-item <?php if($halaman == $i) {echo 'active'; } ?>"><a class="page-link" href="?halaman=<?php echo $i . $url_params; ?>"><?php echo $i; ?></a></li><?php endfor; ?>
                                <li class="page-item <?php if($halaman >= $total_halaman) { echo 'disabled'; } ?>"><a class="page-link" href="<?php if($halaman < $total_halaman) { echo "?halaman=".($halaman + 1) . $url_params; } ?>">Next</a></li>
                            </ul></nav>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white"><div class="container my-auto"><div class="copyright text-center my-auto"><span>Copyright &copy; Toko Elektronik 2025</span></div></div></footer>
        </div>
    </div>
</body>
</html>