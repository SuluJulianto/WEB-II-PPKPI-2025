<?php
include 'header.php'; // header.php sudah memulai session dan cek login
include '../config/koneksi.php';

$pass_baru = $_POST['pass_baru'];
$ulang_pass = $_POST['ulang_pass'];

// Validasi
if (!empty($pass_baru) && $pass_baru == $ulang_pass) {
    $password_md5 = md5($pass_baru);
    $id_anggota = $_SESSION['id']; // Ambil ID dari session anggota
    
    // Update password di tabel 'anggota'
    mysqli_query($koneksi, "UPDATE anggota SET password='$password_md5' WHERE id_anggota='$id_anggota'");
    
    header("location:ganti_password.php?pesan=berhasil");
} else {
    header("location:ganti_password.php?pesan=gagal");
}
?>