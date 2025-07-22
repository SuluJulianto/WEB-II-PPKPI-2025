<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Edit Anggota</h3>
</div>

<?php
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id'");
while ($a = mysqli_fetch_array($data)) {
?>
<form action="anggota_update_act.php" method="post">
    <input type="hidden" name="id" value="<?php echo $a['id_anggota']; ?>">

    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_anggota" class="form-control" required value="<?php echo $a['nama_anggota']; ?>">
    </div>
    <div class="form-group">
        <label>Gender</label>
        <select name="gender" class="form-control" required>
            <option <?php if($a['gender'] == "Laki-Laki"){ echo "selected='selected'"; } ?> value="Laki-Laki">Laki-Laki</option>
            <option <?php if($a['gender'] == "Perempuan"){ echo "selected='selected'"; } ?> value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="no_telp" class="form-control" required value="<?php echo $a['no_telp']; ?>">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required><?php echo $a['alamat']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="<?php echo $a['email']; ?>">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
        <small class="form-text text-muted">Jangan isi kolom ini jika Anda tidak ingin mengubah password.</small>
    </div>
    <div class="form-group">
        <input type="submit" value="Update" class="btn btn-primary">
        <a href="anggota.php" class="btn btn-secondary">Kembali</a>
    </div>
</form>
<?php } ?>

<?php include 'footer.php'; ?>