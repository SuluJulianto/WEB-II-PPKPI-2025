<?php 
// Keamanan: Memulai session dan memastikan admin sudah login
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php?pesan=belum_login");
}

include 'koneksi.php';

// --- DATA UNTUK KARTU RINGKASAN ---
// 1. Query untuk menghitung jumlah total produk
$query_jumlah_produk = "SELECT COUNT(*) as total_produk FROM produk";
$result_jumlah_produk = mysqli_query($koneksi, $query_jumlah_produk);
$data_jumlah_produk = mysqli_fetch_assoc($result_jumlah_produk);
$total_produk = $data_jumlah_produk['total_produk'];

// 2. Query untuk menghitung total nilai (harga) semua produk
$query_total_nilai = "SELECT SUM(harga) as total_nilai FROM produk";
$result_total_nilai = mysqli_query($koneksi, $query_total_nilai);
$data_total_nilai = mysqli_fetch_assoc($result_total_nilai);
$total_nilai = $data_total_nilai['total_nilai'];

// 3. Query untuk menghitung jumlah kategori yang unik
$query_jumlah_kategori = "SELECT COUNT(DISTINCT kategori) as total_kategori FROM produk";
$result_jumlah_kategori = mysqli_query($koneksi, $query_jumlah_kategori);
$data_jumlah_kategori = mysqli_fetch_assoc($result_jumlah_kategori);
$total_kategori = $data_jumlah_kategori['total_kategori'];


// --- DATA UNTUK GRAFIK PENJUALAN BULANAN (AREA CHART) ---
$query_area_chart = "SELECT MONTH(tanggal_transaksi) AS bulan, SUM(total_harga) AS total_omset FROM tabel_penjualan WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE()) GROUP BY MONTH(tanggal_transaksi) ORDER BY bulan ASC";
$result_area_chart = mysqli_query($koneksi, $query_area_chart);

// Siapkan array untuk 12 bulan dengan nilai default 0
$omset_bulanan = array_fill(1, 12, 0);

while($row = mysqli_fetch_assoc($result_area_chart)) {
    $bulan = (int)$row['bulan'];
    $omset_bulanan[$bulan] = (int)$row['total_omset'];
}
// Hapus elemen ke-0 yang dibuat oleh array_fill jika ada, dan re-index
$data_area_chart = array_values($omset_bulanan);


// --- DATA UNTUK GRAFIK KOMPOSISI PRODUK (PIE CHART) ---
$query_pie_chart = "SELECT kategori, COUNT(*) as jumlah FROM produk GROUP BY kategori";
$result_pie_chart = mysqli_query($koneksi, $query_pie_chart);
$labels_pie = [];
$data_pie = [];
while($row = mysqli_fetch_assoc($result_pie_chart)) {
    $labels_pie[] = $row['kategori'];
    $data_pie[] = $row['jumlah'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_produk; ?> Buah</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai Inventaris</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($total_nilai, 0, ',', '.'); ?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                             <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kategori</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_kategori; ?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Bulanan (Tahun Ini)</h6></div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas id="myAreaChart"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Komposisi Produk</h6></div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2"><canvas id="myPieChart"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto"><div class="copyright text-center my-auto"><span>Copyright &copy; Your Website 2024</span></div></div>
            </footer>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    
    <script type="text/javascript">
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
          number = (number + '').replace(',', '').replace(' ', '');
          var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
            };
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
          }
          if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
          }
          return s.join(dec);
        }

        // Area Chart (Grafik Penjualan Bulanan)
        var ctxArea = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctxArea, {
          type: 'line',
          data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
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
              data: <?php echo json_encode($data_area_chart); ?>,
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
              xAxes: [{ time: { unit: 'date' }, gridLines: { display: false, drawBorder: false }, ticks: { maxTicksLimit: 7 } }],
              yAxes: [{ ticks: { maxTicksLimit: 5, padding: 10, callback: function(value, index, values) { return 'Rp' + number_format(value); } }, gridLines: { color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], zeroLineBorderDash: [2] } }],
            },
            legend: { display: false },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });

        // Pie Chart (Komposisi Produk)
        var ctxPie = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctxPie, {
          type: 'doughnut',
          data: {
            labels: <?php echo json_encode($labels_pie); ?>,
            datasets: [{
              data: <?php echo json_encode($data_pie); ?>,
              backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
            }],
          },
          options: { maintainAspectRatio: false, tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796" }, legend: { display: true, position: 'bottom' }, cutoutPercentage: 80 },
        });
    </script>
</body>
</html>