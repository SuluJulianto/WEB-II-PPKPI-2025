<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/toko/auth_check.php';
require_role(['User']); // Hanya User yang bisa akses

if (!isset($_SESSION["site_root"])) {
    require_once 'bootstrap.php';
}
$site_root = $_SESSION["site_root"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Inventori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="fas fa-boxes"></i> Daftar Item Inventori</h3>
            <a href="user_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
        <div class="card shadow-sm">
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            $.ajax({
                url: '<?= $site_root ?>/pageCRUD/CRUDInventory.php',
                method: 'GET',
                data: { action: 'read' },
                dataType: 'json',
                success: function(response) {
                    let rows = '';
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {
                            rows += `<tr><td>${item.sku}</td><td>${item.product}</td><td>${item.uom}</td></tr>`;
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