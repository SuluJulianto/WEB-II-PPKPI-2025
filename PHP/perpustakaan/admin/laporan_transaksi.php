<?php include 'header.php'; ?>

<div class="page-header">
    <h3>Laporan Transaksi</h3>
</div>

<div class="card">
    <div class="card-header">
        Filter Laporan Berdasarkan Tanggal Peminjaman
    </div>
    <div class="card-body">
        <form action="laporan_filter_transaksi.php" method="post">
            <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-filter"></span> Filter
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>