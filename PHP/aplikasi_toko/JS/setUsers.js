$(function () {
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));
    
    function loadUsers() {
        $.getJSON(`${base_url}/pageCRUD/CRUDKaryawan.php`, { action: 'read' }, function (response) {
            let rows = '';
            if (response.status === 'success') {
                response.data.forEach(user => {
                    rows += `<tr>
                        <td>${user.NIP}</td>
                        <td>${user.Nama}</td>
                        <td>${user.Email}</td>
                        <td><span class="badge bg-primary">${user.Role}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-edit" data-nip="${user.NIP}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-nip="${user.NIP}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
            }
            $('#user-table-body').html(rows);
        });
    }
    
    loadUsers();
    
    $('#btn-add-user').click(function () {
        $('#userForm')[0].reset();
        $('#modalTitle').text('Tambah Karyawan Baru');
        $('#nip').val('');
        $('#password').prop('required', true);
        $('#passwordHelp').text('Wajib diisi untuk karyawan baru.');
        userModal.show();
    });
    
    $('#user-table-body').on('click', '.btn-edit', function () {
        const nip = $(this).data('nip');
        $.getJSON(`${base_url}/pageCRUD/CRUDKaryawan.php`, { action: 'getSingle', nip: nip }, function (res) {
            if (res.status === 'success') {
                const user = res.data;
                $('#nip').val(user.NIP);
                $('#nama').val(user.Nama);
                $('#email').val(user.Email);
                $('#role').val(user.Role);
                $('#alamat').val(user.Alamat);
                $('#modalTitle').text('Edit Karyawan');
                $('#password').val('').prop('required', false);
                $('#passwordHelp').text('Kosongkan jika tidak ingin mengubah password.');
                userModal.show();
            }
        });
    });
    
    $('#userForm').submit(function (e) {
        e.preventDefault();
        $.post(`${base_url}/pageCRUD/CRUDKaryawan.php`, $(this).serialize() + '&action=save', function (res) {
            alert(res.message);
            if (res.status === 'success') {
                userModal.hide();
                loadUsers();
            }
        }, 'json');
    });
    
    $('#user-table-body').on('click', '.btn-delete', function () {
        if (confirm('Yakin ingin menghapus karyawan ini?')) {
            const nip = $(this).data('nip');
            $.post(`${base_url}/pageCRUD/CRUDKaryawan.php`, { action: 'delete', nip: nip }, function (res) {
                alert(res.message);
                if (res.status === 'success') {
                    loadUsers();
                }
            }, 'json');
        }
    });
});