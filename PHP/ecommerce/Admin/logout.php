<?php
session_start();
unset($_SESSION['nama_lengkap']);
unset($_SESSION['email']);
unset($_SESSION['id_level']);
// session_destroy();
header("location:login.php");
