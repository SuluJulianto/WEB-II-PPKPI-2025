<?php
// tag pembuka syntax PHP

// set default timezone
date_default_timezone_set("ASIA/JAKARTA");

// deklarasi parameter koneksi database
$server   = "localhost";            // server database, default "localhost" atau "127.0.0.1"
$username = "ppkpi_edo";                 // username database, default "root"
$password = "ppkpiwp12345";                     // password database, default kosong
$database = "db_sekolah";           // memilih database yang akan digunakan

// koneksi database
$db = mysqli_connect($server, $username, $password, $database);

// cek koneksi
if (!$db) {
    // cek koneksi gagal, tampilkan pesan gagal
    die('Koneksi Database Gagal : '.mysqli_connect_error());
}
?>