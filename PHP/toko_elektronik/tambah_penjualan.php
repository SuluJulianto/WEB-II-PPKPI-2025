<?php 
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php?pesan=belum_login");
}
include 'koneksi.php';
$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $jumlah_terjual = $_POST['jumlah_terjual'];

    if (!empty($id_produk) && !empty($jumlah_terjual) && $jumlah_terjual > 0) {
        // Ambil harga dan stok produk
        $stmt_produk = mysqli_prepare($koneksi, "SELECT harga, stok FROM produk WHERE id = ?");
        mysqli_stmt_bind_param($stmt_produk, "i", $id_produk);
        mysqli_stmt_execute($stmt_produk);
        $result_produk = mysqli_stmt_get_result($stmt_produk);
        $data_produk = mysqli_fetch_assoc($result_produk);
        
        $harga_satuan = $data_produk['harga'];
        $stok_saat_ini = $data_produk['stok'];

        // ## PENGECEKAN STOK ##
        if ($stok_saat_ini >= $jumlah_terjual) {
            $total_harga = $harga_satuan * $jumlah_terjual;

            // Masukkan data ke tabel penjualan
            $stmt_insert = mysqli_prepare($koneksi, "INSERT INTO tabel_penjualan (id_produk, jumlah_terjual, total_harga) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt_insert, "iid", $id_produk, $jumlah_terjual, $total_harga);
            
            if(mysqli_stmt_execute($stmt_insert)) {
                // ## UPDATE STOK ##
                $stok_baru = $stok_saat_ini - $jumlah_terjual;
                $stmt_update = mysqli_prepare($koneksi, "UPDATE produk SET stok = ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt_update, "ii", $stok_baru, $id_produk);
                mysqli_stmt_execute($stmt_update);

                $pesan = "<div class='alert alert-success'>Penjualan berhasil dicatat dan stok telah diperbarui!</div>";
            } else {
                $pesan = "<div class='alert alert-danger'>Gagal mencatat penjualan: " . mysqli_error($koneksi) . "</div>";
            }
        } else {
            // Jika stok tidak mencukupi
            $pesan = "<div class='alert alert-danger'>Gagal! Stok produk tidak mencukupi. Sisa stok: $stok_saat_ini</div>";
        }
    } else {
        $pesan = "<div class='alert alert-warning'>Harap pilih produk dan masukkan jumlah yang valid.</div>";
    }
}
$query_semua_produk = "SELECT id, produk, stok FROM produk ORDER BY produk ASC";
$result_semua_produk = mysqli_query($koneksi, $query_semua_produk);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tambah Penjualan</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Catat Penjualan Baru</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Formulir Penjualan</h6></div>
                        <div class="card-body">
                            <?php echo $pesan; ?>
                            <form method="POST" action="tambah_penjualan.php">
                                <div class="form-group">
                                    <label for="id_produk">Pilih Produk</label>
                                    <select class="form-control" id="id_produk" name="id_produk" required>
                                        <option value="">-- Pilih Produk --</option>
                                        <?php
                                        while($produk = mysqli_fetch_assoc($result_semua_produk)) {
                                            echo "<option value='{$produk['id']}'>{$produk['produk']} (Stok: {$produk['stok']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_terjual">Jumlah Terjual</label>
                                    <input type="number" class="form-control" id="jumlah_terjual" name="jumlah_terjual" min="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
                            </form>
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