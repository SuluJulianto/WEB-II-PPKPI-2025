<?php
if (isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto']['name'];
    $size = $_FILES['foto']['size'];

    $ekstensi = array('png', 'jpg', 'jpeg');
    $ext = pathinfo($foto, PATHINFO_EXTENSION);

    if (!in_array($ext, $ekstensi)) {
        echo "Bukan File nya nih";
    } else {
        move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $foto);

        $insert = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, harga, foto)
         VALUES ('$nama_barang','$harga','$foto')");
        if (!$insert) {
            // echo "gagal";
            header("location:?pg=tambah-produk&pesan=tambah-gagal");
        } else {
            // echo "duar";
            header("location:?pg=produk&pesan=tambah-berhasil");
        }
    }
}
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // tampilkan sebuah data dari tabel barang dimana id bernilai dari nilai parameter
    $edit = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['edit'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto']['name'];
    $size = $_FILES['foto']['size'];

    $ekstensi = array('png', 'jpg', 'jpeg');
    $ext = pathinfo($foto, PATHINFO_EXTENSION);

    $id = $_GET['edit'];

    if (!in_array($ext, $ekstensi)) {
        echo "file ekstensinya gak kedaftar";
    } else {
        unlink("upload/" . $rowEdit['foto']);
        move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $foto);
        $update = mysqli_query($koneksi, "UPDATE barang SET
         nama_barang='$nama_barang', harga='$harga', foto='$foto' WHERE id='$id'");
    header("location:?pg=produk&update=berhasil");
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="">Nama Produk</label>
        <input required type="<?php echo isset($_GET['edit']) ? $rowEdit['nama_barang'] : '' ?>" type="text" class="form-control" placeholder="Masukan Nama barang" name="nama_barang">
    </div>
    <div class="mb-3">
        <label for="">Harga</label>
        <input required type="<?php echo isset($_GET['edit']) ? $rowEdit['harga'] : '' ?>" type="number" class="form-control" placeholder="harga produk" name="harga">
    </div>
    <div class="mb-3">
        <label for="">Foto</label>
        <input type="file" name="foto" required>
    </div>
    <div class="mb-3">
        <input type="submit" class="btn btn-primary" value="Simpan" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">
    </div>

</form>