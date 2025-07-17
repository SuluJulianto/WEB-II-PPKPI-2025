<?php
require_once "config/database.php";

if (isset($_POST['simpan'])) {
    if (isset($_POST['NoReg'])) {
        $no_reg         = mysqli_real_escape_string($db, trim($_POST['NoReg']));
        $nama           = mysqli_real_escape_string($db, trim($_POST['Nama']));
        $jk             = $_POST['JK'] ?? '';
        $alamat         = mysqli_real_escape_string($db, trim($_POST['Alamat']));
        $agama          = mysqli_real_escape_string($db, trim($_POST['Agama']));
        $asal_sekolah   = mysqli_real_escape_string($db, trim($_POST['AsalSekolah']));
        $jurusan        = mysqli_real_escape_string($db, trim($_POST['Jurusan']));
        
        // Query UPDATE sederhana tanpa foto
        $query = "UPDATE registrasi 
                  SET Nama='$nama', JK='$jk', Alamat='$alamat', Agama='$agama', AsalSekolah='$asal_sekolah', Jurusan='$jurusan'
                  WHERE NoReg='$no_reg'";
        
        $update = mysqli_query($db, $query);

        if ($update) {
            header("location: index.php?page=tampil&alert=2");
        } else {
            echo "Gagal mengubah data: " . mysqli_error($db);
        }
    }
}
mysqli_close($db);
?>