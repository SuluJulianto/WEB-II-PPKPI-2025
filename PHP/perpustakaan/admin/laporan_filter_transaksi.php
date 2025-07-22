<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Laporan Transaksi</h3>
</div>

<?php
$dari = $_POST['dari'];
$sampai = $_POST['sampai'];
?>

<div class="alert alert-info">
    Laporan transaksi dari tanggal <b><?php echo date('d-m-Y', strtotime($dari)); ?></b> sampai <b><?php echo date('d-m-Y', strtotime($sampai)); ?></b>.
</div>

<a href="#" class="btn btn-primary btn-sm mb-3" onclick="window.print()">
    <span class="glyphicon glyphicon-print"></span> Cetak Laporan
</a>
<a href="laporan_transaksi.php" class="btn btn-secondary btn-sm mb-3">
    <span class="glyphicon glyphicon-arrow-left"></span> Kembali & Filter Ulang
</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Kembali</th>
                <th>Tgl. Dikembalikan</th>
                <th>Total Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT * FROM transaksi t, anggota a, buku b 
                      WHERE t.id_anggota=a.id_anggota AND t.id_buku=b.id_buku 
                      AND date(t.tgl_pinjam) >= '$dari' AND date(t.tgl_pinjam) <= '$sampai'";
            $data = mysqli_query($koneksi, $query);
            
            if(mysqli_num_rows($data) > 0) {
                while ($t = mysqli_fetch_array($data)) {
            ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $t['nama_anggota']; ?></td>
                        <td><?php echo $t['judul_buku']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($t['tgl_pinjam'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($t['tgl_kembali'])); ?></td>
                        <td>
                            <?php
                            if ($t['tgl_pengembalian'] == "0000-00-00") {
                                echo "-";
                            } else {
                                echo date('d-m-Y', strtotime($t['tgl_pengembalian']));
                            }
                            ?>
                        </td>
                        <td>Rp. <?php echo number_format($t['total_denda']); ?>,-</td>
                        <td>
                            <?php 
                            if ($t['status_peminjaman'] == '1') {
                                echo "<span class='badge badge-success'>Selesai</span>";
                            } else {
                                echo "<span class='badge badge-warning'>Dipinjam</span>";
                            }
                            ?>
                        </td>
                    </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data transaksi pada rentang tanggal yang dipilih.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>