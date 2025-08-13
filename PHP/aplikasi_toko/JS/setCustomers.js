$(function () {
    const customerModal = new bootstrap.Modal(document.getElementById('customerModal'));
    
    function loadCustomers() {
        $.getJSON(`${base_url}/pageCRUD/CRUDCustomer.php`, { action: 'read' }, function (response) {
            let rows = '';
            if (response.status === 'success' && response.data.length > 0) {
                response.data.forEach(c => {
                    rows += `<tr>
                        <td>${c.id}</td>
                        <td>${c.customer}</td>
                        <td>${c.address}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${c.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${c.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = '<tr><td colspan="4" class="text-center">Belum ada data customer.</td></tr>';
            }
            $('#customer-table-body').html(rows);
        });
    }

    loadCustomers();

    $('#btn-add-customer').click(function () {
        $('#customerForm')[0].reset();
        $('#modalTitle').text('Tambah Customer Baru');
        $('#customer_id').val('');
        customerModal.show();
    });

    $('#customer-table-body').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.getJSON(`${base_url}/pageCRUD/CRUDCustomer.php`, { action: 'getSingle', id: id }, function(res) {
            if(res.status === 'success') {
                const c = res.data;
                $('#customer_id').val(c.id);
                $('#customer_name').val(c.customer);
                $('#address').val(c.address);
                $('#modalTitle').text('Edit Customer');
                customerModal.show();
            }
        });
    });

    $('#customerForm').submit(function (e) {
        e.preventDefault();
        $.post(`${base_url}/pageCRUD/CRUDCustomer.php`, $(this).serialize() + '&action=save', function (res) {
            alert(res.message);
            if(res.status === 'success') {
                customerModal.hide();
                loadCustomers();
            }
        }, 'json');
    });

    $('#customer-table-body').on('click', '.btn-delete', function () {
        if (confirm('Yakin ingin menghapus customer ini?')) {
            const id = $(this).data('id');
            $.post(`${base_url}/pageCRUD/CRUDCustomer.php`, { action: 'delete', id: id }, function (res) {
                alert(res.message);
                if(res.status === 'success') {
                    loadCustomers();
                }
            }, 'json');
        }
    });
});