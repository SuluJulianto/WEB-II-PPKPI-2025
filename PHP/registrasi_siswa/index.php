<?php
// Memuat file koneksi database. Ini harus dilakukan di awal
// karena beberapa file template (form_tambah, form_ubah, tampil_data) memerlukan koneksi ini.
require_once "config/database.php";

// Memasukkan file header.php yang berisi bagian atas halaman HTML, termasuk navbar.
include 'templates/partials/header.php';

// --- Routing Halaman (Logika Utama) ---
// Mengambil nilai 'page' dari URL. Jika tidak ada, default-nya adalah 'home'.
// Contoh: http://localhost/registrasi_siswa/index.php?page=tampil
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Memeriksa nilai $page dan memuat file template yang sesuai.
if ($page == 'home') {
    // Jika halaman adalah 'home', muat file home.php.
    include "templates/home.php";
} else {
    // Untuk halaman selain 'home', kita gunakan container dengan padding.
    echo '<div class="container py-5">';

    // Menggunakan switch-case untuk mencocokkan nilai $page dengan file yang akan dimuat.
    // Ini lebih rapi dan aman daripada menggunakan variabel langsung di nama file.
    switch ($page) {
        case 'tampil':
            include "templates/tampil_data.php";
            break; // Hentikan pengecekan jika sudah cocok
        
        case 'tambah':
            include "templates/form_tambah.php";
            break;
            
        case 'ubah':
            include "templates/form_ubah.php";
            break;

        default:
            // Jika nilai $page tidak cocok dengan kasus mana pun (misal: ?page=xyz),
            // kita tampilkan halaman home sebagai fallback untuk menghindari error.
            include "templates/home.php";
            break;
    }

    echo '</div>';
}

// Memasukkan file footer.php yang berisi bagian bawah halaman HTML.
include 'templates/partials/footer.php';
?>