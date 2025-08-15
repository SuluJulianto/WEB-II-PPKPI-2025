<?php
// Koneksi database
$host = 'localhost';
$user = 'ppkpi_edo';
$pass = 'ppkpiwp12345';
$db   = 'inventory';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

define('BASE_URL', '/inventory/');

// Utility: aman untuk input
function esc($conn, $str)
{
    return $conn->real_escape_string(trim($str));
}
