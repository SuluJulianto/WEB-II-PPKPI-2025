<?php
// Memanggil penjaga keamanan dan menyetel variabel yang dibutuhkan
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['Manager', 'Staf Gudang']);

$site_root = $_SESSION['site_root'];
$user_role = $_SESSION['auth_role']; // Dibutuhkan oleh sidebar
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Inventori</title>
    <script> const base_url = "<?= $site_root ?>"; </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Menambahkan CSS untuk layout sidebar + konten */
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
    </style>
</head>
<body>
    <div class="main-content">
        
        <?php include '_sidebar.php'; // Memanggil sidebar terpusat ?>

        <div class="content">
            <h2 class="mb-4">Manajemen Inventori</h2>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white text-end">
                    <button id="btn-add-item" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Item Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>SKU</th>
                                    <th>Nama Item</th>
                                    <th>Satuan (UOM)</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="itemForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="item_id" name="id">
                        <input type="hidden" id="action" name="action">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU (Kode Barang)</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                        </div>
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Nama Item</label>
                            <input type="text" class="form-control" id="item_name" name="product" required>
                        </div>
                        <div class="mb-3">
                            <label for="uom" class="form-label">Satuan (UOM)</label>
                            <input type="text" class="form-control" id="uom" name="uom" placeholder="Contoh: KG, PCS, BOX" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $site_root ?>/JS/setInventory.js"></script>
</body>
</html>