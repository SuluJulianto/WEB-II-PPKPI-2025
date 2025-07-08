$(function () {
    // Inisialisasi Litepicker
    const picker = new Litepicker({
        element: document.getElementById('sales_date'),
        format: 'DD-MM-YYYY',
        lang: 'id-ID',
        singleMode: true,
    });

    // Jika ini adalah mode edit (salesId > 0), muat data yang ada
    if (salesId > 0) {
        loadExistingData(salesId);
    } else {
        // Jika mode tambah, buat satu baris kosong
        generateRow();
    }
});

function loadExistingData(id) {
    $.ajax({
        url: `${base_url}/module/sales.php`,
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'getSalesData',
            sales_id: id
        },
        success: function(response) {
            if (response.response === 1) {
                const { header, details } = response.data;
                
                // Isi data header
                $('#sales_date').val(formatDate(header.sales_date));
                $('#customer').val(header.id_customer);
                $('#discount_percent').val(header.discount_percent || 0);

                // Kosongkan kontainer detail sebelum mengisi
                $('#detail_container').empty();

                // Isi data detail
                details.forEach(item => {
                    const row = generateRow(); // Buat baris baru
                    row.find('.product_select').val(item.id_product);
                    updateRowData(row, item.id_product); // Update SKU, UOM, dll.
                    row.find('.price').val(item.price);
                    row.find('.quantity').val(item.qty);
                });

                // Tambah satu baris kosong di akhir untuk entri baru
                generateRow();
                updateSummary();
            } else {
                alert('Gagal memuat data penjualan: ' + response.data);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat memuat data.');
        }
    });
}

// Fungsi untuk membuat baris baru
function generateRow() {
    const productOptions = `<option value="">Pilih Produk</option>` +
        productData.map(p => `<option value="${p.id}">${p.product}</option>`).join('');

    const row = $(`
        <div class="row_line">
            <select name="product_id[]" class="product_select form-select" style="flex: 3;">${productOptions}</select>
            <input type="text" name="sku[]" class="sku form-control readonly" style="flex: 2;" readonly>
            <input type="number" name="price[]" class="price form-control" style="flex: 1.5;">
            <input type="text" name="uom[]" class="uom form-control readonly" style="flex: 1;" readonly>
            <input type="number" name="quantity[]" class="quantity form-control" style="flex: 1;">
            <input type="text" name="total[]" class="total form-control readonly" style="flex: 1.5;" readonly>
            <button type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
        </div>
    `);

    $("#detail_container").append(row);
    return row; // Kembalikan elemen baris yang baru dibuat
}

// Event listener untuk tombol simpan
$('#salesForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = $(this).serialize();
    const salesDetails = [];

    $('.row_line').each(function() {
        const row = $(this);
        const productId = row.find('.product_select').val();
        const quantity = parseFloat(row.find('.quantity').val()) || 0;

        if (productId && quantity > 0) {
            salesDetails.push({
                product_id: productId,
                price: row.find('.price').val(),
                quantity: quantity
            });
        }
    });

    if (salesDetails.length === 0) {
        alert('Mohon tambahkan setidaknya satu produk dengan kuantitas lebih dari 0.');
        return;
    }

    $.ajax({
        url: `${base_url}/module/sales.php`,
        method: 'POST',
        dataType: 'json',
        data: {
            form: formData,
            details: salesDetails,
            action: 'updateData' // Aksi ini akan menangani create dan update
        },
        success: function(result) {
            if (result.response === 1) {
                alert('Data berhasil disimpan!');
                window.location.href = `${base_url}/public/pageSales.php`;
            } else {
                alert('Gagal menyimpan data: ' + result.data);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
});

// Event listener lainnya (pemilihan produk, input harga/qty, hapus baris, dll.)
$(document).on("change", ".product_select", function () {
    const row = $(this).closest(".row_line");
    updateRowData(row, $(this).val());
});

$(document).on("input", ".price, .quantity, #discount_percent", function () {
    const row = $(this).closest(".row_line");
    updateTotal(row);
});

$(document).on("click", ".btn_delete", function () {
    if ($('.row_line').length > 1) {
        $(this).closest(".row_line").remove();
        updateSummary();
    } else {
        alert('Setidaknya harus ada satu baris.');
    }
});

$(document).on("blur", ".quantity", function () {
    const row = $(this).closest(".row_line");
    if (parseFloat($(this).val()) > 0 && row.is(":last-child")) {
        generateRow();
    }
});

// Fungsi pembantu
function updateRowData(row, productID) {
    const selectedProductId = parseInt(productID, 10);
    const product = productData.find(p => parseInt(p.id, 10) === selectedProductId);
    if (product) {
        row.find(".sku").val(product.sku);
        row.find(".price").val(product.price);
        row.find(".uom").val(product.uom);
        row.find(".quantity").focus();
    } else {
        row.find(".sku, .price, .uom, .total, .quantity").val("");
    }
    updateTotal(row);
}

function updateTotal(row) {
    const price = parseFloat(row.find(".price").val()) || 0;
    const quantity = parseFloat(row.find(".quantity").val()) || 0;
    const total = price * quantity;
    row.find(".total").val(formatNumber(total));
    updateSummary();
}

function updateSummary() {
    let subtotal = 0;
    $('.total').each(function () {
        subtotal += parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
    });

    const discountPercent = parseFloat($("#discount_percent").val()) || 0;
    const discountValue = subtotal * (discountPercent / 100);
    const dpp = subtotal - discountValue;
    const tax = dpp * 0.11; // PPN 11%
    const grandTotal = dpp + tax;

    $("#subtotal_value").text(formatNumber(subtotal));
    $("#discount_value").text(formatNumber(discountValue));
    $("#tax_value").text(formatNumber(tax));
    $("#grand_total").text(formatNumber(grandTotal));
}

function formatNumber(value) {
    return parseFloat(value || 0).toLocaleString("id-ID");
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}