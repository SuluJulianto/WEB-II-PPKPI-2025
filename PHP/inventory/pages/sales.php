<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

// Create sale
$message = '';
if (isset($_POST['create'])) {
  $barang_id = (int)($_POST['barang_id'] ?? 0);
  $qty       = max(1, (int)($_POST['qty'] ?? 1));
  $tanggal   = esc($conn, $_POST['tanggal'] ?? date('Y-m-d'));

  // Ambil stok barang
  $bRes = $conn->query("SELECT * FROM barang WHERE id=$barang_id");
  if ($bRes && $bRes->num_rows) {
    $b = $bRes->fetch_assoc();
    $stok = (int)$b['stok'];

    // Insert penjualan
    $conn->query("INSERT INTO penjualan (barang_id, qty, tanggal) VALUES ($barang_id, $qty, '$tanggal')");

    if ($stok > 0) {
      // Kurangi stok (tidak boleh negatif)
      $baru = max(0, $stok - $qty);
      $conn->query("UPDATE barang SET stok=$baru WHERE id=$barang_id");
      if ($baru == 0) {
        $message = 'Stok habis setelah penjualan. Pertimbangkan membuat PO.';
      } else {
        $message = 'Penjualan tersimpan dan stok diperbarui.';
      }
    } else {
      // Stok 0: otomatis buat PO (pre-order)
      $tanggal_po = date('Y-m-d');
      
      // Logika estimasi 3 hari kerja
      $estimasi_timestamp = strtotime($tanggal_po);
      $hari_kerja_dihitung = 0;
      while ($hari_kerja_dihitung < 3) {
        $estimasi_timestamp = strtotime('+1 day', $estimasi_timestamp);
        $hari_dalam_minggu = (int)date('N', $estimasi_timestamp);
        if ($hari_dalam_minggu < 6) { // Hitung hanya Senin (1) sampai Jumat (5)
          $hari_kerja_dihitung++;
        }
      }
      $tanggal_estimasi = date('Y-m-d', $estimasi_timestamp);

      $conn->query("
        INSERT INTO purchase_order (barang_id, qty, tanggal_po, tanggal_estimasi, status)
        VALUES ($barang_id, $qty, '$tanggal_po', '$tanggal_estimasi', 'pending')
      ");
      $message = 'Stok 0: Penjualan diterima sebagai pre-order. PO otomatis dibuat dengan estimasi kedatangan 3 hari kerja.';
    }
  } else {
    $message = 'Barang tidak ditemukan.';
  }
}

// Data dropdown barang
$barang = $conn->query("SELECT id, nama_barang, stok FROM barang ORDER BY nama_barang");

// Tabel penjualan terbaru
$penjualan = $conn->query("
  SELECT p.id, b.nama_barang, p.qty, p.tanggal
  FROM penjualan p
  JOIN barang b ON b.id = p.barang_id
  ORDER BY p.tanggal DESC, p.id DESC
  LIMIT 100
");
?>

<h2>Input Penjualan</h2>

<?php if($message): ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({icon:'info', title:'Info', text:<?= json_encode($message) ?>});
  });
</script>
<?php endif; ?>

<div class="card shadow-sm mb-4">
  <div class="card-body">
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Barang</label>
        <select name="barang_id" class="form-select" required>
          <option value="">-- pilih --</option>
          <?php while($b = $barang->fetch_assoc()): ?>
          <option value="<?=$b['id']?>"><?=htmlspecialchars($b['nama_barang'])?> (stok: <?=$b['stok']?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Qty</label>
        <input type="number" name="qty" class="form-control" value="1" min="1" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" value="<?=date('Y-m-d')?>" class="form-control datepicker" required>
      </div>
      <div class="col-12">
        <button name="create" class="btn btn-primary">Simpan Penjualan</button>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="mb-3">Penjualan Terbaru</h5>
    <div class="table-responsive">
      <table class="table table-sm table-bordered">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Barang</th>
            <th class="text-end">Qty</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = $penjualan->fetch_assoc()): ?>
          <tr>
            <td><?=$p['id']?></td>
            <td><?=htmlspecialchars($p['nama_barang'])?></td>
            <td class="text-end"><?=$p['qty']?></td>
            <td><?=$p['tanggal']?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    flatpickr(".datepicker", {
      dateFormat: "Y-m-d",
    });
  });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>