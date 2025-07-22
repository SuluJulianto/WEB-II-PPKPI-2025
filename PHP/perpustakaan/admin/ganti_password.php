<?php include 'header.php'; ?>

<div class="page-header">
    <h3>Ganti Password</h3>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php
        // Menampilkan pesan notifikasi
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "berhasil") {
                echo "<div class='alert alert-success'>Password berhasil diganti.</div>";
            } else if ($_GET['pesan'] == "gagal") {
                echo "<div class='alert alert-danger'>Password gagal diganti. Pastikan kedua kolom diisi dan sama.</div>";
            }
        }
        ?>
        <form action="ganti_password_act.php" method="post">
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" class="form-control" name="pass_baru" required>
            </div>
            <div class="form-group">
                <label>Ulangi Password Baru</label>
                <input type="password" class="form-control" name="ulang_pass" required>
            </div>
            <div class="form-group">
                <input class="btn btn-primary btn-sm" type="submit" value="Simpan">
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>