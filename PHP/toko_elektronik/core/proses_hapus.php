<?php
// /core/proses_hapus.php

session_start();
if($_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}

include 'koneksi.php';

// Mengambil ID dari URL
$id = $_GET['id'];

// (Opsional) Hapus file gambar dari folder assets/img
$query_select = "SELECT thumbnail FROM produk WHERE id=?";
$stmt_select = mysqli_prepare($koneksi, $query_select);
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$data = mysqli_fetch_array($result);

$gambar_path = '../assets/img/' . $data['thumbnail'];
if (file_exists($gambar_path) && !is_dir($gambar_path)) {
    unlink($gambar_path);
}

// Query untuk menghapus data menggunakan prepared statement
$query_delete = "DELETE FROM produk WHERE id=?";
$stmt_delete = mysqli_prepare($koneksi, $query_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $id);

if (mysqli_stmt_execute($stmt_delete)) {
    // Jika berhasil, redirect ke halaman manajemen produk
    header("Location: ../admin/produk_manajemen.php?status=hapus_sukses");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($koneksi);
}
?>