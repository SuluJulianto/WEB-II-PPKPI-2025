<?php
include '../config/koneksi.php';

// Menangkap data dari form
$id_pinjam = $_POST['id_pinjam'];
$id_buku = $_POST['id_buku'];
$tgl_kembali = $_POST['tgl_kembali']; // Batas waktu pengembalian
$tgl_dikembalikan = $_POST['tgl_dikembalikan']; // Tanggal aktual pengembalian
$denda_per_hari = $_POST['denda'];

// Inisialisasi total denda
$total_denda = 0;

// Mengonversi tanggal ke format timestamp untuk perhitungan
$batas_waktu = strtotime($tgl_kembali);
$tanggal_aktual = strtotime($tgl_dikembalikan);

// Cek apakah ada keterlambatan
if ($tanggal_aktual > $batas_waktu) {
    // Menghitung selisih hari keterlambatan
    $selisih_waktu = $tanggal_aktual - $batas_waktu;
    $selisih_hari = floor($selisih_waktu / (60 * 60 * 24));
    
    // Menghitung total denda berdasarkan rumus
    $total_denda = $selisih_hari * $denda_per_hari;
}

// 1. Update status transaksi di tabel 'transaksi'
mysqli_query($koneksi, "UPDATE transaksi SET 
    tgl_pengembalian='$tgl_dikembalikan', 
    total_denda='$total_denda', 
    status_peminjaman='1', 
    status_pengembalian='1' 
    WHERE id_pinjam='$id_pinjam'");

// 2. Update status buku menjadi 'Tersedia' (1) di tabel 'buku'
mysqli_query($koneksi, "UPDATE buku SET status_buku='1' WHERE id_buku='$id_buku'");

// Arahkan kembali ke halaman peminjaman setelah proses selesai
header("location:peminjaman.php");
?>