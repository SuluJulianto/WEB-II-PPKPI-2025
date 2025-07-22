<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Transaksi Baru</h3>
</div>

<form action="peminjaman_tambah_act.php" method="post">
    <div class="form-group">
        <label>Anggota</label>
        <select name="anggota" class="form-control" required>
            <option value="">- Pilih Anggota -</option>
            <?php
            $anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
            while ($a = mysqli_fetch_array($anggota)) {
                echo "<option value='{$a['id_anggota']}'>{$a['nama_anggota']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Buku</label>
        <select name="buku" class="form-control" required>
            <option value="">- Pilih Buku -</option>
            <?php
            // Hanya tampilkan buku yang statusnya tersedia (1)
            $buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE status_buku='1'");
            while ($b = mysqli_fetch_array($buku)) {
                echo "<option value='{$b['id_buku']}'>{$b['judul_buku']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tgl_pinjam" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Tanggal Kembali (Batas Waktu)</label>
        <input type="date" name="tgl_kembali" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label>Denda / Hari</label>
        <input type="number" name="denda" class="form-control" value="2250" required>
        <small class="form-text text-muted">Sesuai ketentuan, denda adalah Rp. 2.250 per hari.</small>
    </div>

    <div class="form-group">
        <input type="submit" value="Simpan Transaksi" class="btn btn-primary">
        <a href="peminjaman.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include 'footer.php'; ?>