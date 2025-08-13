<?php
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['Manager', 'Admin']);

if (!isset($_SESSION["site_root"])) {
    $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
}
require_once dirname(__DIR__) . '/module/dbconnect.php';

$site_root = $_SESSION["site_root"];
$user_role = $_SESSION['auth_role'];

// Ambil data supplier dan produk dari database
$suppliers = db()->query("SELECT * FROM supplier ORDER BY supplier ASC")->fetchAll(PDO::FETCH_ASSOC);
// Penting: Query produk tidak mengambil harga, karena harga beli dimasukkan manual saat transaksi
$products = db()->query("SELECT id, product, sku, uom FROM product ORDER BY product ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        const base_url = "<?= $site_root ?>";
        const productData = <?= json_encode($products) ?>;
    </script>
    <style>
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
        .header-row, .row_line { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
        .header-row span { font-weight: bold; flex: 1; text-align: center; }
        .readonly { background-color: #e9ecef; }
    </style>
</head>
<body>
    <div class="main-content">
        <?php include '_sidebar.php'; ?>
        
        <div class="content">
            <h2 class="mb-4">Form Pembelian Baru</h2>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form id="form-purchase">
                        <fieldset class="border p-3 mb-4 rounded">
                            <legend class="w-auto px-2 fs-6">Info Faktur</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                                    <input type="date" id="purchase_date" name="purchase_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="id_supplier" class="form-label">Supplier</label>
                                    <select id="id_supplier" name="id_supplier" class="form-select" required>
                                        <option value="" disabled selected>-- Pilih Supplier --</option>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <option value="<?= $supplier['id'] ?>"><?= htmlspecialchars($supplier['supplier']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-3 mb-4 rounded">
                            <legend class="w-auto px-2 fs-6">Detail Barang</legend>
                            <div class="header-row d-none d-md-flex">
                                <span style="flex: 3;">Produk</span>
                                <span style="flex: 2;">SKU</span>
                                <span style="flex: 1;">UOM</span>
                                <span style="flex: 1;">Qty</span>
                                <span style="flex: 1.5;">Harga Beli</span>
                                <span style="flex: 1.5;">Total</span>
                                <span style="width: 40px;"></span>
                            </div>
                            <div id="detail_container">
                                </div>
                        </fieldset>

                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th class="text-end"><h5>Grand Total</h5></th>
                                            <td class="text-end h5" id="grand_total_value">Rp 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="button" id="btn-add-row" class="btn btn-success"><i class="fas fa-plus me-2"></i> Tambah Barang</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Simpan Transaksi</button>
                            <button type="reset" id="btn-reset" class="btn btn-secondary"><i class="fas fa-sync-alt me-2"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $site_root ?>/JS/setPurchase.js"></script>
</body>
</html>