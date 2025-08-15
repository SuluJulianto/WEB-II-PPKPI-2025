<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

// Ubah status
if (isset($_POST['change_status'])) {
  $id = (int)$_POST['id'];
  $status = esc($conn, $_POST['status'] ?? 'pending');
  if (in_array($status, ['pending','selesai','batal'])) {
    $conn->query("UPDATE purchase_order SET status='$status' WHERE id=$id");
    // Jika selesai: tambahkan stok
    if ($status === 'selesai') {
      $r = $conn->query("SELECT barang_id, qty FROM purchase_order WHERE id=$id")->fetch_assoc();
      if ($r) {
        $conn->query("UPDATE barang SET stok = stok + ".(int)$r['qty']." WHERE id=".(int)$r['barang_id']);
      }
    }
  }
  header('Location: po.php'); exit;
}

// Buat PO manual
$message = '';
if (isset($_POST['create_po'])) {
  $barang_id  = (int)($_POST['barang_id'] ?? 0);
  $qty        = max(1, (int)($_POST['qty'] ?? 1));
  $tanggal_po = esc($conn, $_POST['tanggal_po'] ?? date('Y-m-d'));

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
  $message = 'PO Manual berhasil dibuat dengan estimasi kedatangan 3 hari kerja.';
}

// Filter PO
$where_clauses = [];
if (isset($_GET['status']) && in_array($_GET['status'], ['pending', 'selesai', 'batal'])) {
  $where_clauses[] = "po.status = '" . esc($conn, $_GET['status']) . "'";
}
if (isset($_GET['start']) && isset($_GET['end'])) {
  $start_date = esc($conn, $_GET['start']);
  $end_date = esc($conn, $_GET['end']);
  $where_clauses[] = "po.tanggal_po BETWEEN '{$start_date}' AND '{$end_date}'";
}

$where_sql = '';
if (!empty($where_clauses)) {
  $where_sql = " WHERE " . implode(" AND ", $where_clauses);
}

$po = $conn->query("
  SELECT po.*, b.nama_barang
  FROM purchase_order po
  JOIN barang b ON b.id = po.barang_id
  {$where_sql}
  ORDER BY po.tanggal_po DESC, po.id DESC
");

$barang = $conn->query("SELECT id, nama_barang FROM barang ORDER BY nama_barang");
?>

<?php if($message): ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({icon:'success', title:'Berhasil', text:<?= json_encode($message) ?>})
      .then(() => window.location.href = 'pages/po.php');
  });
</script>
<?php endif; ?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="m-0">Purchase Order</h2>
  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddPO">Buat PO Manual</button>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm table-bordered">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Barang</th>
            <th class="text-end">Qty</th>
            <th>Tgl PO</th>
            <th>Estimasi</th>
            <th>Status</th>
            <th style="width:220px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = $po->fetch_assoc()): ?>
          <tr class="<?= $p['status']==='pending' ? 'table-warning' : ($p['status']==='selesai' ? 'table-success' : 'table-danger') ?>">
            <td><?=$p['id']?></td>
            <td><?=htmlspecialchars($p['nama_barang'])?></td>
            <td class="text-end"><?=$p['qty']?></td>
            <td><?=$p['tanggal_po']?></td>
            <td><?=$p['tanggal_estimasi']?></td>
            <td class="text-capitalize"><?=$p['status']?></td>
            <td>
              <button class="btn btn-info btn-sm view-po-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#modalViewPO"
                      data-id="<?=$p['id']?>"
                      data-nama_barang="<?=htmlspecialchars($p['nama_barang'])?>"
                      data-qty="<?=$p['qty']?>"
                      data-tanggal_po="<?=$p['tanggal_po']?>"
                      data-tanggal_estimasi="<?=$p['tanggal_estimasi']?>"
                      data-status="<?=$p['status']?>">View</button>
              <form method="post" class="d-inline">
                <input type="hidden" name="id" value="<?=$p['id']?>">
                <input type="hidden" name="status" value="pending">
                <button name="change_status" class="btn btn-outline-secondary btn-sm">Pending</button>
              </form>
              <form method="post" class="d-inline">
                <input type="hidden" name="id" value="<?=$p['id']?>">
                <input type="hidden" name="status" value="selesai">
                <button name="change_status" class="btn btn-outline-success btn-sm">Selesai</button>
              </form>
              <form method="post" class="d-inline" onsubmit="return confirm('Batalkan PO ini?')">
                <input type="hidden" name="id" value="<?=$p['id']?>">
                <input type="hidden" name="status" value="batal">
                <button name="change_status" class="btn btn-outline-danger btn-sm">Batal</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Add PO -->
<div class="modal fade" id="modalAddPO" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Buat PO Manual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Barang</label>
          <select name="barang_id" class="form-select" required>
            <option value="">-- pilih --</option>
            <?php while($b = $barang->fetch_assoc()): ?>
              <option value="<?=$b['id']?>"><?=htmlspecialchars($b['nama_barang'])?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Qty</label>
          <input type="number" name="qty" class="form-control" value="1" min="1" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Tanggal PO</label>
          <input type="date" name="tanggal_po" class="form-control datepicker" value="<?=date('Y-m-d')?>" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
        <button name="create_po" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Generic Modal View PO -->
<div class="modal fade" id="modalViewPO" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Detail Purchase Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID PO:</strong> <span id="view-id"></span></p>
        <p><strong>Barang:</strong> <span id="view-nama_barang"></span></p>
        <p><strong>Qty:</strong> <span id="view-qty"></span></p>
        <p><strong>Tanggal PO:</strong> <span id="view-tanggal_po"></span></p>
        <p><strong>Estimasi Kedatangan:</strong> <span id="view-tanggal_estimasi"></span></p>
        <p><strong>Status:</strong> <span id="view-status"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const viewPOModal = document.getElementById('modalViewPO');
    viewPOModal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget; // Button that triggered the modal
      const id = button.getAttribute('data-id');
      const nama_barang = button.getAttribute('data-nama_barang');
      const qty = button.getAttribute('data-qty');
      const tanggal_po = button.getAttribute('data-tanggal_po');
      const tanggal_estimasi = button.getAttribute('data-tanggal_estimasi');
      const status = button.getAttribute('data-status');

      // Update the modal's content.
      viewPOModal.querySelector('#view-id').textContent = id;
      viewPOModal.querySelector('#view-nama_barang').textContent = nama_barang;
      viewPOModal.querySelector('#view-qty').textContent = qty;
      viewPOModal.querySelector('#view-tanggal_po').textContent = tanggal_po;
      viewPOModal.querySelector('#view-tanggal_estimasi').textContent = tanggal_estimasi;
      viewPOModal.querySelector('#view-status').textContent = status;
    });
  });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>