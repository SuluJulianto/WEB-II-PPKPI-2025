<?php
//untuk simpan
if (isset($_POST['simpan'])) {
    //$_FILES untuk mengambil sebah file
    //$_POST untuk memanggil sebuah data atau variabel yang sudah ada

    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto']['name'];
    $size = $_FILES['foto']['size']; //untuk menampilkan ukuran file foto

    //pathinfo untuk me GET atau mengambil data dari ekstensi array
    $ekstensi = array('png', 'jpg', 'jpeg');
    $ext = pathinfo($foto, PATHINFO_EXTENSION);


    //jika 
    if (!in_array($ext, $ekstensi)) {
        echo "mohon maaf ektensi tidak terdaftar";
    } else {

        move_uploaded_file($FILES['foto']['tmp_name'], 'upload/' . $foto);


        //memasukan ke dalam tabel barang (field yang akan di masukan)
        //values (inputan masing-masing kolom)
        $insert = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, harga, foto) 
        VALUES ('$nama_barang','$harga','$foto')");
        if (!$insert) {
            //echo "gagal";
            header("location:?pg=tambah-produk&pesan=tambah-gagal");
        } else {
            //echo "duar";
            header("location:?pg=produk&pesan=tambah-berhasil");
        }
    }
}


// $_GET sebuah perintah untuk memanggil sebuah data atau variabel yang belum ada
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $edit = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id' ");
    $rowEdit = mysqli_fetch_assoc($edit);
}
//untuk edit 
if (isset($_POST["edit"])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    //variabel id untuk edit
    $id = $_GET['edit'];

    $update = mysqli_query($koneksi, "UPDATE barang SET nama_lengkap='$nama_lengkap', email='$email', password='$password' WHERE id='$id' ");
    header("location:?pg=produk&update=berhasil");
}
?>


<!-- enctype=multipart/form-date bergungsi untuk mengambil gambar -->
<form action="" method="post" enctype="multipart/form-data">

    <!-- required itu tidak boleh kosong, jadi di sebuah website required ini sebagai peringatan, kolom harus di isi -->
    <div class="mb-3">
        <label for="">nama produk</label>
        <input value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_barang'] : '' ?>" type="text" class="form-control" placeholder="Masukan nama barang" name="nama_barang" required>
    </div>

    <!-- required itu tidak boleh kosong, jadi di sebuah website required ini sebagai peringatan, kolom harus di isi -->
    <div class="mb-3">
        <label for="">Harga</label>
        <input value="<?php echo isset($_GET['edit']) ? $rowEdit['harga'] : '' ?>" type="number" class="form-control" placeholder="Masukan unit jumlah barang" name="harga" required>
    </div>

    <!-- untuk type=file tidak memiliki class=form-control &placeholder -->
    <!-- required itu tidak boleh kosong, jadi di sebuah website required ini sebagai peringatan, kolom harus di isi -->
    <div class="mb-3">
        <label for="">Foto</label>
        <input value="" type="file" name="foto" required>
    </div>
    <!-- untuk button -->
    <div class="mb-3">
        <input type="submit" class="btn btn-primary" value="Simpan" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>"> <!--echo isset(GET), BUTTON MEMILIKI 2 KONDISI YAKNI EDIT DAN SIMPAN -->
    </div>
</form>