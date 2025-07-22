<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Laporan Data Buku</h3>
</div>

<a href="#" class="btn btn-primary btn-sm mb-3" onclick="window.print()">
    <span class="glyphicon glyphicon-print"></span> Cetak Laporan
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM buku");
            while ($b = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $b['judul_buku']; ?></td>
                    <td><?php echo $b['pengarang']; ?></td>
                    <td><?php echo $b['penerbit']; ?></td>
                    <td><?php echo $b['thn_terbit']; ?></td>
                    <td><?php echo $b['isbn']; ?></td>
                    <td><?php echo $b['lokasi']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>