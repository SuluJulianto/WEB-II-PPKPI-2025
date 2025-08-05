<?php
if (isset($_POST['simpan'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $id_level = $_POST['id_level'];

    //masukkan kedalam tabel user (field yang akan di masukkan)
    // values (inputan masing-masing kolom)

    $insert = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, email, password, id_level) 
    VALUES ('$nama_lengkap','$email','$password', '$id_level')");
    if (!$insert) {
        echo "gagal";
        //  header("location:?pg=tambah-user&pesan=tambah-gagal");
    } else {
        // echo "duar";
        header("location:?pg=user&pesan=tambah-berhasil");
    }
}
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // tampilkan sebuah data dari tabel user dimana id bernilai dari nilai parameter
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['edit'])) {
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $id_level = $_POST['id_level'];

    $id = $_GET['edit'];

    $update = mysqli_query($koneksi, "UPDATE user SET nama_lengkap='$nama_lengkap', email='$email', password='$password', id_level='$id_level' WHERE id='$id'");
    header("location:?pg=user&update=berhasil");
}
?>
<form action="" method="post">
    <div class="mb-3">
        <label for="">Nama Lengkap</label>
        <input type="<?php echo isset($_GET['edit']) ? $rowEdit['nama_lengkap'] : '' ?>" class="form-control" placeholder="Masukan Nama Lengkap Anda" name="nama_lengkap">
    </div>
    <div class="mb-3">
        <label for="">Email</label>
        <input type="<?php echo isset($_GET['edit']) ? $rowEdit['email'] : '' ?>" class="form-control" placeholder="Masukan email Anda" name="email">
    </div>
    <div class="mb-3">
        <label for="">Password</label>
        <input type="password" class="form-control" placeholder="Masukan passsword Anda" name="password">
    </div>
    <div class="mb-3">
        <label for=""></label>
        <?php
        $queryOpt = mysqli_query($koneksi, "SELECT * FROM level");
        ?>
        <select class="form-control" name="id_level" id="id_level">
            <option value="">-- Pilih Level --</option>
            <?php
            while ($row = mysqli_fetch_assoc($queryOpt)) :
            ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama_level'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" class="btn btn-primary" value="Simpan" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">
    </div>

</form>