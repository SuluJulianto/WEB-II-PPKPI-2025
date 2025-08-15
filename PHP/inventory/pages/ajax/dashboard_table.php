<?php
include __DIR__ . '/../../config/db.php';

// Helper function to safely get data from array
function get_data($arr, $key, $default = 0) {
  return isset($arr[$key]) ? (int)$arr[$key] : $default;
}

// Ambil filter tanggal
$tgl_mulai   = isset($_GET['start']) ? esc($conn, $_GET['start']) : date('Y-m-01');
$tgl_selesai = isset($_GET['end'])   ? esc($conn, $_GET['end'])   : date('Y-m-d');

// --- 1. Ambil semua data master ---
$barang_data = [];
$q_barang = $conn->query("SELECT id, nama_barang, stok FROM barang ORDER BY nama_barang");
while ($r = $q_barang->fetch_assoc()) {
  $barang_data[$r['id']] = $r;
}

// --- 2. Ambil data transaksi berdasarkan filter tanggal ---

// Penjualan pada rentang tanggal
$penjualan_data = [];
$q_penjualan = $conn->query("
  SELECT barang_id, SUM(qty) AS total
  FROM penjualan
  WHERE tanggal BETWEEN '{$tgl_mulai}' AND '{$tgl_selesai}'
  GROUP BY barang_id
");
while ($r = $q_penjualan->fetch_assoc()) {
  $penjualan_data[$r['barang_id']] = $r['total'];
}

// Penjualan setelah rentang tanggal (untuk perhitungan stok akhir)
$penjualan_setelah_data = [];
$q_penjualan_setelah = $conn->query("
  SELECT barang_id, SUM(qty) AS total
  FROM penjualan
  WHERE tanggal > '{$tgl_selesai}'
  GROUP BY barang_id
");
while ($r = $q_penjualan_setelah->fetch_assoc()) {
  $penjualan_setelah_data[$r['barang_id']] = $r['total'];
}

// PO pending pada rentang tanggal
$po_data = [];
$q_po = $conn->query("
  SELECT barang_id, SUM(qty) AS total
  FROM purchase_order
  WHERE tanggal_po BETWEEN '{$tgl_mulai}' AND '{$tgl_selesai}'
    AND status = 'pending'
  GROUP BY barang_id
");
while ($r = $q_po->fetch_assoc()) {
  $po_data[$r['barang_id']] = $r['total'];
}

// Penjualan dari tanggal mulai sampai sekarang (untuk perhitungan stok awal)
$penjualan_dari_awal_periode_data = [];
$q_penjualan_dari_awal_periode = $conn->query("
  SELECT barang_id, SUM(qty) AS total
  FROM penjualan
  WHERE tanggal >= '{$tgl_mulai}'
  GROUP BY barang_id
");
while ($r = $q_penjualan_dari_awal_periode->fetch_assoc()) {
  $penjualan_dari_awal_periode_data[$r['barang_id']] = $r['total'];
}

// PO selesai dari tanggal mulai sampai sekarang (untuk perhitungan stok awal)
$po_selesai_dari_awal_periode_data = [];
$q_po_selesai_dari_awal_periode = $conn->query("
  SELECT barang_id, SUM(qty) AS total
  FROM purchase_order
  WHERE tanggal_po >= '{$tgl_mulai}' AND status = 'selesai'
  GROUP BY barang_id
");
while ($r = $q_po_selesai_dari_awal_periode->fetch_assoc()) {
  $po_selesai_dari_awal_periode_data[$r['barang_id']] = $r['total'];
}


// --- 3. Generate table rows dengan kalkulasi stok yang benar ---
foreach($barang_data as $id => $b):
  // Ambil data transaksi
  $sales_in_period   = get_data($penjualan_data, $id);
  $sales_after_period = get_data($penjualan_setelah_data, $id);
  $po_in_period      = get_data($po_data, $id);

  // Initialize variables before assignment to prevent 'Undefined variable' notices
  $sales_from_start_to_now = 0;
  $po_completed_from_start_to_now = 0;
  $stok_awal = 0; // Already there, but keeping for clarity
  $stok_akhir = 0;

  // Get data for stok_awal calculation
  $sales_from_start_to_now = get_data($penjualan_dari_awal_periode_data, $id);
  $po_completed_from_start_to_now = get_data($po_selesai_dari_awal_periode_data, $id);
  
  // Stok saat ini dari database
  $stok_saat_ini = (int)$b['stok'];

  // Hitung STOK AWAL pada tanggal mulai
  // Logika: Stok Awal = Stok Saat Ini + Penjualan dari tgl_mulai s/d sekarang - PO Selesai dari tgl_mulai s/d sekarang
  $stok_awal = $stok_saat_ini + $sales_from_start_to_now - $po_completed_from_start_to_now;

  // Hitung STOK AKHIR pada tanggal selesai
  // Logika: Stok akhir periode = Stok saat ini - Penjualan setelah periode
  $stok_akhir = $stok_saat_ini - $sales_after_period;

  // Total kebutuhan = Penjualan pada periode + PO pending pada periode
  $total_kebutuhan = $sales_in_period + $po_in_period;
?>
<tr class="<?= $stok_akhir <= 0 ? 'table-danger' : '' ?>">
  <td><?= htmlspecialchars($b['nama_barang']) ?></td>
  <td class="text-end fw-semibold"><?= $stok_awal ?></td>
  <td class="text-end fw-semibold"><?= $stok_akhir ?></td>
  <td class="text-end"><?= $sales_in_period ?></td>
  <td class="text-end">
    <?php if ($po_in_period > 0): ?>
      <a href="pages/po.php?status=pending&start=<?= urlencode($tgl_mulai) ?>&end=<?= urlencode($tgl_selesai) ?>"><?= $po_in_period ?></a>
    <?php else: ?>
      <?= $po_in_period ?>
    <?php endif; ?>
  </td>
  <td class="text-end fw-bold"><?= $total_kebutuhan ?></td>
</tr>
<?php endforeach; ?>

<?php if(empty($barang_data)): ?>
<tr>
  <td colspan="6" class="text-center text-muted">Tidak ada data barang.</td>
</tr>
<?php endif; ?>
