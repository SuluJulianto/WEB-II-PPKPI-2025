<?php
// 1. Memanggil file koneksi.php
include 'config/koneksi.php';

// 2. Memulai session
session_start();

// 3. Mengambil data dari form login
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, md5($_POST['password']));

// 4. Cek data di tabel admin
$query_admin = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result_admin = mysqli_query($koneksi, $query_admin);
$cek_admin = mysqli_num_rows($result_admin);

if ($cek_admin > 0) {
    // Jika ditemukan sebagai ADMIN
    $data = mysqli_fetch_assoc($result_admin);
    $_SESSION['id'] = $data['id_admin'];
    $_SESSION['nama'] = $data['nama_admin'];
    $_SESSION['status'] = "login";
    $_SESSION['level'] = "admin"; 
    header("location:admin/index.php");

} else {
    // 5. Jika tidak ditemukan di admin, cek data di tabel anggota
    $query_anggota = "SELECT * FROM anggota WHERE email='$username' AND password='$password'";
    $result_anggota = mysqli_query($koneksi, $query_anggota);
    $cek_anggota = mysqli_num_rows($result_anggota);

    if ($cek_anggota > 0) {
        // Jika ditemukan sebagai ANGGOTA
        $data = mysqli_fetch_assoc($result_anggota);
        $_SESSION['id'] = $data['id_anggota'];
        $_SESSION['nama'] = $data['nama_anggota'];
        $_SESSION['status'] = "login";
        $_SESSION['level'] = "anggota";

        // DIUBAH: Arahkan ke dashboard member
        header("location:member/index.php"); 
    } else {
        // Jika tidak ditemukan di keduanya, login gagal
        header("location:login.php?pesan=gagal");
    }
}
?>