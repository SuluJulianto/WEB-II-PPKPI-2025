<?php
include '../config/koneksi.php';

// Menangkap data dari form
$id_anggota = $_POST['anggota'];
$id_buku = $_POST['buku'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];
$denda = $_POST['denda'];
$tgl_pencatatan = date('Y-m-d');

// Menyimpan data ke tabel transaksi
$query_transaksi = "INSERT INTO transaksi (tgl_pencatatan, id_anggota, id_buku, tgl_pinjam, tgl_kembali, denda, status_peminjaman, status_pengembalian) VALUES ('$tgl_pencatatan', '$id_anggota', '$id_buku', '$tgl_pinjam', '$tgl_kembali', '$denda', '0', '0')";
mysqli_query($koneksi, $query_transaksi);

// Mengubah status buku menjadi 'Dipinjam' (0)
$query_buku = "UPDATE buku SET status_buku='0' WHERE id_buku='$id_buku'";
mysqli_query($koneksi, $query_buku);

// Mengalihkan halaman kembali ke halaman peminjaman
header("location:peminjaman.php");
?>