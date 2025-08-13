$(function () {
    const picker = new Litepicker({
        element: document.getElementById('sales_date'),
        format: 'DD-MM-YYYY',
        lang: 'id-ID',
        singleMode: true,
    });

    // === FUNGSI PERHITUNGAN DAN FORMAT ===
    
    function formatNumber(angka) {
        return (parseFloat(angka) || 0).toLocaleString('id-ID');
    }

    function updateRowTotal(row) {
        const price = parseFloat(row.find(".price").val()) || 0;
        const quantity = parseFloat(row.find(".quantity").val()) || 0;
        const total = price * quantity;
        row.find(".total").val(formatNumber(total));
        updateSummary();
    }

    function updateSummary() {
        let subtotal = 0;
        $('#detail_container .total').each(function () {
            subtotal += parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
        });

        const discountPercent = parseFloat($("#discount_percent").val()) || 0;
        const discountValue = subtotal * (discountPercent / 100);
        const dpp = subtotal - discountValue;
        const tax = dpp * 0.11;
        const grandTotal = dpp + tax;

        $("#subtotal_value").text(formatNumber(subtotal));
        $("#discount_value").text(formatNumber(discountValue));
        $("#dpp_value").text(formatNumber(dpp));
        $("#tax_value").text(formatNumber(tax));
        $("#grand_total").text(formatNumber(grandTotal));
    }

    function generateRow() {
        const productOptions = `<option value="">Pilih Produk</option>` +
            productData.map(p => `<option value="${p.id}">${p.product}</option>`).join('');

        // Struktur baris ini disesuaikan dengan screenshot Anda
        const row = $(`
            <div class="row_line">
                <label class="form-label" style="width: 80px;">Produk</label>
                <select class="product_select form-select form-select-sm" style="width: 25%;">${productOptions}</select>
                <label class="form-label ms-2">SKU</label>
                <input type="text" class="sku form-control form-control-sm readonly" style="width: 15%;" readonly>
                <label class="form-label ms-2">Harga</label>
                <input type="number" class="price form-control form-control-sm text-end" style="width: 15%;">
                <label class="form-label ms-2">UOM</label>
                <input type="text" class="uom form-control form-control-sm readonly" style="width: 8%;" readonly>
                <label class="form-label ms-2">Qty</label>
                <input type="number" class="quantity form-control form-control-sm text-end" style="width: 8%;">
                <label class="form-label ms-2">Total</label>
                <input type="text" class="total form-control form-control-sm readonly text-end" style="width: 15%;" value="0" readonly>
                <button type="button" class="btn btn-danger btn-sm btn_delete"><i class="fas fa-trash"></i></button>
            </div>
        `);
        $("#detail_container").append(row);
        return row;
    }

    // === EVENT LISTENERS ===

    $(document).on("change", ".product_select", function () {
        const row = $(this).closest(".row_line");
        const selectedProductId = $(this).val();
        const product = productData.find(p => p.id == selectedProductId);
        
        if (product) {
            row.find(".sku").val(product.sku);
            row.find(".uom").val(product.uom);
            row.find(".price").val('').focus(); // Kosongkan harga dan langsung fokus ke kolom harga
        } else {
            row.find(".sku, .price, .uom, .total, .quantity").val("");
        }
        updateRowTotal(row); // Hitung ulang total (akan menjadi 0)
    });

    // Perhitungan otomatis saat harga, qty, atau diskon diubah
    $(document).on("input", ".price, .quantity, #discount_percent", function () {
        // Cukup panggil updateSummary() jika diskon berubah
        if ($(this).is("#discount_percent")) {
            updateSummary();
        } else {
            // Jika harga atau qty berubah, panggil updateRowTotal yang juga akan memanggil updateSummary
            const row = $(this).closest(".row_line");
            updateRowTotal(row);
        }
    });
    
    $('#btn-add-row').on('click', generateRow);

    $(document).on("click", ".btn_delete", function () {
        if ($('.row_line').length > 1) {
            $(this).closest(".row_line").remove();
            updateSummary();
        }
    });
    
    // Inisialisasi: Buat satu baris kosong saat halaman dimuat
    generateRow();
});