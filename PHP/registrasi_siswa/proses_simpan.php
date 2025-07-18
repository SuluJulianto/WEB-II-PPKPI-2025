<?php
// Memuat file konfigurasi database.
// File ini berisi informasi untuk terhubung ke database.
require_once "config/database.php";

// Memeriksa apakah tombol 'simpan' telah diklik pada form.
// Ini memastikan bahwa skrip hanya berjalan ketika ada data yang dikirim dari form.
if (isset($_POST['simpan'])) {
    
    // --- Validasi Sederhana di Sisi Server ---
    // Memeriksa apakah ada field yang kosong. Ini adalah lapisan pertahanan pertama.
    if (empty($_POST['NoReg']) || empty($_POST['Nama']) || empty($_POST['JK']) || empty($_POST['Alamat']) || empty($_POST['Agama']) || empty($_POST['AsalSekolah']) || empty($_POST['Jurusan'])) {
        // Jika ada yang kosong, hentikan eksekusi dan berikan pesan error.
        die("Error: Semua field wajib diisi. Silakan kembali dan lengkapi formulir.");
    }

    // --- Pengambilan Data dari Form ---
    // Menggunakan fungsi trim() untuk menghapus spasi yang tidak perlu di awal dan akhir string.
    $no_reg         = trim($_POST['NoReg']);
    $nama           = trim($_POST['Nama']);
    $jk             = $_POST['JK'];
    $alamat         = trim($_POST['Alamat']);
    $agama          = trim($_POST['Agama']);
    $asal_sekolah   = trim($_POST['AsalSekolah']);
    $jurusan        = trim($_POST['Jurusan']);

    // --- Menggunakan Prepared Statements untuk Keamanan (Mencegah SQL Injection) ---
    
    // 1. Menyiapkan query SQL dengan placeholder (tanda tanya '?').
    // Placeholder ini akan diisi dengan data secara aman.
    $query = "INSERT INTO registrasi (NoReg, Nama, JK, Alamat, Agama, AsalSekolah, Jurusan)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    // 2. Mengikat (bind) variabel PHP ke placeholder dalam query.
    // "sssssss" berarti ada 7 variabel yang semuanya bertipe string.
    mysqli_stmt_bind_param($stmt, "sssssss", $no_reg, $nama, $jk, $alamat, $agama, $asal_sekolah, $jurusan);
    
    // 3. Menjalankan statement yang sudah disiapkan.
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, arahkan pengguna kembali ke halaman tampil data dengan pesan sukses (alert=1).
        header("location: index.php?page=tampil&alert=1");
    } else {
        // Jika gagal, tampilkan pesan error dari database.
        echo "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
    }
    
    // 4. Menutup statement untuk melepaskan sumber daya.
    mysqli_stmt_close($stmt);
}

// Menutup koneksi database.
mysqli_close($db);
?>