<?php
include '../config/koneksi.php';

$nama = $_POST['nama_anggota'];
$gender = $_POST['gender'];
$telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$password = md5($_POST['password']);

mysqli_query($koneksi, "INSERT INTO anggota (nama_anggota, gender, no_telp, alamat, email, password) VALUES ('$nama', '$gender', '$telp', '$alamat', '$email', '$password')");

header("location:anggota.php");
?>