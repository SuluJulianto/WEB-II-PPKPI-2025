<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION["site_root"])) {
    require_once 'bootstrap.php';
    }
    $site_root = $_SESSION["site_root"];

    require_once $_SESSION["dir_root"] . '/module/dbconnect.php';
    

    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $sales = [];
    if ($id > 0){
        $stmt = db()->prepare("SELECT * FROM sales WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $sales = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

    }
$productList = db()->query("SELECT * FROM product")->fetchAll(PDO::FETCH_ASSOC);
$customerList = db()->query("SELECT * FROM customer")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD SALES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script>
    const base_url = "<?=$site_root?>";
    const productData = <?= json_encode($productList)?>;
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
   <script src="https://cdn.jsdelivr.net/npm/litepicker@2.0.12/dist/litepicker.min.js"></script>
    <style>
    .row_line {
        display: flex;
        gap: 8px;
        margin-bottom: 5px;
    }

    #quantity {
        text-align: right;
    }

    .row_line input,
    .row_line select {
        padding: 5px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <form id="salesForm" method="post" enctype="multipart/form-data">
            <input hidden name="id" id="id" value="<?= $sales['id'] ?? '' ?>">
            
            <!--header-->
            <fieldset id="header">
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text w-25">Tanggal</span>
                            <input type="text" class="form-control" placeholder="DD-MM-YYYY" name="sales_date"
                                id="sales_date" value="<?= $sales['sales_date'] ?? '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text w-25">Customer</span>
                            <select name="customer" id="customer" class="form-select">
                                <option value="Pilih Customer"></option>
                                <?php foreach ($customerList as $cust): ?>
                                <option value="<?= $cust['id']?>">
                                    <?= $cust['customer'] ?>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div>

                <!--DETAIL-->
                <fieldset id="detail">
                    <div class="header-row">
                        <span>Produk</span>
                        <span>Deskripsi</span>
                        <span>Harga</span>
                        <span>UOM</span>
                        <span>Qty</span>
                        <span>Total</span>
                    </div>
                    <div id="detail"></div>
                </fieldset>


                <div class="sumary">

                    Sub Total: <span id="subtotal_value">0</span><br>
                    Diskon %: <input type="number" id="discount_percent" value="0"><br>
                    Diskon (Rp): <span id="discount_value">0</span><br>
                    Pajak 10%: <span id="tax_value">0</span><br>    
                    Total Bayar: <span id="grand_total">0</span><br>
                </div>
                
                </fieldset>

                        <div>
                            <button id="btn_preview" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#printPreview">Preview</button>
                            <button id="btn_save" class="btn btn-primary">Save</button>
                            <button id="btn_cancel" class="btn btn-secondary">Cancel</button>
                        </div>
        </form>
    </div>
    <div class="modal fade" id="printPreview" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>print priview</h5>
                </div>
                <div class="modal-body">
                    <div id="print_preview">
                     <h5>Nota Penjualan</h5><br>
                     <p><strong>Tanggal :</strong> <span id="preview_date"></span></br>
                        <strong>Customer :</strong> <span id="preview_customer"></span></br> 
                    </p>
                    <table class="table table-bordered">
                       <thead>
                           <tr>
                                <th>Produk</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>UOM</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead> 
                        <tbody id="preview_detail"></tbody>
                        <tfoot>
                             <tr>       
                                <th colspan="4">Sub Total</th>
                                <td id="preview_subtotal" class="text-end"></td>
                            <tr>
                             <tr>       
                                <th colspan="4">Diskon</th>
                                <td id="preview_discount" class="text-end"></td>
                            <tr>
                            <tr>       
                                <th colspan="4">Pajak 10 %</th>
                                <td id="preview_tax" class="text-end"></td>
                            <tr> 
                            <tr>       
                                <th colspan="4">Toral Bayar</th>
                                <td id="preview_grandtotal" class="text-end"></td>
                            <tr>          
                        </tfoot>        
                    </table>
                </div>
                <!-- ... kode sebelumnya tetap sama sampai bagian modal ... -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= $site_root ?>/JS/crudSales.js"></script>
</body>
</html>