<?php
// /admin/produk_edit.php

session_start();
if(!isset($_SESSION['status']) || $_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}
require_once '../core/koneksi.php';

$id = $_GET['id'];

if (isset($_POST['update'])) {
    $produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $thumbnail_lama = $_POST['thumbnail_lama'];
    $thumbnail_baru = $thumbnail_lama;

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name'] != "") {
        $thumbnail_baru = $_FILES['thumbnail']['name'];
        $tmp_name = $_FILES['thumbnail']['tmp_name'];
        $folder = '../assets/img/' . basename($thumbnail_baru);
        move_uploaded_file($tmp_name, $folder);
        // Hapus file lama jika perlu
        if($thumbnail_lama != "" && file_exists('../assets/img/'.$thumbnail_lama)){
            unlink('../assets/img/'.$thumbnail_lama);
        }
    }
    
    $update_query = "UPDATE produk SET produk=?, kategori=?, harga=?, stok=?, deskripsi=?, thumbnail=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $update_query);
    mysqli_stmt_bind_param($stmt, "ssisssi", $produk, $kategori, $harga, $stok, $deskripsi, $thumbnail_baru, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: produk_manajemen.php?status=edit_sukses");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}

$query = "SELECT * FROM produk WHERE id=?";
$stmt_get = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$data = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Produk</title>
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center"><h1 class="h4 text-gray-900 mb-4">Edit Produk</h1></div>
                    <form class="user" method="POST" action="produk_edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                        <input type="hidden" name="thumbnail_lama" value="<?php echo $data['thumbnail']; ?>">
                        <div class="form-group"><label>Nama Produk</label><input type="text" class="form-control" name="produk" value="<?php echo htmlspecialchars($data['produk']); ?>" required></div>
                        <div class="form-group"><label>Kategori</label><input type="text" class="form-control" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required></div>
                        <div class="form-group"><label>Harga</label><input type="number" class="form-control" name="harga" value="<?php echo $data['harga']; ?>" required></div>
                        <div class="form-group"><label>Stok</label><input type="number" class="form-control" name="stok" value="<?php echo $data['stok']; ?>" required min="0"></div>
                        <div class="form-group"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" rows="4"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea></div>
                        <div class="form-group">
                            <label>Thumbnail Saat Ini</label><br>
                            <img src="../assets/img/<?php echo htmlspecialchars($data['thumbnail']); ?>" width="150"><br><br>
                            <label>Ganti Thumbnail (opsional)</label>
                            <input type="file" class="form-control-file" name="thumbnail">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Update Produk</button>
                        <a href="produk_manajemen.php" class="btn btn-secondary btn-user btn-block">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>