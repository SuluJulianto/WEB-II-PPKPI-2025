<?php
require_once dirname(__DIR__) . '/auth_check.php';
// HANYA Manager & Admin yang bisa akses
require_role(['Manager', 'Admin']); 

$site_root = $_SESSION['site_root'];
$user_role = $_SESSION['auth_role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Customer</title>
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
    </style>
</head>
<body>
    <div class="main-content">
        <?php include '_sidebar.php'; // Memanggil sidebar terpusat ?>

        <div class="content">
            <h2 class="mb-4">Manajemen Customer</h2>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white text-end">
                    <button id="btn-add-customer" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Customer</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr><th>ID</th><th>Nama Customer</th><th>Alamat</th><th class="text-center">Aksi</th></tr>
                            </thead>
                            <tbody id="customer-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="customerModal" tabindex="-1">
        </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $site_root ?>/JS/setCustomers.js"></script>
</body>
</html>