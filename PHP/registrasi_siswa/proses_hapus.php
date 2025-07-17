<?php
require_once "config/database.php";

if (isset($_GET['NoReg'])) {
    $no_reg = mysqli_real_escape_string($db, $_GET['NoReg']);

    // Langsung hapus data dari database
    $query_delete = "DELETE FROM registrasi WHERE NoReg = '$no_reg'";
    $delete = mysqli_query($db, $query_delete);

    if ($delete) {
        header("location: index.php?page=tampil&alert=3");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($db);
    }
} else {
    die("Akses dilarang: Nomor Registrasi tidak ditemukan.");
}

mysqli_close($db);
?>