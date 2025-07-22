<?php
// Detail koneksi database
$db_host = "localhost";
$db_user = "ppkpi_edo"; // Sesuaikan dengan username database Anda
$db_pass = "ppkpiwp12345";     // Sesuaikan dengan password database Anda
$db_name = "perpus"; // Nama database yang Anda buat

// Membuat koneksi
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}
?>