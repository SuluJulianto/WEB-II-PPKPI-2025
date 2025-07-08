<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION["site_root"])) {
        // Jika session belum ada, panggil bootstrap
        require_once $_SERVER['DOCUMENT_ROOT'] . '/toko/public/bootstrap.php';
    }
    $site_root = $_SESSION["site_root"];

    require_once $_SESSION["dir_root"] . '/module/dbconnect.php';
    
    // Ambil ID dari URL, default 0 jika tidak ada
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $salesData = null; // Inisialisasi data penjualan

    if ($id > 0) {
        // Jika ada ID, ambil data dari database
        // Kita akan menggunakan AJAX untuk memuat data, jadi PHP di sini hanya untuk struktur
    }

    $productList = db()->query("SELECT * FROM product ORDER BY product ASC")->fetchAll(PDO::FETCH_ASSOC);
    $customerList = db()->query("SELECT * FROM customer ORDER BY customer ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id > 0 ? 'Edit' : 'Tambah' ?> Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        const base_url = "<?= $site_root ?>";
        const productData = <?= json_encode($productList) ?>;
        const salesId = <?= $id ?>; // Kirim ID penjualan ke JavaScript
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker@2.0.12/dist/litepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .header-row, .row_line { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
        .header-row span { font-weight: bold; flex: 1; text-align: center; }
        .readonly { background-color: #e9ecef; }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h3><?= $id > 0 ? 'Edit' : 'Tambah' ?> Penjualan</h3>
        <form id="salesForm" method="post">
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            
            <fieldset id="header" class="border p-3 mb-3">
                <legend class="w-auto px-2">Header</legend>
                <div class="input-group mb-2">
                    <span class="input-group-text" style="width: 120px;">Tanggal</span>
                    <input type="text" class="form-control" placeholder="DD-MM-YYYY" name="sales_date" id="sales_date">
                </div>
                <div class="input-group">
                    <span class="input-group-text" style="width: 120px;">Customer</span>
                    <select name="customer" id="customer" class="form-select">
                        <option value="">Pilih Customer</option>
                        <?php foreach ($customerList as $cust): ?>
                            <option value="<?= $cust['id'] ?>"><?= $cust['customer'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </fieldset>

            <fieldset id="detail_section" class="border p-3 mb-3">
                <legend class="w-auto px-2">Detail Produk</legend>
                <div class="header-row d-none d-md-flex">
                    <span style="flex: 3;">Produk</span>
                    <span style="flex: 2;">SKU</span>
                    <span style="flex: 1.5;">Harga</span>
                    <span style="flex: 1;">UOM</span>
                    <span style="flex: 1;">Qty</span>
                    <span style="flex: 1.5;">Total</span>
                    <span style="width: 40px;"></span>
                </div>
                <div id="detail_container"></div>
            </fieldset>

            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Sub Total</th>
                                <td class="text-end" id="subtotal_value">0</td>
                            </tr>
                            <tr>
                                <th>Diskon (%)</th>
                                <td class="d-flex justify-content-end">
                                    <input type="number" id="discount_percent" class="form-control" style="width: 80px;" value="0">
                                </td>
                            </tr>
                            <tr>
                                <th>Diskon (Rp)</th>
                                <td class="text-end" id="discount_value">0</td>
                            </tr>
                            <tr>
                                <th>Pajak (11%)</th>
                                <td class="text-end" id="tax_value">0</td>
                            </tr>
                            <tr>
                                <th>Total Bayar</th>
                                <td class="text-end h5" id="grand_total">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="button" id="btn_preview" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#printPreview">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button type="submit" id="btn_save" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?= $site_root ?>/public/pageSales.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <div class="modal fade" id="printPreview" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="print_area">
                    </div>
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