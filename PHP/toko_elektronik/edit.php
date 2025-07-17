<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php?pesan=belum_login");
}
include 'koneksi.php';

$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id=$id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

if (isset($_POST['update'])) {
    $produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Ambil data deskripsi
    $thumbnail_lama = $_POST['thumbnail_lama'];

    if ($_FILES['thumbnail']['name'] != "") {
        $thumbnail_baru = $_FILES['thumbnail']['name'];
        $tmp_name = $_FILES['thumbnail']['tmp_name'];
        $folder = 'img/' . $thumbnail_baru;
        move_uploaded_file($tmp_name, $folder);
    } else {
        $thumbnail_baru = $thumbnail_lama;
    }
    
    // ## PERBARUI QUERY UPDATE DENGAN DESKRIPSI ##
    $update_query = "UPDATE produk SET produk='$produk', kategori='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi', thumbnail='$thumbnail_baru' WHERE id=$id";

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Produk</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center"><h1 class="h4 text-gray-900 mb-4">Edit Produk</h1></div>
                            <form class="user" method="POST" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                                <input type="hidden" name="thumbnail_lama" value="<?php echo $data['thumbnail']; ?>">
                                <div class="form-group"><label>Nama Produk</label><input type="text" class="form-control" name="produk" value="<?php echo htmlspecialchars($data['produk']); ?>" required></div>
                                <div class="form-group"><label>Kategori</label><input type="text" class="form-control" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required></div>
                                <div class="form-group"><label>Harga</label><input type="number" class="form-control" name="harga" value="<?php echo $data['harga']; ?>" required></div>
                                <div class="form-group"><label>Stok</label><input type="number" class="form-control" name="stok" value="<?php echo $data['stok']; ?>" required min="0"></div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="4"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Thumbnail Saat Ini</label><br>
                                    <img src="img/<?php echo $data['thumbnail']; ?>" width="150"><br><br>
                                    <label>Ganti Thumbnail (opsional)</label>
                                    <input type="file" class="form-control" name="thumbnail">
                                </div>
                                <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Update Produk</button>
                                <a href="index.php" class="btn btn-secondary btn-user btn-block">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>