<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["site_root"])) {
    require_once 'bootstrap.php';
}

$site_root = $_SESSION["site_root"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembelian</title>
    <script>
        const base_url = "<?= $site_root ?>";
    </script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>Manajemen Pembelian</h2>
        
        <form id="form-purchase" class="mb-4 card card-body">
            <input type="hidden" id="purchase_id" name="id">
            
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="purchase_date" class="form-label">Tanggal</label>
                    <input type="date" id="purchase_date" name="purchase_date" class="form-control" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="id_product" class="form-label">ID Produk</label>
                    <input type="number" id="id_product" name="id_product" class="form-control" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="qty" class="form-label">Jumlah (Qty)</label>
                    <input type="number" id="qty" name="qty" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" id="price" name="price" step="0.01" class="form-control" required>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <button type="button" id="btn-reset" class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </form>

        <h4>Daftar Detail Pembelian</h4>
        <table id="tabel-purchase" class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">ID Produk</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>

    <script src="<?= $site_root ?>/JS/setPurchase.js"></script>
</body>

</html>