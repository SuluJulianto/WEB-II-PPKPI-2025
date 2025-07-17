$(function () {
  loadData();

  function loadData() {
    $.get(base_url + "/pageCRUD/CRUDPurchase.php?action=read", function (data) {
      $("#tabel-purchase tbody").html(data);
    });
  }

  $("#form-purchase").on("submit", function (e) {
    e.preventDefault();
    let data = {
      action: "create",
      id_product: $("#produk").val(),
      qty: $("#jumlah").val(),
    };
    $.post(base_url + "/pageCRUD/CRUDPurchase.php", data, function () {
      loadData();
    });
  });
});