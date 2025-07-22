<?php
include '../config/koneksi.php';

// Menangkap data
$id = $_POST['id'];
$kategori = $_POST['kategori']; // DIUBAH
$judul_buku = $_POST['judul_buku'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$thn_terbit = $_POST['thn_terbit'];
$isbn = $_POST['isbn'];
$jumlah_buku = $_POST['jumlah_buku'];
$lokasi = $_POST['lokasi'];

// Proses gambar
$gambar_baru = $_FILES['gambar']['name'];
$gambar_lama = $_POST['gambar_lama'];

if (empty($gambar_baru)) {
    // Jika tidak ada gambar baru yang diupload, gunakan nama gambar lama
    $nama_file_gambar = $gambar_lama;
} else {
    // Jika ada gambar baru, proses upload
    $ext = strtolower(pathinfo($gambar_baru, PATHINFO_EXTENSION));
    $nama_file_gambar = uniqid() . '.' . $ext;
    $lokasi_upload = "../assets/upload/" . $nama_file_gambar;
    move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi_upload);
    
    // Hapus gambar lama jika ada
    if (!empty($gambar_lama) && file_exists("../assets/upload/" . $gambar_lama)) {
        unlink("../assets/upload/" . $gambar_lama);
    }
}

// Query update
// DIUBAH: Menggunakan kolom dan variabel 'kategori'
$query = "UPDATE buku SET 
            kategori='$kategori', 
            judul_buku='$judul_buku', 
            pengarang='$pengarang', 
            penerbit='$penerbit', 
            thn_terbit='$thn_terbit', 
            isbn='$isbn', 
            jumlah_buku='$jumlah_buku', 
            lokasi='$lokasi', 
            gambar='$nama_file_gambar' 
          WHERE id_buku='$id'";
          
mysqli_query($koneksi, $query);

header("location:buku.php");
?>