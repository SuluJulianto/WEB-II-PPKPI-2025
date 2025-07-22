<?php
include '../config/koneksi.php';

// Mengambil data dari form
$kategori = $_POST['kategori']; // DIUBAH
$judul_buku = $_POST['judul_buku'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$thn_terbit = $_POST['thn_terbit'];
$isbn = $_POST['isbn'];
$jumlah_buku = $_POST['jumlah_buku'];
$lokasi = $_POST['lokasi'];
$tgl_input = date('Y-m-d');
$status_buku = '1';

// Proses upload gambar (tetap sama)
$gambar_nama = $_FILES['gambar']['name'];
$gambar_tmp = $_FILES['gambar']['tmp_name'];
$gambar_baru = "";
if (!empty($gambar_tmp)) {
    $gambar_ext = strtolower(pathinfo($gambar_nama, PATHINFO_EXTENSION));
    $gambar_baru = uniqid() . '.' . $gambar_ext;
    $lokasi_upload = "../assets/upload/" . $gambar_baru;
    move_uploaded_file($gambar_tmp, $lokasi_upload);
}

// Query insert data
// DIUBAH: Menggunakan kolom dan variabel 'kategori'
$query = "INSERT INTO buku (kategori, judul_buku, pengarang, penerbit, thn_terbit, isbn, jumlah_buku, lokasi, gambar, tgl_input, status_buku) VALUES ('$kategori', '$judul_buku', '$pengarang', '$penerbit', '$thn_terbit', '$isbn', '$jumlah_buku', '$lokasi', '$gambar_baru', '$tgl_input', '$status_buku')";

mysqli_query($koneksi, $query);

header("location:buku.php");
?>