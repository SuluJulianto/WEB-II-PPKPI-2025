<?php include 'header.php'; ?>

<div class="page-header">
    <h3>Anggota Baru</h3>
</div>

<form action="anggota_tambah_act.php" method="post">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_anggota" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Gender</label>
        <select name="gender" class="form-control" required>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="no_telp" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Simpan" class="btn btn-primary">
        <a href="anggota.php" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?php include 'footer.php'; ?>