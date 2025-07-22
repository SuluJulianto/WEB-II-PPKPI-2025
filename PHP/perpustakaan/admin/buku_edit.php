<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Edit Buku</h3>
</div>

<?php
$id_buku = $_GET['id'];
// DIUBAH: Query tidak perlu JOIN tabel kategori lagi
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id_buku'");
while ($b = mysqli_fetch_array($data)) {
?>
<form action="buku_update_act.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $b['id_buku']; ?>">
    <input type="hidden" name="gambar_lama" value="<?php echo $b['gambar']; ?>">

    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" class="form-control" required value="<?php echo htmlspecialchars($b['kategori']); ?>">
    </div>
    <div class="form-group">
        <label>Judul Buku</label>
        <input type="text" name="judul_buku" class="form-control" required value="<?php echo htmlspecialchars($b['judul_buku']); ?>">
    </div>
    
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" class="form-control" required value="<?php echo htmlspecialchars($b['pengarang']); ?>">
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="penerbit" class="form-control" required value="<?php echo htmlspecialchars($b['penerbit']); ?>">
    </div>
    <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="thn_terbit" class="form-control" required value="<?php echo htmlspecialchars($b['thn_terbit']); ?>">
    </div>
    <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="isbn" class="form-control" value="<?php echo htmlspecialchars($b['isbn']); ?>">
    </div>
    <div class="form-group">
        <label>Jumlah Buku</label>
        <input type="number" name="jumlah_buku" class="form-control" required value="<?php echo htmlspecialchars($b['jumlah_buku']); ?>">
    </div>
    <div class="form-group">
        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" value="<?php echo htmlspecialchars($b['lokasi']); ?>">
    </div>

    <div class="form-group">
        <label>Gambar Sampul (Kosongkan jika tidak diubah)</label>
        <br>
        <img src="../assets/upload/<?php echo $b['gambar'] ? $b['gambar'] : 'default.png'; ?>" width="100">
        <br><br>
        <input type="file" name="gambar" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" value="Update" class="btn btn-primary">
        <a href="buku.php" class="btn btn-secondary">Kembali</a>
    </div>
</form>
<?php } ?>

<?php include 'footer.php'; ?>