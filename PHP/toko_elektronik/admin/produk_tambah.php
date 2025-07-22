<?php
// /admin/produk_tambah.php

session_start();
if(!isset($_SESSION['status']) || $_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}
require_once '../core/koneksi.php';

if (isset($_POST['submit'])) {
    $produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $thumbnail = $_FILES['thumbnail']['name'];
    $tmp_name = $_FILES['thumbnail']['tmp_name'];
    // Path folder upload diperbarui
    $folder = '../assets/img/' . basename($thumbnail);
    
    if (move_uploaded_file($tmp_name, $folder)) {
        $query = "INSERT INTO produk (thumbnail, produk, kategori, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sssiss", $thumbnail, $produk, $kategori, $harga, $stok, $deskripsi);
        
        if (mysqli_stmt_execute($stmt)) {
            // Path redirect diperbarui
            header("Location: produk_manajemen.php?status=tambah_sukses");
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error: Gagal mengunggah file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tambah Produk</title>
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center"><h1 class="h4 text-gray-900 mb-4">Buat Produk Baru</h1></div>
                    <form class="user" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group"><input type="text" class="form-control" name="produk" placeholder="Nama Produk" required></div>
                        <div class="form-group"><input type="text" class="form-control" name="kategori" placeholder="Kategori Produk" required></div>
                        <div class="form-group"><input type="number" class="form-control" name="harga" placeholder="Harga Produk" required></div>
                        <div class="form-group"><input type="number" class="form-control" name="stok" placeholder="Jumlah Stok Awal" required min="0"></div>
                        <div class="form-group"><textarea class="form-control" name="deskripsi" rows="4" placeholder="Deskripsi Produk..."></textarea></div>
                        <div class="form-group"><label>Thumbnail Produk</label><input type="file" class="form-control-file" name="thumbnail" required></div>
                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Tambah Produk</button>
                        <a href="produk_manajemen.php" class="btn btn-secondary btn-user btn-block">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>