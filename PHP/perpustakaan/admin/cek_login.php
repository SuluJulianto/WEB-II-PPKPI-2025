<?php
// Mulai session
session_start();

// Cek apakah session 'status' tidak ada atau tidak sama dengan 'login'
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Arahkan kembali ke halaman login dengan pesan
    header("location:../index.php?pesan=belumlogin");
}
?>