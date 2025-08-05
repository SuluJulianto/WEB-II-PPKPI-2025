<?php
$host_koneksi = "localhost";
$username_koneksi = "ppkpi_edo";
$password_koneksi = "ppkpiwp12345";
$database_koneksi = "db_sulu";

$koneksi = mysqli_connect(
    $host_koneksi,
    $username_koneksi,
    $password_koneksi,
    $database_koneksi
);

if (!$koneksi) {
    die('koneksi error : ' . mysqli_connect_error());
}
