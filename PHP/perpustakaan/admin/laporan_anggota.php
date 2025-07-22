<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Laporan Data Anggota</h3>
</div>

<a href="#" class="btn btn-primary btn-sm mb-3" onclick="window.print()">
    <span class="glyphicon glyphicon-print"></span> Cetak Laporan
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Gender</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM anggota");
            while ($a = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $a['nama_anggota']; ?></td>
                    <td><?php echo $a['gender']; ?></td>
                    <td><?php echo $a['no_telp']; ?></td>
                    <td><?php echo $a['alamat']; ?></td>
                    <td><?php echo $a['email']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>