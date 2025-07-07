$(function () {
    new Litepicker({
        element: document.getElementById('sales_date'),
        format: 'DD-MM-YYYY',
        lang: 'id',
        singleMode: true,
        autoApply: true,
        allowRepick: true,
        dropdowns: {
            minYear: new Date().getFullYear() - 1,
            maxYear: new Date().getFullYear() + 1,
            months: true,
            years: true
        },
        setup: (picker) => {
            picker.on('selected', (date) => {
                $('#sales_date').val(date.format('DD-MM-YYYY'));
            });

            document.getElementById('sales_date').addEventListener('click', function() {
                picker.show();
            });
        }
    });

    generateRow();
});

$('#btn_save').on('click', e => {
    e.preventDefault();
    console.log('ajax');
    const formData = $('#salesForm').serialize();
    $.ajax({
        url: base_url + '/module/sales.php',
        method: 'POST',
        dataType: 'json',
        data: {
            form: formData,
            action: 'updateData'
        },
        success: function(result){
            alert('Hore berhasil');
            // window.location
        },
        error: function(error){},
    });
});

// Fungsi untuk membuat baris baru
function generateRow() {
    console.log("Generate row");
    const rowCount = $("#detail .row_line").length;

    // Membuat pilihan produk
const productOptions =
    `<option value="">Pilih Product</option>` +
    productData.map(p => `<option value="${p.id}">${p.product}</option>`).join('');

    // Membuat row baru
    const row = $(`
        <div class="row_line" data-index="${rowCount}">
            <select name="product_id[]" class="product_select form-select">${productOptions}</select>
            <input type="text" name="sku[]" class="sku form-control readonly" style="width:1500px">
            <input type="number" name="price[]" class="price form-control" style="width:1500px">
            <input type="text" name="uom[]" class="uom form-control readonly" style="width:1500px">
            <input type="number" name="quantity[]" class="quantity form-control" style="width:1500px">
            <input type="text" name="total[]" class="total form-control readonly" style="width:1500px">
            <button type="button" class="btn btn-danger btn_delete">🗑</button>
        </div>
    `);

    $("#detail").append(row); // Tambahkan row ke dalam tabel
}

// Fungsi untuk mengupdate data produk pada row
function updateRowData(row, productID) {
    const product = productData.find((p) => p.id === productID); // Mencari produk berdasarkan ID
    if (product) {
        row.find(".sku").val(product.sku); // Mengisi SKU
        row.find(".price").val(product.price); // Mengisi Harga
        row.find(".uom").val(product.uom); // Mengisi UOM

        row.find(".quantity").focus(); // Fokus pada quantity
    }
    updateTotal(row); // Mengupdate total per baris
}

// Fungsi untuk memformat angka (untuk angka dengan koma)
function formatNumber(value) {
    return parseFloat(value || 0).toLocaleString("id-ID");
}

// Fungsi untuk menghitung total berdasarkan harga dan quantity
function updateTotal(row) {
    const price = parseFloat(row.find(".price").val()) || 0; // Mengambil harga, jika kosong set 0
    const quantity = parseFloat(row.find(".quantity").val()) || 0; // Mengambil quantity, jika kosong set 0
    const total = price * quantity; // Menghitung total (Harga * Quantity)

    // Menampilkan hasil total pada kolom "total"
    row.find(".total").val(formatNumber(total));

    // Memperbarui ringkasan (subtotal, pajak, grand total)
    updateSummary();
}

// Fungsi untuk memperbarui ringkasan subtotal, diskon, pajak, grand total
function updateSummary() {
    let subtotal = 0;

    $(".total").each(function () {
        // Hapus titik ribuan sebelum parseFloat
        const value = ($(this).val() || "0").replace(/\./g, "").replace(",", ".");
        subtotal += parseFloat(value) || 0;
    });

    const discountpercent = parseFloat($("#discount_percent").val()) || 0;
    const discountvalue = subtotal * (discountpercent / 100);
    const beforetax = subtotal - discountvalue;
    const tax = subtotal * 0.1; // Pajak dari subtotal, BUKAN dari setelah diskon
    const grandtotal = (subtotal + tax) - discountvalue;


    $("#subtotal_value").text(formatNumber(subtotal));
    $("#discount_value").text(formatNumber(discountvalue));
    $("#tax_value").text(formatNumber(tax));
    $("#grand_total").text(formatNumber(grandtotal));
}


// Event listener ketika memilih produk dari dropdown
$(document).on("change", ".product_select", function () {
    const row = $(this).closest(".row_line"); // Ambil row terdekat
    updateRowData(row, $(this).val()); // Perbarui data row dengan produk yang dipilih
});

// Event listener ketika mengubah harga atau quantity
$(document).on("input", ".price, .quantity", function () {
    const row = $(this).closest(".row_line"); // Ambil row terdekat
    updateTotal(row); // Update total per row setiap kali harga atau quantity diubah
});

// Event listener ketika tombol hapus diklik
$(document).on("click", ".btn_delete", function () {
    $(this).closest(".row_line").remove(); // Hapus row
    updateSummary(); // Update ringkasan setelah baris dihapus
});

// Event listener ketika mengubah quantity
$(document).on("blur", ".quantity", function () {
    const row = $(this).closest(".row_line"); // Ambil row terdekat
    updateTotal(row); // Update total per row

    // Jika quantity lebih besar dari 0 dan ini adalah row terakhir, tambahkan row baru
    if (parseFloat($(this).val()) > 0 && row.is(":last-child")) {
        generateRow(); // Tambahkan row baru
    }
});
// Event listener saat diskon persen diubah
$(document).on("input", "#discount_percent", function () {
    updateSummary(); // Panggil fungsi untuk menghitung ulang subtotal, diskon, pajak, dan grand total
});
// Fungsi untuk menampilkan preview
function showPreview() {
    // Update data header
    $('#preview_date').text($('#sales_date').val());
    
    const selectedCustomer = $('#customer option:selected').text();
    $('#preview_customer').text(selectedCustomer);

    // Update data detail
    let rows = '';
    $('#detail .row_line').each(function() {
        const product = $(this).find('.product_select option:selected').text();
        const sku = $(this).find('.sku').val();
        const price = parseFloat($(this).find('.price').val()) || 0;
        const uom = $(this).find('.uom').val();
        const qty = parseFloat($(this).find('.quantity').val()) || 0;
        const total = parseFloat($(this).find('.total').val().replace(/\./g, '')) || 0;

        if (qty > 0 && product !== "Pilih Product") {
            rows += `<tr>
                        <td>${product}</td>
                        <td>${sku}</td>
                        <td class="text-end">${formatNumber(price)}</td>
                        <td>${uom}</td>
                        <td class="text-end">${qty}</td>
                        <td class="text-end">${formatNumber(total)}</td>
                    </tr>`;
        }
    });
    
    $('#preview_detail').html(rows);
    
    // Update summary
    $('#preview_subtotal').text($('#subtotal_value').text());
    $('#preview_discount').text($('#discount_value').text());
    $('#preview_tax').text($('#tax_value').text());
    $('#preview_grandtotal').text($('#grand_total').text());
}

// Event listener untuk tombol preview
$('#btn_preview').on('click', function(e) {
    e.preventDefault();
    showPreview();
});

// Event listener untuk modal preview
$('#printPreview').on('show.bs.modal', function() {
    showPreview();
});