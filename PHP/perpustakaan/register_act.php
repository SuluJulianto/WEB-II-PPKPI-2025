<?php
include 'config/koneksi.php';

$nama = $_POST['nama_anggota'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$gender = $_POST['gender'];
$telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];

// Cek apakah email sudah terdaftar
$check_email = mysqli_query($koneksi, "SELECT * FROM anggota WHERE email='$email'");
if (mysqli_num_rows($check_email) > 0) {
    // Jika email sudah ada, kembalikan ke halaman register dengan pesan error
    header("location:register.php?pesan=exists");
    exit;
}

// Jika email belum ada, lanjutkan pendaftaran
mysqli_query($koneksi, "INSERT INTO anggota (nama_anggota, gender, no_telp, alamat, email, password) VALUES ('$nama', '$gender', '$telp', '$alamat', '$email', '$password')");

// Arahkan ke halaman login dengan pesan sukses
header("location:login.php?pesan=registered");
?>