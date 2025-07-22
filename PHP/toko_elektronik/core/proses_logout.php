<?php 
// /core/proses_logout.php

session_start();
session_destroy();
header("location:../login.php?pesan=logout");
?>