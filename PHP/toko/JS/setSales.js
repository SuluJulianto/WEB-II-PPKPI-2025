$(document).ready(function () {
  readsales();

  // Klik baris header sales untuk melihat detail
  $("#salesheader").on("click", ".header-row", function () {
    $(".header-row").removeClass("table-active");
    $(this).addClass("table-active");

    var rowId = $(this).data("sales_id");

    $.ajax({
      url: base_url + "/module/sales.php",
      type: "POST",
      dataType: "JSON",
      data: {
        sales_id: rowId,
        action: "queryData",
      },
      success: function (result) {
        let trow = "";
        let totalsales = 0;

        if (result.response === 1) {
          $.each(result.data, function (index, item) {
            const totalPerRow = parseFloat(item.price) * parseFloat(item.qty);
            totalsales += totalPerRow;

            trow += `
              <tr>
                <td>${item.sku}</td>
                <td>${item.product}</td>
                <td class="text-end">${parseFloat(item.price).toLocaleString('id-ID')}</td>
                <td class="text-end">${parseFloat(item.qty).toLocaleString('id-ID')}</td>
                <td>${item.uom}</td>
                <td class="text-end">${totalPerRow.toLocaleString('id-ID')}</td>
              </tr>`;
          });

          trow += `
            <tr>
              <th colspan='5' class="text-end">Total Sales:</th>
              <th class="text-end">${totalsales.toLocaleString('id-ID')}</th>
            </tr>`;

          $("#salesdetail").html(trow);
        } else {
          $("#salesdetail").html(
            "<tr><td colspan='6' class='text-center'>Data detail tidak tersedia</td></tr>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Gagal memuat detail sales:", error);
      },
    });
  });

  // Event listener untuk tombol edit
  $("#salesheader").on("click", ".btn_edit", function (e) {
    e.stopPropagation(); // Mencegah event klik pada baris
    const salesId = $(this).data("id");
    window.location.href = `${base_url}/pageCRUD/crudSales.php?id=${salesId}`;
  });

});

function readsales() {
  $.ajax({
    url: base_url + "/module/sales.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "readData",
    },
  })
    .done(function (result) {
      let trow = "";
      if (result.response === 1 && result.data.length > 0) {
        $.each(result.data, function (index, item) {
          const date = new Date(item.sales_date);
          const formattedDate = `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()}`;

          trow += `<tr class='header-row' data-sales_id='${item.id}'>
                      <td>${formattedDate}</td>
                      <td>${item.customer}</td>
                      <td class="text-end">${parseFloat(item.total).toLocaleString('id-ID')}</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-warning btn_edit" data-id="${item.id}">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                      </td>
                   </tr>`;
        });
      } else {
        trow = "<tr><td colspan='4' class='text-center'>Data penjualan tidak tersedia</td></tr>";
      }
      $("#salesheader").html(trow);
    })
    .fail(function (xhr, status, error) {
      console.error("Gagal memuat sales:", error);
    });
}