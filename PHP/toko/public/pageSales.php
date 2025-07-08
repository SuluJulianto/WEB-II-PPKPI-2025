<?php
 if (!isset($_SESSION)){
        session_start();
    }
if(!isset($_SESSION["site_root"])) {
    require_once 'bootstrap.php';
}
$site_root = $_SESSION["site_root"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALES</title>
    <script>
    const base_url = "<?= $site_root?>";
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container mt-4">
        <h3 class="mb-3">Daftar Penjualan</h3>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <a href="<?= $site_root ?>/pageCRUD/crudSales.php" id="btn_add_sales" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Sales
                </a>
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th class="text-end">Total Sales (Rp)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="salesheader"></tbody>
            </table>
        </div>
        
        <hr>

        <h4 class="mt-4">Detail Penjualan</h4>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>PRODUK</th>
                        <th class="text-end">HARGA</th>
                        <th class="text-end">JUMLAH</th>
                        <th>UOM</th>
                        <th class="text-end">TOTAL</th>
                    </tr>
                </thead>
                <tbody id="salesdetail"></tbody>
            </table>
        </div>
    </div>
    <script src="<?= $site_root?>/JS/setSales.js"></script>
</body>

</html>