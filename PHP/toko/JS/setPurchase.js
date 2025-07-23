$(function () {
  // 1. Muat data saat halaman pertama kali dibuka
  loadData();

  // Fungsi untuk memuat data dari server dan menampilkannya di tabel
  function loadData() {
    $.ajax({
      url: base_url + "/pageCRUD/CRUDPurchase.php",
      method: "GET",
      data: { action: "read" },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          let tableRows = "";
          response.data.forEach(function (item) {
            
            // PERBAIKAN DI SINI:
            // Cek dulu apakah data tanggal ada sebelum diformat
            let formattedDate = ''; // Buat variabel kosong sebagai default
            if (item.purchase_date) { // Hanya format jika item.purchase_date tidak kosong
                let date = new Date(item.purchase_date);
                // Pastikan tanggal valid sebelum diubah formatnya
                if (!isNaN(date.getTime())) {
                    formattedDate = date.toISOString().split('T')[0];
                }
            }
            
            tableRows += `
              <tr>
                <td class="text-center">${item.id}</td>
                <td class="text-center">${formattedDate}</td>
                <td class="text-center">${item.id_product}</td>
                <td class="text-end">${parseFloat(item.qty).toLocaleString("id-ID")}</td>
                <td class="text-end">${parseFloat(item.price).toLocaleString("id-ID")}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </td>
              </tr>`;
          });
          $("#tabel-purchase tbody").html(tableRows);
        }
      },
      error: function () {
        alert("Gagal memuat data dari server.");
      }
    });
  }

  // Fungsi untuk membersihkan form
  function resetForm() {
    $("#purchase_id").val(""); // Kosongkan ID tersembunyi
    $("#form-purchase")[0].reset(); // Reset semua input di form
  }

  // 2. Logika saat form disubmit (untuk create dan update)
  $("#form-purchase").on("submit", function (e) {
    e.preventDefault();
    
    let url = base_url + "/pageCRUD/CRUDPurchase.php";
    let purchaseId = $("#purchase_id").val();
    let action = purchaseId ? "update" : "create";
    let formData = $(this).serialize() + "&action=" + action;

    $.ajax({
      url: url,
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          alert(response.message);
          resetForm();
          loadData();
        } else {
          alert("Gagal: " + response.message);
        }
      },
      error: function () {
        alert("Terjadi kesalahan saat mengirim data.");
      }
    });
  });

  // 3. Logika untuk tombol Edit
  $("#tabel-purchase").on("click", ".btn-edit", function () {
    let id = $(this).data("id");
    $.ajax({
        url: base_url + "/pageCRUD/CRUDPurchase.php",
        method: 'GET',
        data: { action: 'getSingle', id: id },
        dataType: 'json',
        success: function(response) {
            if(response.status === 'success') {
                const data = response.data;
                $('#purchase_id').val(data.id);
                $('#id_product').val(data.id_product);
                $('#qty').val(data.qty);
                $('#price').val(data.price);
                window.scrollTo(0, 0);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Gagal mengambil data untuk diedit.');
        }
    });
  });

  // 4. Logika untuk tombol Delete
  $("#tabel-purchase").on("click", ".btn-delete", function () {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
      $.ajax({
        url: base_url + "/pageCRUD/CRUDPurchase.php",
        method: "POST",
        data: { action: "delete", id: id },
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            alert(response.message);
            loadData();
          } else {
            alert("Gagal: " + response.message);
          }
        },
        error: function() {
            alert('Terjadi kesalahan saat menghapus data.');
        }
      });
    }
  });
  
  // 5. Logika untuk tombol Reset
  $('#btn-reset').on('click', function() {
      resetForm();
  });
});