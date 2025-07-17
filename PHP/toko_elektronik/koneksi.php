<?php
// Pengaturan untuk koneksi ke database
$host = "localhost";    // Nama host database, biasanya "localhost"
$user = "ppkpi_edo";         // Username database, defaultnya "root"
$password = "ppkpiwp12345";         // Password database, defaultnya kosong
$database = "toko_elektronik"; // Nama database Anda

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>