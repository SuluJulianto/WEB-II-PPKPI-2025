<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Data Anggota</h3>
</div>

<a href="anggota_tambah.php" class="btn btn-primary btn-sm mb-3">
    <span class="glyphicon glyphicon-plus"></span> Anggota Baru
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="table-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Gender</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Pilihan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id_anggota DESC");
            while ($a = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $a['nama_anggota']; ?></td>
                    <td><?php echo $a['gender']; ?></td>
                    <td><?php echo $a['no_telp']; ?></td>
                    <td><?php echo $a['alamat']; ?></td>
                    <td><?php echo $a['email']; ?></td>
                    <td nowrap="nowrap">
                        <a class="btn btn-primary btn-xs" href="anggota_edit.php?id=<?php echo $a['id_anggota']; ?>">
                           Edit
                        </a>
                        <a class="btn btn-danger btn-xs" href="anggota_hapus.php?id=<?php echo $a['id_anggota']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>