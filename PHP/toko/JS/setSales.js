$(document).ready(function () {
  readsales();

  // Klik baris header sales
  $("#salesheader").on("click", ".header-row", function () {
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
        if (result["response"] === 1) {
          var trow = "";
          var totalsales = 0;

          $.each(result["data"], function (index, item) {
            trow +=
              "<tr data-sales_id='" +
              item["id_sales"] +
              "' data-product_id='" +
              item["id_product"] +
              "'>";
            trow += "<td>" + item["sku"] + "</td>";
            trow += "<td>" + item["product"] + "</td>";
            trow += "<td>" + item["price"] + "</td>";
            trow += "<td>" + item["qty"] + "</td>";
            trow += "<td>" + item["uom"] + "</td>";
            trow += "<td>" + item["price"] * item["qty"] + "</td>";
            trow += "</tr>";
            totalsales += item["price"] * item["qty"];
          });

          trow +=
            "<tr><td colspan='5'><strong>Total Sales:</strong></td><td>" +
            totalsales +
            "</td></tr>";
          $("#salesdetail").html(trow);
        } else {
          $("#salesdetail").html(
            "<tr><td colspan='6'>Data tidak tersedia</td></tr>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Gagal memuat detail sales:", error);
      },
    });
  });

  $("#btn_cancel").on("click", function (e) {
    e.preventDefault();
    window.location = base_URL + "/public/pageSales.php";
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
      if (result["response"] === 1) {
        var trow = "";
        $.each(result["data"], function (index, item) {
          trow += "<tr class='header-row' data-sales_id='" + item["id"] + "'>";
          trow += "<td>" + item["sales_date"] + "</td>";
          trow += "<td>" + item["customer"] + "</td>";
          trow += "<td>" + "</td>";
        //   trow += "<td>" + item["total"] + "</td>"; <--hasil undefined karena belum ada data
          trow += "</tr>";
        });
        $("#salesheader").html(trow);
      } else {
        $("#salesheader").html(
          "<tr><td colspan='3'>Data tidak tersedia</td></tr>"
        );
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Gagal memuat sales:", error);
    });
    
}$(document).ready(function () {
  readsales();

  // Klik baris header sales
  $("#salesheader").on("click", ".header-row", function () {
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
        if (result["response"] === 1) {
          var trow = "";
          var totalsales = 0;

          $.each(result["data"], function (index, item) {
            trow +=
              "<tr data-sales_id='" +
              item["id_sales"] +
              "' data-product_id='" +
              item["id_product"] +
              "'>";
            trow += "<td>" + item["sku"] + "</td>";
            trow += "<td>" + item["product"] + "</td>";
            trow += "<td>" + item["price"] + "</td>";
            trow += "<td>" + item["qty"] + "</td>";
            trow += "<td>" + item["uom"] + "</td>";
            trow += "<td>" + item["price"] * item["qty"] + "</td>";
            trow += "</tr>";
            totalsales += item["price"] * item["qty"];
          });

          trow +=
            "<tr><td colspan='5'><strong>Total Sales:</strong></td><td>" +
            totalsales +
            "</td></tr>";
          $("#salesdetail").html(trow);
        } else {
          $("#salesdetail").html(
            "<tr><td colspan='6'>Data tidak tersedia</td></tr>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Gagal memuat detail sales:", error);
      },
    });
  });

  $("#btn_cancel").on("click", function (e) {
    e.preventDefault();
    window.location = base_URL + "/public/pageSales.php";
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
      if (result["response"] === 1) {
        var trow = "";
        $.each(result["data"], function (index, item) {
          trow += "<tr class='header-row' data-sales_id='" + item["id"] + "'>";
          trow += "<td>" + item["sales_date"] + "</td>";
          trow += "<td>" + item["customer"] + "</td>";
          trow += "<td>" + "</td>";
        //   trow += "<td>" + item["total"] + "</td>"; <--hasil undefined karena belum ada data
          trow += "</tr>";
        });
        $("#salesheader").html(trow);
      } else {
        $("#salesheader").html(
          "<tr><td colspan='3'>Data tidak tersedia</td></tr>"
        );
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Gagal memuat sales:", error);
    });
    
}