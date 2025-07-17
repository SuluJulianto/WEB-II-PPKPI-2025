<?php 
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($koneksi,"select * from admin where username='$username'");
$cek = mysqli_num_rows($login);

if($cek > 0){
	$data = mysqli_fetch_assoc($login);

	// Cek password yang sudah di-hash
	if(password_verify($password, $data['password'])){
		$_SESSION['username'] = $username;
		$_SESSION['status'] = "login";
		header("location:dashboard.php");
	} else {
		header("location:login.php?pesan=gagal");
	}	
}else{
	header("location:login.php?pesan=gagal");
}
?>