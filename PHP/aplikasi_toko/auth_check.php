<?php
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Memeriksa apakah ada pengguna (baik User maupun Karyawan) yang sudah login.
 * Ini adalah fungsi keamanan utama.
 */
function require_login() {
    if (!isset($_SESSION['site_root'])) {
         $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
    }

    // KUNCI PERBAIKAN: Cek apakah session 'auth_id' ada. 
    // Session ini akan kita set untuk SEMUA jenis login.
    if (!isset($_SESSION['auth_id'])) {
        // Jika tidak ada yang login, arahkan ke halaman depan
        header("Location: " . $_SESSION['site_root'] . "/public/index.php");
        exit();
    }
}

/**
 * Memeriksa apakah pengguna yang login memiliki peran yang diizinkan.
 * @param array $allowed_roles Daftar peran yang diizinkan.
 */
function require_role($allowed_roles = []) {
    require_login(); 

    // KUNCI PERBAIKAN: Gunakan session 'auth_role' yang terpadu.
    if (!in_array($_SESSION['auth_role'], $allowed_roles)) {
        http_response_code(403);
        echo "<!DOCTYPE html><html lang='id'><head><title>Akses Ditolak</title>";
        echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'></head>";
        echo "<body class='bg-light'><div class='container mt-5 text-center'>";
        echo "<div class='alert alert-danger'>";
        echo "<h1 class='display-4'>403 - Akses Ditolak</h1>";
        echo "<p class='lead'>Maaf, Anda tidak memiliki hak akses untuk melihat halaman ini.</p>";
        echo "<hr><p>Peran Anda: <strong>" . htmlspecialchars($_SESSION['auth_role']) . "</strong>.</p>";
        echo "<a href='" . $_SESSION['site_root'] . "/public/admin_dashboard.php' class='btn btn-primary mt-3'>Kembali ke Dashboard</a>";
        echo "</div></div></body></html>";
        exit();
    }
}