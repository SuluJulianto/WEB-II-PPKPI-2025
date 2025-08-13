$(document).ready(function () {
  // 1. Muat data penjualan saat halaman siap
  readSales();

  // Inisialisasi modal Bootstrap untuk konfirmasi hapus
  const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
  let salesIdToDelete = null;

  // 2. Fungsi untuk memuat data header penjualan via AJAX
  function readSales() {
    $.ajax({
      url: `${base_url}/module/sales.php`,
      type: "POST",
      dataType: "json",
      data: { action: "readData" },
      success: function (result) {
        let trow = "";
        if (result.response === 1 && result.data.length > 0) {
          $.each(result.data, function (index, item) {
            const date = new Date(item.sales_date);
            const formattedDate = `${date.getDate().toString().padStart(2, "0")}-${(date.getMonth() + 1).toString().padStart(2, "0")}-${date.getFullYear()}`;
            
            trow += `
              <tr class='header-row' data-sales_id='${item.id}' data-customer='${item.customer}' data-date='${formattedDate}'>
                <td data-label="Tanggal">${formattedDate}</td>
                <td data-label="Customer">${item.customer}</td>
                <td data-label="Total" class="text-end">${parseFloat(item.total).toLocaleString("id-ID")}</td>
                <td data-label="Aksi" class="text-center">
                  <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}" title="Edit Transaksi">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}" title="Hapus Transaksi">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>`;
          });
        } else {
          trow = "<tr><td colspan='4' class='text-center fst-italic'>Belum ada data penjualan.</td></tr>";
        }
        $("#salesheader").html(trow);
      },
      error: function () {
        $("#salesheader").html("<tr><td colspan='4' class='text-center text-danger'>Gagal memuat data dari server.</td></tr>");
      },
    });
  }

  // 3. Event listener saat baris header diklik untuk melihat detail
  $("#salesheader").on("click", ".header-row", function () {
    $(".header-row").removeClass("table-active");
    $(this).addClass("table-active");

    const rowId = $(this).data("sales_id");
    const customerName = $(this).data("customer");
    const salesDate = $(this).data("date");

    $("#detail-title").html(`Transaksi oleh: <strong>${customerName}</strong> <br><small>${salesDate}</small>`);

    $.ajax({
      url: `${base_url}/module/sales.php`,
      type: "POST",
      dataType: "JSON",
      data: { sales_id: rowId, action: "queryData" },
      success: function (result) {
        let trow = "";
        let totalSales = 0;

        if (result.response === 1 && result.data.length > 0) {
          $.each(result.data, function (index, item) {
            const totalPerRow = parseFloat(item.price) * parseFloat(item.qty);
            totalSales += totalPerRow;

            trow += `
              <tr>
                <td data-label="Produk">${item.product}</td>
                <td data-label="Qty">${parseFloat(item.qty).toLocaleString("id-ID")} ${item.uom}</td>
                <td data-label="Harga" class="text-end">${parseFloat(item.price).toLocaleString("id-ID")}</td>
                <td data-label="Total" class="text-end">${totalPerRow.toLocaleString("id-ID")}</td>
              </tr>`;
          });

          // Baris untuk menampilkan total keseluruhan
          trow += `
            <tr class="table-light">
              <th colspan="3" class="text-end">Total Penjualan:</th>
              <th class="text-end">${totalSales.toLocaleString("id-ID")}</th>
            </tr>`;

          $("#salesdetail").html(trow);
        } else {
          $("#salesdetail").html("<tr><td colspan='4' class='text-center fst-italic'>Data detail tidak ditemukan.</td></tr>");
        }
      },
      error: function () {
        $("#salesdetail").html("<tr><td colspan='4' class='text-center text-danger'>Gagal memuat detail transaksi.</td></tr>");
      },
    });
  });

  // 4. Event listener untuk tombol EDIT
  $("#salesheader").on("click", ".btn-edit", function (e) {
    e.stopPropagation(); // Mencegah event klik pada baris ikut terpicu
    const salesId = $(this).data("id");
    window.location.href = `${base_url}/pageCRUD/crudSales.php?id=${salesId}`;
  });

  // 5. Event listener untuk tombol DELETE (membuka modal)
  $("#salesheader").on("click", ".btn-delete", function (e) {
    e.stopPropagation();
    
    // Ambil data dari baris yang akan dihapus
    const row = $(this).closest('tr');
    salesIdToDelete = $(this).data("id");
    const customer = row.data('customer');
    const date = row.data('date');

    // Isi konten modal sebelum menampilkannya
    $('#customer-to-delete').text(customer);
    $('#date-to-delete').text(date);

    deleteModal.show();
  });

  // 6. Event listener untuk tombol konfirmasi hapus di dalam MODAL
  $("#btn-confirm-delete").on("click", function () {
    if (!salesIdToDelete) return;

    $.ajax({
      url: `${base_url}/module/sales.php`,
      method: "POST",
      dataType: "json",
      data: {
        action: "deleteData",
        sales_id: salesIdToDelete,
      },
      success: function (response) {
        deleteModal.hide(); // Sembunyikan modal
        if (response.response === 1) {
            // Hapus baris dari tabel dengan animasi fade out
            $(`tr[data-sales_id='${salesIdToDelete}']`).fadeOut(500, function() {
                $(this).remove();
                // Kosongkan detail jika yang dihapus adalah yang sedang aktif
                if ($(this).hasClass("table-active")) {
                    $("#salesdetail").html("");
                    $("#detail-title").text("Pilih transaksi untuk melihat detail...");
                }
            });
        } else {
          alert("Gagal menghapus data: " + response.data);
        }
      },
      error: function () {
        deleteModal.hide();
        alert("Terjadi kesalahan saat menghubungi server.");
      },
    });
  });

});