<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

// CREATE
if (isset($_POST['create'])) {
  $nama  = esc($conn, $_POST['nama_barang'] ?? '');
  $stok  = (int)($_POST['stok'] ?? 0);
  $harga = (float)($_POST['harga'] ?? 0);
  if ($nama !== '') {
    $conn->query("INSERT INTO barang (nama_barang, stok, harga) VALUES ('$nama', $stok, $harga)");
  }
  header('Location: inventory.php'); exit;
}

// UPDATE
if (isset($_POST['update'])) {
  $id    = (int)$_POST['id'];
  $nama  = esc($conn, $_POST['nama_barang'] ?? '');
  $stok  = (int)($_POST['stok'] ?? 0);
  $harga = (float)($_POST['harga'] ?? 0);
  if ($id > 0) {
    $conn->query("UPDATE barang SET nama_barang='$nama', stok=$stok, harga=$harga WHERE id=$id");
  }
  header('Location: inventory.php'); exit;
}

// DELETE
if (isset($_POST['delete'])) {
  $id = (int)$_POST['id'];
  if ($id > 0) {
    $conn->query("DELETE FROM barang WHERE id=$id");
  }
  header('Location: inventory.php'); exit;
}

$barang = $conn->query("SELECT * FROM barang ORDER BY nama_barang");
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="m-0">Inventory (Barang)</h2>
  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah Barang</button>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>Nama Barang</th>
            <th class="text-end">Stok</th>
            <th class="text-end">Harga</th>
            <th style="width:160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($b = $barang->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($b['nama_barang']) ?></td>
            <td class="text-end"><?= (int)$b['stok'] ?></td>
            <td class="text-end">Rp <?= number_format($b['harga'],0,',','.') ?></td>
            <td>
              <button class="btn btn-primary btn-sm edit-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEdit"
                      data-id="<?=$b['id']?>"
                      data-nama_barang="<?=htmlspecialchars($b['nama_barang'])?>"
                      data-stok="<?=$b['stok']?>"
                      data-harga="<?=$b['harga']?>">Edit</button>
              <form class="d-inline" method="post" onsubmit="return confirm('Hapus barang ini?')">
                <input type="hidden" name="id" value="<?=$b['id']?>">
                <button name="delete" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Tambah Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Nama Barang</label>
          <input name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Stok</label>
          <input type="number" name="stok" class="form-control" value="0" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Harga</label>
          <input type="number" name="harga" class="form-control" step="0.01" value="0" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
        <button name="create" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Generic Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-2">
          <label class="form-label">Nama Barang</label>
          <input name="nama_barang" id="edit-nama_barang" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Stok</label>
          <input type="number" name="stok" id="edit-stok" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Harga</label>
          <input type="number" name="harga" id="edit-harga" class="form-control" step="0.01" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
        <button name="update" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('modalEdit');
    editModal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget; // Button that triggered the modal
      const id = button.getAttribute('data-id');
      const nama_barang = button.getAttribute('data-nama_barang');
      const stok = button.getAttribute('data-stok');
      const harga = button.getAttribute('data-harga');

      // Update the modal's content.
      const modalIdInput = editModal.querySelector('#edit-id');
      const modalNamaBarangInput = editModal.querySelector('#edit-nama_barang');
      const modalStokInput = editModal.querySelector('#edit-stok');
      const modalHargaInput = editModal.querySelector('#edit-harga');

      modalIdInput.value = id;
      modalNamaBarangInput.value = nama_barang;
      modalStokInput.value = stok;
      modalHargaInput.value = harga;
    });
  });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>