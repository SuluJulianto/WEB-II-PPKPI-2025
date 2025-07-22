<?php 
// /core/proses_login.php

session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$login = mysqli_stmt_get_result($stmt);

$cek = mysqli_num_rows($login);

if($cek > 0){
	$data = mysqli_fetch_assoc($login);

	// Cek password yang sudah di-hash
	if(password_verify($password, $data['password'])){
		$_SESSION['username'] = $username;
		$_SESSION['status'] = "login";
        $_SESSION['role'] = $data['role']; // Role tetap disimpan untuk sidebar superadmin

		// Langsung arahkan ke dashboard admin
		header("location:../admin/dashboard.php");
	} else {
		// Jika password salah
		header("location:../login.php?pesan=gagal");
	}	
}else{
	// Jika username tidak ditemukan
	header("location:../login.php?pesan=gagal");
}
?>