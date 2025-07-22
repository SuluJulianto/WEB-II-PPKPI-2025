<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Data Buku</h3>
</div>

<a href="buku_tambah.php" class="btn btn-primary btn-sm mb-3">
    <span class="glyphicon glyphicon-plus"></span> Buku Baru
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="table-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>Pilihan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
            while ($b = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $b['judul_buku']; ?></td>
                    <td><?php echo $b['pengarang']; ?></td>
                    <td><?php echo $b['penerbit']; ?></td>
                    <td><?php echo $b['thn_terbit']; ?></td>
                    <td>
                        <?php
                        if ($b['status_buku'] == "1") {
                            echo "<span class='badge badge-success'>Tersedia</span>";
                        } else {
                            echo "<span class='badge badge-warning'>Dipinjam</span>";
                        }
                        ?>
                    </td>
                    <td nowrap="nowrap">
                        <a class="btn btn-primary btn-xs" href="buku_edit.php?id=<?php echo $b['id_buku']; ?>">
                            <span class="glyphicon glyphicon-zoom-in"></span> Edit
                        </a>
                        <a class="btn btn-danger btn-xs" href="buku_hapus.php?id=<?php echo $b['id_buku']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <span class="glyphicon glyphicon-remove"></span> Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>