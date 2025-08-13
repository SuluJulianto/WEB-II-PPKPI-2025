<?php
// toko/public/pageSales.php

// Memanggil penjaga keamanan di bagian atas
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['Manager', 'Admin']);

// Menyetel variabel session yang dibutuhkan untuk link dan sidebar
if (!isset($_SESSION["site_root"])) {
    $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
}
$site_root = $_SESSION["site_root"];
$user_role = $_SESSION['auth_role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Penjualan</title>
    <script> const base_url = "<?= $site_root ?>"; </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
        #salesheader .header-row { cursor: pointer; transition: background-color 0.2s ease-in-out; }
        #salesheader .header-row:hover { background-color: #e9ecef; }
        #salesheader .header-row.table-active { background-color: #cfe2ff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="main-content">
        
        <?php include '_sidebar.php'; // Memanggil sidebar terpusat ?>

        <div class="content">
            <h2 class="mb-4">Manajemen Penjualan</h2>
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Transaksi</h5>
                             <a href="<?= $site_root ?>/pageCRUD/crudSales.php" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Tambah Transaksi
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th class="text-end">Total (Rp)</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="salesheader">
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h5 class="mb-0" id="detail-title">Pilih transaksi untuk melihat detail...</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="salesdetail">
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white"><h5 class="modal-title">Konfirmasi Penghapusan</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><p>Apakah Anda yakin ingin menghapus data penjualan ini?</p></div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" class="btn btn-danger" id="btn-confirm-delete">Ya, Hapus</button></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $site_root ?>/JS/setSales.js"></script>
</body>
</html>