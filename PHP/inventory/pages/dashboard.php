<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

// Ambil filter tanggal untuk nilai default input
$tgl_mulai   = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
$tgl_selesai = isset($_GET['end'])   ? $_GET['end']   : date('Y-m-d');
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="m-0">Dashboard Inventory</h2>
  <form id="filter-form" class="row g-2" method="get">
    <div class="col-auto">
      <label class="form-label mb-0 small">Dari</label>
      <input type="date" id="start-date" name="start" value="<?=htmlspecialchars($tgl_mulai)?>" class="form-control datepicker">
    </div>
    <div class="col-auto">
      <label class="form-label mb-0 small">Sampai</label>
      <input type="date" id="end-date" name="end" value="<?=htmlspecialchars($tgl_selesai)?>" class="form-control datepicker">
    </div>
    <div class="col-auto align-self-end">
      <button class="btn btn-primary">Filter</button>
    </div>
  </form>
</div>

<div class="row g-3">
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Nama Barang</th>
                <th class="text-end">Stok Awal</th>
                <th class="text-end">Stok Akhir</th>
                <th class="text-end">Penjualan</th>
                <th class="text-end">PO Pending</th>
                <th class="text-end">Total Kebutuhan</th>
              </tr>
            </thead>
            <tbody id="dashboard-tbody">
              <!-- Data will be loaded by AJAX -->
            </tbody>
          </table>
        </div>
        <p class="text-muted small mt-2 mb-0">
          *Logika: jika stok = 0 dan terjadi penjualan, sistem otomatis membuat PO dengan estimasi kedatangan +3 hari (pre-order).
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Initialize datepickers
    flatpickr(".datepicker", {
      dateFormat: "Y-m-d",
    });

    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const tableBody = document.getElementById('dashboard-tbody');
    const filterForm = document.getElementById('filter-form');

    // Function to fetch and update table data
    const updateDashboardTable = async (start, end) => {
      // Show loading state
      tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Memuat data...</td></tr>';

      try {
        const response = await fetch(`pages/ajax/dashboard_table.php?start=${start}&end=${end}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.text();
        tableBody.innerHTML = data;
      } catch (error) {
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Gagal memuat data. ${error.message}</td></tr>`;
      }
    };

    // Event listener for the filter form
    filterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;
      updateDashboardTable(startDate, endDate);
    });

    // Initial data load
    updateDashboardTable(startDateInput.value, endDateInput.value);
  });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
