<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Data Transaksi Peminjaman</h3>
</div>

<a href="peminjaman_tambah.php" class="btn btn-primary btn-sm mb-3">
    <span class="glyphicon glyphicon-plus"></span> Transaksi Baru
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="table-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Kembali</th>
                <th>Denda / Hari</th>
                <th>Status</th>
                <th>Pilihan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Join 3 tabel: transaksi, anggota, dan buku
            $query = "SELECT * FROM transaksi t, anggota a, buku b WHERE t.id_anggota=a.id_anggota AND t.id_buku=b.id_buku ORDER BY t.id_pinjam DESC";
            $data = mysqli_query($koneksi, $query);
            while ($p = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $p['nama_anggota']; ?></td>
                    <td><?php echo $p['judul_buku']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($p['tgl_pinjam'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($p['tgl_kembali'])); ?></td>
                    <td>Rp. <?php echo number_format($p['denda']); ?>,-</td>
                    <td>
                        <?php
                        if ($p['status_peminjaman'] == "1") {
                            echo "<span class='badge badge-success'>Selesai</span>";
                        } else {
                            echo "<span class='badge badge-warning'>Dipinjam</span>";
                        }
                        ?>
                    </td>
                    <td nowrap="nowrap">
                        <?php if ($p['status_peminjaman'] == "0") { ?>
                            <a class="btn btn-success btn-xs" href="peminjaman_selesai.php?id=<?php echo $p['id_pinjam']; ?>">
                                Transaksi Selesai
                            </a>
                            <a class="btn btn-danger btn-xs" href="peminjaman_batal.php?id=<?php echo $p['id_pinjam']; ?>&buku_id=<?php echo $p['id_buku']; ?>" onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                Batalkan Transaksi
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>