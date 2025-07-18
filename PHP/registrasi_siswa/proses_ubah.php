<?php
// Memuat file konfigurasi database.
require_once "config/database.php";

// Memeriksa apakah tombol 'simpan' dari form ubah telah diklik.
if (isset($_POST['simpan'])) {
    // Memeriksa apakah NoReg ada di dalam POST request.
    if (isset($_POST['NoReg'])) {
        
        // --- Pengambilan Data dari Form ---
        $no_reg         = trim($_POST['NoReg']);
        $nama           = trim($_POST['Nama']);
        $jk             = $_POST['JK'];
        $alamat         = trim($_POST['Alamat']);
        $agama          = trim($_POST['Agama']);
        $asal_sekolah   = trim($_POST['AsalSekolah']);
        $jurusan        = trim($_POST['Jurusan']);
        
        // --- Menggunakan Prepared Statements untuk Query UPDATE ---
        
        // 1. Menyiapkan query UPDATE dengan placeholder.
        $query = "UPDATE registrasi 
                  SET Nama=?, JK=?, Alamat=?, Agama=?, AsalSekolah=?, Jurusan=?
                  WHERE NoReg=?";
        $stmt = mysqli_prepare($db, $query);

        // 2. Mengikat variabel ke placeholder.
        // Perhatikan urutan variabel harus sesuai dengan tanda tanya di query.
        // Tipe data untuk NoReg juga string ("s").
        mysqli_stmt_bind_param($stmt, "sssssss", $nama, $jk, $alamat, $agama, $asal_sekolah, $jurusan, $no_reg);
        
        // 3. Menjalankan statement.
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, arahkan ke halaman tampil data dengan pesan sukses (alert=2).
            header("location: index.php?page=tampil&alert=2");
        } else {
            // Jika gagal, tampilkan pesan error.
            echo "Gagal mengubah data: " . mysqli_stmt_error($stmt);
        }

        // 4. Menutup statement.
        mysqli_stmt_close($stmt);
    }
}

// Menutup koneksi database.
mysqli_close($db);
?>