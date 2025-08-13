<?php
session_start();

// Ambil site_root dari session sebelum dihancurkan
$site_root = $_SESSION['site_root'] ?? 'http://' . $_SERVER['HTTP_HOST'] . '/toko';

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session cookie jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session secara total
session_destroy();

// Arahkan kembali ke halaman depan (index.php)
header("Location: " . $site_root . "/public/index.php");
exit();