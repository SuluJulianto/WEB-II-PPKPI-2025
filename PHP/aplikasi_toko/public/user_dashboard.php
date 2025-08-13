<?php
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['User']);
$current_user = $_SESSION['auth_nama'];
$site_root = $_SESSION['site_root'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar-header a { color: #fff; text-decoration: none; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
    </style>
</head>
<body>
    <div class="main-content">
        <?php include '_user_sidebar.php'; // Memanggil sidebar user terpusat ?>
        
        <div class="content">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="card-title">Halo, <?= htmlspecialchars($current_user) ?>!</h2>
                    <p class="card-text text-muted">Selamat datang di Aplikasi Toko. Di bawah ini adalah daftar inventori yang tersedia saat ini.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Daftar Inventori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>SKU</th>
                                    <th>Nama Item</th>
                                    <th>Satuan (UOM)</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-view-body">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // JavaScript untuk memuat data inventori
        $(function() {
            $.ajax({
                url: '<?= $site_root ?>/pageCRUD/CRUDInventory.php', // Menggunakan backend inventori yang sudah ada
                method: 'GET',
                data: { action: 'read' },
                dataType: 'json',
                success: function(response) {
                    let rows = '';
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {
                            rows += `<tr>
                                        <td>${item.sku}</td>
                                        <td>${item.product}</td>
                                        <td>${item.uom}</td>
                                    </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="3" class="text-center">Inventori kosong.</td></tr>';
                    }
                    $('#inventory-view-body').html(rows);
                }
            });
        });
    </script>
</body>
</html>