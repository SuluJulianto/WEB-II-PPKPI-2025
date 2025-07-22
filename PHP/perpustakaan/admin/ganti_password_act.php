<?php
// Panggil file koneksi dan mulai session dari header (yang juga sudah memulai session)
include 'cek_login.php';
include '../config/koneksi.php';

// Menangkap data dari form
$pass_baru = $_POST['pass_baru'];
$ulang_pass = $_POST['ulang_pass'];

// Validasi
// 1. Pastikan kedua kolom tidak kosong
// 2. Pastikan isi kedua kolom sama
if (!empty($pass_baru) && $pass_baru == $ulang_pass) {
    // Jika validasi berhasil
    
    // Enkripsi password baru dengan MD5
    $password_md5 = md5($pass_baru);
    
    // Ambil ID admin yang sedang login dari session
    $id_admin = $_SESSION['id'];
    
    // Query untuk update password
    mysqli_query($koneksi, "UPDATE admin SET password='$password_md5' WHERE id_admin='$id_admin'");
    
    // Arahkan kembali dengan pesan berhasil
    header("location:ganti_password.php?pesan=berhasil");
    
} else {
    // Jika validasi gagal, arahkan kembali dengan pesan gagal
    header("location:ganti_password.php?pesan=gagal");
}
?>