<?php 
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php?pesan=belum_login");
}
?>
<?php
include 'koneksi.php';

// Mengambil ID dari URL
$id = $_GET['id'];

// (Opsional) Hapus file gambar dari folder img
$query_select = "SELECT thumbnail FROM produk WHERE id=$id";
$result = mysqli_query($koneksi, $query_select);
$data = mysqli_fetch_array($result);
if (file_exists('img/' . $data['thumbnail'])) {
    unlink('img/' . $data['thumbnail']);
}

// Query untuk menghapus data
$query_delete = "DELETE FROM produk WHERE id=$id";

if (mysqli_query($koneksi, $query_delete)) {
    // Jika berhasil, redirect ke halaman utama
    header("Location: admin.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($koneksi);
}
?>