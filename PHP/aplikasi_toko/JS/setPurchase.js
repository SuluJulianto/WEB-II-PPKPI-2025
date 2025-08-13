$(function () {

    // Fungsi untuk memformat angka menjadi format Rupiah
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Fungsi untuk menghitung total per baris
    function updateRowTotal(row) {
        const qty = parseFloat(row.find(".quantity").val()) || 0;
        const price = parseFloat(row.find(".price").val()) || 0;
        const total = qty * price;
        row.find(".total").val(total.toLocaleString("id-ID"));
        updateGrandTotal();
    }

    // Fungsi untuk menghitung Grand Total keseluruhan
    function updateGrandTotal() {
        let grandTotal = 0;
        $('#detail_container .total').each(function () {
            grandTotal += parseFloat($(this).val().replace(/\./g, '')) || 0;
        });
        $('#grand_total_value').text(formatRupiah(grandTotal));
    }

    // Fungsi untuk membuat baris produk baru
    function generateRow() {
        const productOptions =
            `<option value="" disabled selected>-- Pilih Produk --</option>` +
            productData
                .map((p) => `<option value="${p.id}">${p.product}</option>`)
                .join("");

        const row = $(`
            <div class="row_line mb-2">
                <select name="product_id[]" class="product_select form-select" style="flex: 3;" required>${productOptions}</select>
                <input type="text" name="sku[]" class="sku form-control readonly" style="flex: 2;" readonly>
                <input type="text" name="uom[]" class="uom form-control readonly" style="flex: 1;" readonly>
                <input type="number" name="quantity[]" class="quantity form-control" style="flex: 1;" min="0.01" step="0.01" placeholder="Qty" required>
                <input type="number" name="price[]" class="price form-control" style="flex: 1.5;" min="0" step="1" placeholder="Harga" required>
                <input type="text" name="total[]" class="total form-control readonly text-end" style="flex: 1.5;" readonly>
                <button type="button" class="btn btn-danger btn-sm btn_delete"><i class="fas fa-trash"></i></button>
            </div>
        `);
        $("#detail_container").append(row);
        return row;
    }

    // Tambahkan satu baris saat halaman dimuat
    generateRow();

    // Event listener untuk tombol "Tambah Barang"
    $("#btn-add-row").on("click", function () {
        generateRow();
    });

    // Event listener untuk tombol hapus pada setiap baris
    $("#detail_container").on("click", ".btn_delete", function () {
        if ($(".row_line").length > 1) {
            $(this).closest(".row_line").remove();
            updateGrandTotal();
        } else {
            alert("Setidaknya harus ada satu baris barang.");
        }
    });

    // Event listener saat produk di dropdown dipilih
    $("#detail_container").on("change", ".product_select", function () {
        const row = $(this).closest(".row_line");
        const selectedProductId = $(this).val();
        const product = productData.find(p => p.id == selectedProductId);
        if (product) {
            row.find(".sku").val(product.sku);
            row.find(".uom").val(product.uom);
            row.find(".price").focus(); // Langsung fokus ke input harga
        }
    });

    // === INI BAGIAN PENTING UNTUK PERHITUNGAN OTOMATIS ===
    $("#detail_container").on("input", ".quantity, .price", function () {
        const row = $(this).closest(".row_line");
        updateRowTotal(row);
    });
    // === SELESAI ===

    // Event listener untuk submit form
    $("#form-purchase").on("submit", function (e) {
        e.preventDefault();
        let details = [];
        let isValid = true;
        
        $('.row_line').each(function() {
            const row = $(this);
            const product_id = row.find('.product_select').val();
            const qty = row.find('.quantity').val();
            const price = row.find('.price').val();
            
            if (product_id && qty > 0 && price > 0) {
                details.push({ product_id: product_id, qty: qty, price: price });
            } else {
                if (row.find('.product_select').val() || row.find('.quantity').val() || row.find('.price').val()) {
                    isValid = false;
                }
            }
        });
        
        if (!isValid || details.length === 0) {
            alert("Mohon lengkapi semua data barang (produk, qty, dan harga) atau hapus baris yang tidak digunakan.");
            return;
        }

        const formData = {
            action: 'create',
            purchase_date: $('#purchase_date').val(),
            id_supplier: $('#id_supplier').val(),
            details: details
        };
        
        $.ajax({
            url: base_url + "/pageCRUD/CRUDPurchase.php",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                alert(response.message);
                if (response.status === "success") {
                    $("#form-purchase")[0].reset();
                    $("#detail_container").empty();
                    generateRow();
                    updateGrandTotal();
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat mengirim data ke server.");
            }
        });
    });

    // Logika untuk tombol Reset
    $('#btn-reset').on('click', function() {
        $("#form-purchase")[0].reset();
        $("#detail_container").empty();
        generateRow();
        updateGrandTotal();
    });
});