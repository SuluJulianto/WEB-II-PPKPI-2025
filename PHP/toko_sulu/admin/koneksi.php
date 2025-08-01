<?php
$host_koneksi = "localhost";
$host_username = "ppkpi_edo";
$host_password = "ppkpiwp12345";
$host_database = "db_sulu";

$koneksi = mysqli_connect($host_koneksi, $host_username, $host_password, $host_database);
// jika koneksi gagal
if (!$koneksi) {
    mysqli_connect_error();
}
