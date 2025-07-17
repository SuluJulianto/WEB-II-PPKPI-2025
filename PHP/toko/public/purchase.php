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
    <title>Purchase</title>
    <script>
        // PERBAIKAN: Mengubah nama variabel dari base_URL menjadi base_url (huruf kecil)
        const base_url = "<?= $site_root ?>";
    </script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>Pembelian</h2>
        <form id="form-purchase" class="mb-4">
            <input hidden id="id_pch">
            <div class="mb-2">
                <label for="product" class="form-label">Produk</label>
                <input type="text" id="product" class="form-control">
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" id="jumlah" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary">Reset</button>
        </form>

        <table id="tabel-purchase" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="<?= $site_root ?>/JS/setPurchase.js"></script>
    
</body>

</html>