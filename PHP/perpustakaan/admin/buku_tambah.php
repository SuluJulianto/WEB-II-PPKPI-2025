<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Buku Baru</h3>
</div>

<form action="buku_tambah_act.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" class="form-control" required placeholder="Contoh: Fiksi, Teknologi, Sejarah">
    </div>
    <div class="form-group">
        <label>Judul Buku</label>
        <input type="text" name="judul_buku" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="penerbit" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="thn_terbit" class="form-control" required placeholder="Contoh: 2023">
    </div>
    <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="isbn" class="form-control">
    </div>
    <div class="form-group">
        <label>Jumlah Buku</label>
        <input type="number" name="jumlah_buku" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Rak 1A">
    </div>
    <div class="form-group">
        <label>Gambar Sampul</label>
        <input type="file" name="gambar" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" value="Simpan" class="btn btn-primary">
        <a href="buku.php" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?php include 'footer.php'; ?>