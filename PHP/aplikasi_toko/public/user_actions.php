<?php
require_once __DIR__ . '/auth_check.php';
require_role(['User']); // Hanya user yang bisa melakukan aksi ini

require_once __DIR__ . '/module/dbconnect.php';
require_once __DIR__ . '/autoloader.php';
use module\Sanitize;

$sanitizer = new Sanitize();
$_POST = $sanitizer->sanitize($_POST);

$user_id = $_SESSION['auth_id'];
$redirect_url = $_SESSION['site_root'] . '/public/profile.php';

// Menangani upload avatar
$avatar_filename = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $target_dir = __DIR__ . "/public/uploads/avatars/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
    $avatar_filename = "user_" . $user_id . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $avatar_filename;

    // Validasi sederhana
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowed_types) && $_FILES["avatar"]["size"] < 2000000) { // Maks 2MB
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    } else {
        $avatar_filename = null; // Gagal upload, jangan update nama file di DB
    }
}

// Menyiapkan data untuk diupdate ke database
$nama_lengkap = $_POST['nama_lengkap'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$tempat_tinggal = $_POST['tempat_tinggal'] ?? '';
$nomor_telepon = $_POST['nomor_telepon'] ?? '';

try {
    // Bangun query SQL secara dinamis
    if ($avatar_filename) {
        // Jika ada avatar baru, update semua termasuk avatar
        $sql = "UPDATE user SET nama_lengkap=?, tempat_lahir=?, alamat=?, tempat_tinggal=?, nomor_telepon=?, avatar=? WHERE id=?";
        $params = [$nama_lengkap, $tempat_lahir, $alamat, $tempat_tinggal, $nomor_telepon, $avatar_filename, $user_id];
    } else {
        // Jika tidak ada avatar baru, update data lainnya saja
        $sql = "UPDATE user SET nama_lengkap=?, tempat_lahir=?, alamat=?, tempat_tinggal=?, nomor_telepon=? WHERE id=?";
        $params = [$nama_lengkap, $tempat_lahir, $alamat, $tempat_tinggal, $nomor_telepon, $user_id];
    }

    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    // Set pesan sukses (opsional, bisa menggunakan session flash)
    $_SESSION['flash_message'] = "Profil berhasil diperbarui!";

} catch (PDOException $e) {
    // Set pesan error
    $_SESSION['flash_message'] = "Gagal memperbarui profil: " . $e->getMessage();
}

// Redirect kembali ke halaman profil
header("Location: " . $redirect_url);
exit();