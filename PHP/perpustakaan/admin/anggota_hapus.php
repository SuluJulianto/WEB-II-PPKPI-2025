<?php
include '../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota='$id'");

header("location:anggota.php");
?>