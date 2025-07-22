<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama_anggota'];
$gender = $_POST['gender'];
$telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah password diisi atau tidak
if ($password == "") {
    // Jika password kosong, update data tanpa mengubah password
    mysqli_query($koneksi, "UPDATE anggota SET nama_anggota='$nama', gender='$gender', no_telp='$telp', alamat='$alamat', email='$email' WHERE id_anggota='$id'");
} else {
    // Jika password diisi, update semua data termasuk password
    $password_md5 = md5($password);
    mysqli_query($koneksi, "UPDATE anggota SET nama_anggota='$nama', gender='$gender', no_telp='$telp', alamat='$alamat', email='$email', password='$password_md5' WHERE id_anggota='$id'");
}

header("location:anggota.php");
?>