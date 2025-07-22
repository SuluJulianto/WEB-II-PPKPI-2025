<?php
include '../config/koneksi.php';

$id_pinjam = $_GET['id'];
$id_buku = $_GET['buku_id'];

// Hapus data transaksi
mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_pinjam='$id_pinjam'");

// Kembalikan status buku menjadi 'Tersedia' (1)
mysqli_query($koneksi, "UPDATE buku SET status_buku='1' WHERE id_buku='$id_buku'");

header("location:peminjaman.php");
?>