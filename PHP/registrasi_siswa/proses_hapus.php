<?php
// Memuat file konfigurasi database.
require_once "config/database.php";

// Mengatur header respons sebagai JSON.
// Ini penting agar AJAX tahu cara memproses respons dari server.
header('Content-Type: application/json');

// Inisialisasi array untuk respons JSON.
$response = ['status' => 'error', 'message' => 'Akses dilarang atau data tidak ditemukan.'];

// Memeriksa apakah NoReg dikirim melalui parameter GET.
if (isset($_GET['NoReg'])) {
    $no_reg = $_GET['NoReg'];

    // --- Menggunakan Prepared Statements untuk Keamanan ---
    $query = "DELETE FROM registrasi WHERE NoReg = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $no_reg);

    // Menjalankan statement.
    if (mysqli_stmt_execute($stmt)) {
        // Memeriksa apakah ada baris yang terpengaruh (terhapus).
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Jika berhasil, ubah status respons menjadi 'success'.
            $response['status'] = 'success';
            $response['message'] = 'Data berhasil dihapus.';
        } else {
            // Jika tidak ada baris yang terhapus (misal: NoReg tidak ada).
            $response['message'] = 'Data dengan Nomor Registrasi tersebut tidak ditemukan.';
        }
    } else {
        // Jika query gagal dieksekusi.
        $response['message'] = 'Gagal menghapus data: ' . mysqli_stmt_error($stmt);
    }

    // Menutup statement.
    mysqli_stmt_close($stmt);
}

// Menutup koneksi database.
mysqli_close($db);

// Meng-encode array respons menjadi format JSON dan mencetaknya.
// Inilah yang akan diterima oleh fungsi success/error pada AJAX di script.js.
echo json_encode($response);
?>