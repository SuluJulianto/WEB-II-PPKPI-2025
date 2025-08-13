$(function () {
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));

    // 1. Fungsi untuk memuat data pengguna ke tabel
    function loadUsers() {
        $.ajax({
            url: `${base_url}/pageCRUD/CRUDUser.php`,
            method: 'GET',
            data: { action: 'read' },
            dataType: 'json',
            success: function (response) {
                let tableRows = "";
                if (response.status === 'success' && response.data.length > 0) {
                    response.data.forEach(function (user) {
                        const roleBadge = user.is_admin == 1 ? '<span class="badge bg-success">Admin</span>' : '<span class="badge bg-secondary">User</span>';
                        tableRows += `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.username}</td>
                                <td>${user.email}</td>
                                <td>${roleBadge}</td>
                                <td><span class="badge bg-light text-dark">${user.status}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="${user.id}" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${user.id}" title="Hapus"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>`;
                    });
                } else {
                    tableRows = '<tr><td colspan="6" class="text-center fst-italic">Data pengguna tidak ditemukan.</td></tr>';
                }
                $("#user-table-body").html(tableRows);
            }
        });
    }

    // Muat pengguna saat halaman pertama kali dibuka
    loadUsers();

    // 2. Event untuk tombol "Tambah Pengguna"
    $('#btn-add-user').on('click', function () {
        $('#userForm')[0].reset();
        $('#modalTitle').text('Tambah Pengguna Baru');
        $('#user_id').val('');
        $('#passwordHelp').text('Wajib diisi untuk pengguna baru.');
        $('#password').prop('required', true);
        $('#alert-modal-container').html('');
        userModal.show();
    });

    // 3. Event untuk tombol "Edit"
    $('#user-table-body').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.get(`${base_url}/pageCRUD/CRUDUser.php`, { action: 'getSingle', id: id }, function (response) {
            if (response.status === 'success') {
                const user = response.data;
                $('#modalTitle').text('Edit Pengguna');
                $('#user_id').val(user.id);
                $('#username').val(user.username);
                $('#email').val(user.email);
                $('#is_admin').val(user.is_admin);
                $('#password').val('');
                $('#passwordHelp').text('Kosongkan jika tidak ingin mengubah password.');
                $('#password').prop('required', false);
                $('#alert-modal-container').html('');
                userModal.show();
            } else {
                alert(response.message);
            }
        }, 'json');
    });

    // 4. Event untuk submit form di modal
    $('#userForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post(`${base_url}/pageCRUD/CRUDUser.php`, formData, function (response) {
            if (response.status === 'success') {
                userModal.hide();
                alert(response.message);
                loadUsers();
            } else {
                 const alertMsg = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>`;
                $('#alert-modal-container').html(alertMsg);
            }
        }, 'json');
    });

    // 5. Event untuk tombol "Hapus"
    $('#user-table-body').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            $.post(`${base_url}/pageCRUD/CRUDUser.php`, { action: 'delete', id: id }, function (response) {
                alert(response.message);
                if (response.status === 'success') {
                    loadUsers();
                }
            }, 'json');
        }
    });
});