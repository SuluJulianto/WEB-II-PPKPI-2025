<?php
session_start();
session_destroy();
// DIUBAH: Arahkan ke halaman utama baru
header("location:index.php?pesan=logout");
?>