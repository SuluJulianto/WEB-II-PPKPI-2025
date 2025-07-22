<?php
// /admin/dashboard.php

session_start();
if(!isset($_SESSION['status']) || $_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}
require_once '../core/koneksi.php';

// --- DATA UNTUK KARTU RINGKASAN ---
$total_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk"))['total'];
$total_nilai_inventaris = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(harga * stok) as total FROM produk"))['total'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT kategori) as total FROM produk"))['total'];

// --- DATA UNTUK GRAFIK PENJUALAN BULANAN ---
$result_bulanan = mysqli_query($koneksi, "SELECT MONTH(tanggal_transaksi) AS bulan, SUM(total_harga) AS total_omset FROM tabel_penjualan WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE()) GROUP BY MONTH(tanggal_transaksi) ORDER BY bulan ASC");
$omset_bulanan = array_fill(1, 12, 0);
while($row = mysqli_fetch_assoc($result_bulanan)) { $omset_bulanan[(int)$row['bulan']] = (int)$row['total_omset']; }
$data_chart_bulanan = array_values($omset_bulanan);
$max_bulanan = empty($data_chart_bulanan) ? 0 : max($data_chart_bulanan);
$suggested_max_bulanan = ($max_bulanan > 0) ? $max_bulanan * 1.2 : 1000000;

// --- DATA UNTUK GRAFIK PENJUALAN TAHUNAN ---
$result_tahunan = mysqli_query($koneksi, "SELECT YEAR(tanggal_transaksi) AS tahun, SUM(total_harga) AS total_omset FROM tabel_penjualan GROUP BY YEAR(tanggal_transaksi) ORDER BY tahun ASC");
$label_chart_tahunan = [];
$data_chart_tahunan = [];
while($row = mysqli_fetch_assoc($result_tahunan)) {
    $label_chart_tahunan[] = $row['tahun'];
    $data_chart_tahunan[] = (int)$row['total_omset'];
}
$max_tahunan = empty($data_chart_tahunan) ? 0 : max($data_chart_tahunan);
$suggested_max_tahunan = ($max_tahunan > 0) ? $max_tahunan * 1.2 : 5000000;

// --- DATA UNTUK GRAFIK KOMPOSISI PRODUK ---
$result_pie = mysqli_query($koneksi, "SELECT kategori, COUNT(*) as jumlah FROM produk GROUP BY kategori");
$labels_pie = []; $data_pie = [];
while($row = mysqli_fetch_assoc($result_pie)) { $labels_pie[] = $row['kategori']; $data_pie[] = $row['jumlah']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include_once '../templates/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"><button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button></nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_produk; ?> Buah</div></div><div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-4 col-md-6 mb-4"><div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai Inventaris</div><div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($total_nilai_inventaris, 0, ',', '.'); ?></div></div><div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-4 col-md-6 mb-4"><div class="card border-left-info shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kategori</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_kategori; ?></div></div><div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div></div></div></div></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-7"><div class="card shadow mb-4"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Bulanan (Tahun Ini)</h6></div><div class="card-body"><div class="chart-area" style="position: relative; height:320px;"><canvas id="myAreaChart"></canvas></div></div></div></div>
                        <div class="col-xl-4 col-lg-5"><div class="card shadow mb-4"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Komposisi Produk</h6></div><div class="card-body"><div class="chart-pie pt-4 pb-2" style="position: relative; height:320px;"><canvas id="myPieChart"></canvas></div></div></div></div>
                    </div>
                    <div class="row"><div class="col-lg-12"><div class="card shadow mb-4"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Tahunan</h6></div><div class="card-body"><div class="chart-bar" style="position: relative; height:320px;"><canvas id="myYearlyBarChart"></canvas></div></div></div></div></div>
                </div>
            </div>
            <footer class="sticky-footer bg-white"><div class="container my-auto"><div class="copyright text-center my-auto"><span>Copyright &copy; Toko Elektronik 2025</span></div></div></footer>
        </div>
    </div>
    
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>
    
    <script type="text/javascript">
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';
        function number_format(number, decimals, dec_point, thousands_sep) {
          number = (number + '').replace(',', '').replace(' ', '');
          var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point, s = '', toFixedFix = function(n, prec) { var k = Math.pow(10, prec); return '' + Math.round(n * k) / k; };
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) { s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep); }
          if ((s[1] || '').length < prec) { s[1] = s[1] || ''; s[1] += new Array(prec - s[1].length + 1).join('0');}
          return s.join(dec);
        }

        // 1. Grafik Area Penjualan Bulanan
        var ctxArea = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctxArea, {
          type: 'line',
          data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
              // [DIPERBAIKI] Mengembalikan semua properti styling agar grafik tampil
              label: "Pendapatan",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: <?php echo json_encode($data_chart_bulanan); ?>,
            }],
          },
          options: {
            maintainAspectRatio: false,
            scales: {
              yAxes: [{
                ticks: {
                  // [BARU] Menghapus 'beginAtZero' agar bisa menampilkan nilai minus (kerugian)
                  suggestedMax: <?php echo $suggested_max_bulanan; ?>,
                  callback: function(value) { return 'Rp' + number_format(value); }
                }
              }]
            },
            tooltips: { callbacks: { label: function(tooltipItem, chart) { return chart.datasets[tooltipItem.datasetIndex].label + ': Rp' + number_format(tooltipItem.yLabel); } } }
          }
        });

        // 2. Grafik Pie Komposisi Produk
        var ctxPie = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctxPie, { type: 'doughnut', data: { labels: <?php echo json_encode($labels_pie); ?>, datasets: [{ data: <?php echo json_encode($data_pie); ?>, backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'] }] }, options: { maintainAspectRatio: false, legend: { position: 'bottom' }, cutoutPercentage: 80 } });

        // 3. Grafik Bar Penjualan Tahunan
        var ctxBar = document.getElementById("myYearlyBarChart");
        var myBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: { labels: <?php echo json_encode($label_chart_tahunan); ?>, datasets: [{ label: "Total Omset", backgroundColor: "#4e73df", data: <?php echo json_encode($data_chart_tahunan); ?> }] },
            options: {
                maintainAspectRatio: false,
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true, // Untuk bar chart, sebaiknya selalu mulai dari 0
                      suggestedMax: <?php echo $suggested_max_tahunan; ?>,
                      callback: function(value) { return 'Rp' + number_format(value); }
                    }
                  }]
                },
                tooltips: { callbacks: { label: function(tooltipItem, chart) { return chart.datasets[tooltipItem.datasetIndex].label + ': Rp' + number_format(tooltipItem.yLabel); } } }
            }
        });
    </script>
</body>
</html>