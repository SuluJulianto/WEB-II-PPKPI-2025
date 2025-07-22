<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Selesaikan Transaksi Peminjaman</h3>
</div>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM transaksi t, anggota a, buku b WHERE t.id_pinjam='$id' AND t.id_anggota=a.id_anggota AND t.id_buku=b.id_buku";
$data = mysqli_query($koneksi, $query);
while ($p = mysqli_fetch_array($data)) {
?>
<form action="peminjaman_selesai_act.php" method="post">
    <input type="hidden" name="id_pinjam" value="<?php echo $p['id_pinjam']; ?>">
    <input type="hidden" name="id_buku" value="<?php echo $p['id_buku']; ?>">
    <input type="hidden" name="tgl_kembali" value="<?php echo $p['tgl_kembali']; ?>">
    <input type="hidden" name="denda" value="<?php echo $p['denda']; ?>">

    <div class="form-group">
        <label>Anggota</label>
        <input type="text" class="form-control" value="<?php echo $p['nama_anggota']; ?>" disabled>
    </div>
    <div class="form-group">
        <label>Buku</label>
        <input type="text" class="form-control" value="<?php echo $p['judul_buku']; ?>" disabled>
    </div>
    <div class="form-group">
        <label>Tanggal Pinjam</label>
        <input type="date" class="form-control" value="<?php echo $p['tgl_pinjam']; ?>" disabled>
    </div>
    <div class="form-group">
        <label>Batas Waktu Pengembalian</label>
        <input type="date" class="form-control" value="<?php echo $p['tgl_kembali']; ?>" disabled>
    </div>
    <div class="form-group">
        <label>Tanggal Dikembalikan oleh Anggota</label>
        <input type="date" name="tgl_dikembalikan" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Simpan & Selesaikan" class="btn btn-success">
    </div>
</form>
<?php } ?>

<?php include 'footer.php'; ?>