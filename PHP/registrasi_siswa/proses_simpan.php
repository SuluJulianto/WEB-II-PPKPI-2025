<?php
require_once "config/database.php";

if (isset($_POST['simpan'])) {
    // Ambil data dari form (tanpa foto)
    $no_reg         = mysqli_real_escape_string($db, trim($_POST['NoReg']));
    $nama           = mysqli_real_escape_string($db, trim($_POST['Nama']));
    $jk             = $_POST['JK'] ?? '';
    $alamat         = mysqli_real_escape_string($db, trim($_POST['Alamat']));
    $agama          = mysqli_real_escape_string($db, trim($_POST['Agama']));
    $asal_sekolah   = mysqli_real_escape_string($db, trim($_POST['AsalSekolah']));
    $jurusan        = mysqli_real_escape_string($db, trim($_POST['Jurusan']));

    // Validasi server-side
    if (empty($jk)) {
        die("Error: Jenis Kelamin wajib dipilih. Silakan kembali dan lengkapi formulir.");
    }
    
    // Query INSERT tanpa kolom dan value untuk Foto
    $query = "INSERT INTO registrasi (NoReg, Nama, JK, Alamat, Agama, AsalSekolah, Jurusan)
              VALUES ('$no_reg', '$nama', '$jk', '$alamat', '$agama', '$asal_sekolah', '$jurusan')";
    
    $insert = mysqli_query($db, $query);

    if ($insert) {
        header("location: index.php?page=tampil&alert=1");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($db);
    }
}

mysqli_close($db);
?>