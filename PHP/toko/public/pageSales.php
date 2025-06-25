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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Costumer</th>
                        <th>Sales (Rp)</th>
                    </tr>
                </thead>
                <tbody id="salesheader"></tbody>
            </table>
        </div>
        <div class="row flex">
            <div class="col-8 flex">
                <button id="btn_prev" class=" btn btn-outline-primary">
                    << Prev</button>
                        <button id="btn_next" class="btn btn-outline-primary">>> Next</button>
            </div>
            <div class="col-3">
                <a href="<?= $site_root ?>/pageCRUD/crudSales.php?id=3" class="btn btn-outline-primary">Add
                    Sales</a></button>
            </div>
        </div>
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>PRODUK</th>
                        <th>HARGA</th>
                        <th>JUMLAH</th>
                        <th>UOM</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody id="salesdetail"></tbody>
            </table>
            <pre>
    <?= $site_root?>
    </pre>
            <script src="<?= $site_root?>/JS/setSales.js"></script>
</body>

</html>