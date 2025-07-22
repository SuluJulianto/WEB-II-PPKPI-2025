<?php 
// Sertakan header di awal
include 'header.php'; 
// Sertakan koneksi database
include '../config/koneksi.php'; 

// 1. MENGAMBIL DATA UNTUK CHART
// =======================================================
// Query untuk menghitung jumlah buku per kategori
$query_chart = "SELECT kategori, COUNT(*) as jumlah FROM buku GROUP BY kategori ORDER BY jumlah DESC";
$result_chart = mysqli_query($koneksi, $query_chart);

// Siapkan array untuk menyimpan data chart
$labels = [];
$data_jumlah = [];

while ($row = mysqli_fetch_assoc($result_chart)) {
    // Memasukkan nama kategori ke array labels
    $labels[] = $row['kategori'];
    // Memasukkan jumlah buku ke array data
    $data_jumlah[] = $row['jumlah'];
}
// =======================================================
?>

<div class="page-header">
    <h3>Dashboard</h3>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Buku</h5>
                <p class="card-text" style="font-size: 32px; font-weight: bold;">
                    <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku")); ?>
                </p>
                <a href="buku.php" class="text-white">Lihat Detail &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Anggota</h5>
                <p class="card-text" style="font-size: 32px; font-weight: bold;">
                    <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM anggota")); ?>
                </p>
                <a href="anggota.php" class="text-white">Lihat Detail &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Peminjaman Aktif</h5>
                <p class="card-text" style="font-size: 32px; font-weight: bold;">
                    <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status_peminjaman='0'")); ?>
                </p>
                <a href="peminjaman.php" class="text-white">Lihat Detail &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Transaksi Selesai</h5>
                <p class="card-text" style="font-size: 32px; font-weight: bold;">
                    <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status_peminjaman='1'")); ?>
                </p>
                <a href="peminjaman.php" class="text-white">Lihat Detail &rarr;</a>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                Jumlah Buku per Kategori
            </div>
            <div class="card-body">
                <canvas id="chartBukuPerKategori"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                Transaksi Peminjaman Terakhir
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_trans = "SELECT * FROM transaksi t, anggota a, buku b WHERE t.id_anggota=a.id_anggota AND t.id_buku=b.id_buku ORDER BY t.id_pinjam DESC LIMIT 5";
                            $data_trans = mysqli_query($koneksi, $query_trans);
                            while ($t = mysqli_fetch_array($data_trans)) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($t['nama_anggota']); ?></td>
                                    <td><?php echo htmlspecialchars($t['judul_buku']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($t['tgl_pinjam'])); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mengambil konteks dari elemen canvas
    const ctx = document.getElementById('chartBukuPerKategori').getContext('2d');
    
    // Membuat chart baru
    new Chart(ctx, {
        type: 'bar', // Tipe chart adalah bar (batang)
        data: {
            // Mengambil data label dari variabel PHP yang sudah di-encode ke JSON
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Jumlah Buku',
                // Mengambil data jumlah dari variabel PHP
                data: <?php echo json_encode($data_jumlah); ?>,
                // Memberi warna pada setiap batang
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            // Opsi untuk chart
            scales: {
                y: {
                    beginAtZero: true // Sumbu Y dimulai dari nol
                }
            },
            plugins: {
                legend: {
                    display: false // Menyembunyikan legenda
                }
            }
        }
    });
</script>

<?php 
// Sertakan footer di akhir
include 'footer.php'; 
?>