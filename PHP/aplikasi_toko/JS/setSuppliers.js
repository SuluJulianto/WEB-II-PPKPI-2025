$(function () {
    const supplierModal = new bootstrap.Modal(document.getElementById('supplierModal'));
    
    function loadSuppliers() {
        $.getJSON(`${base_url}/pageCRUD/CRUDSupplier.php`, { action: 'read' }, function (response) {
            let rows = '';
            if (response.status === 'success' && response.data.length > 0) {
                response.data.forEach(s => {
                    rows += `<tr>
                        <td>${s.id}</td>
                        <td>${s.supplier}</td>
                        <td>${s.address}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${s.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${s.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = '<tr><td colspan="4" class="text-center">Belum ada data supplier.</td></tr>';
            }
            $('#supplier-table-body').html(rows);
        });
    }

    loadSuppliers();

    $('#btn-add-supplier').click(function () {
        $('#supplierForm')[0].reset();
        $('#modalTitle').text('Tambah Supplier Baru');
        $('#supplier_id').val('');
        supplierModal.show();
    });

    $('#supplier-table-body').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.getJSON(`${base_url}/pageCRUD/CRUDSupplier.php`, { action: 'getSingle', id: id }, function(res) {
            if(res.status === 'success') {
                const s = res.data;
                $('#supplier_id').val(s.id);
                $('#supplier_name').val(s.supplier);
                $('#address').val(s.address);
                $('#modalTitle').text('Edit Supplier');
                supplierModal.show();
            }
        });
    });

    $('#supplierForm').submit(function (e) {
        e.preventDefault();
        $.post(`${base_url}/pageCRUD/CRUDSupplier.php`, $(this).serialize() + '&action=save', function (res) {
            alert(res.message);
            if(res.status === 'success') {
                supplierModal.hide();
                loadSuppliers();
            }
        }, 'json');
    });

    $('#supplier-table-body').on('click', '.btn-delete', function () {
        if (confirm('Yakin ingin menghapus supplier ini?')) {
            const id = $(this).data('id');
            $.post(`${base_url}/pageCRUD/CRUDSupplier.php`, { action: 'delete', id: id }, function (res) {
                alert(res.message);
                if(res.status === 'success') {
                    loadSuppliers();
                }
            }, 'json');
        }
    });
});