$(function () {
    const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));

    function loadInventory() {
        $.ajax({
            url: `${base_url}/pageCRUD/CRUDInventory.php`,
            method: 'GET',
            data: { action: 'read' },
            dataType: 'json',
            success: function (response) {
                let tableRows = "";
                if (response.status === 'success' && response.data.length > 0) {
                    response.data.forEach(function (item) {
                        tableRows += `
                            <tr>
                                <td class="text-center">${item.id}</td>
                                <td>${item.sku}</td>
                                <td>${item.product}</td>
                                <td>${item.uom}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}" title="Hapus"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>`;
                    });
                } else {
                    tableRows = '<tr><td colspan="5" class="text-center fst-italic">Belum ada data inventori.</td></tr>';
                }
                $("#inventory-table-body").html(tableRows);
            }
        });
    }

    loadInventory();

    $('#btn-add-item').on('click', function () {
        $('#itemForm')[0].reset();
        $('#modalTitle').text('Tambah Item Baru');
        $('#action').val('create');
        $('#item_id').val('');
        itemModal.show();
    });

    $('#itemForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${base_url}/pageCRUD/CRUDInventory.php`,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                if (response.status === 'success') {
                    itemModal.hide();
                    loadInventory();
                }
            }
        });
    });

    $('#inventory-table-body').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.ajax({
            url: `${base_url}/pageCRUD/CRUDInventory.php`,
            method: 'GET',
            data: { action: 'getSingle', id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const data = response.data;
                    $('#modalTitle').text('Edit Item');
                    $('#action').val('update');
                    $('#item_id').val(data.id);
                    $('#sku').val(data.sku);
                    $('#item_name').val(data.product);
                    $('#uom').val(data.uom);
                    itemModal.show();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('#inventory-table-body').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari inventori?')) {
            $.ajax({
                url: `${base_url}/pageCRUD/CRUDInventory.php`,
                method: 'POST',
                data: { action: 'delete', id: id },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        loadInventory();
                    }
                }
            });
        }
    });
});