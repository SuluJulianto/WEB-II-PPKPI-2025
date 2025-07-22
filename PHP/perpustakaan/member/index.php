<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="page-header">
    <h3>Dashboard Anggota</h3>
</div>

<div class="card">
    <div class="card-header">
        Profil Saya
    </div>
    <div class="card-body">
        <?php
        $id_anggota = $_SESSION['id'];
        $anggota = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id_anggota'");
        $a = mysqli_fetch_assoc($anggota);
        ?>
        <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($a['nama_anggota']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($a['email']); ?></p>
        <p><strong>Alamat:</strong> <?php echo htmlspecialchars($a['alamat']); ?></p>
    </div>
</div>

<hr>

<h4>Buku yang Sedang Saya Pinjam</h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Ambil data buku yang status peminjamannya masih 0 (dipinjam)
            $query = "SELECT * FROM transaksi t, buku b WHERE t.id_buku=b.id_buku AND t.id_anggota='$id_anggota' AND t.status_peminjaman='0'";
            $data = mysqli_query($koneksi, $query);
            if(mysqli_num_rows($data) > 0) {
                while ($p = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($p['judul_buku']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($p['tgl_pinjam'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($p['tgl_kembali'])); ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Anda sedang tidak meminjam buku.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>