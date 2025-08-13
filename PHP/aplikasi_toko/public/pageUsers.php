<?php
require_once dirname(__DIR__) . '/auth_check.php';
require_role(['Manager']);

$site_root = $_SESSION['site_root'];
$user_role = $_SESSION['auth_role']; // Dibutuhkan oleh sidebar
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Semua Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Menambahkan CSS untuk layout sidebar + konten */
        body { background-color: #f0f2f5; }
        .main-content { display: flex; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #34495e; }
        .sidebar ul a { padding: 15px 20px; display: block; color: #bdc3c7; text-decoration: none; transition: all 0.2s; }
        .sidebar ul a:hover, .sidebar ul a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        .content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
    </style>
</head>
<body>
    <div class="main-content">
        
        <?php include '_sidebar.php'; // Memanggil sidebar terpusat ?>

        <div class="content">
            <h2 class="mb-4">Manajemen Semua Pengguna</h2>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama / Username</th>
                                    <th>Email</th>
                                    <th>Tipe Akun</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="all-users-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript untuk memuat data pengguna
        $(function() {
            function loadAllUsers() {
                $.getJSON('<?= $site_root ?>/pageCRUD/CRUDAllUsers.php', { action: 'read' }, function(response) {
                    let rows = '';
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(user => {
                            const roleBadge = user.tipe === 'Karyawan' ? `<span class="badge bg-success">${user.role}</span>` : `<span class="badge bg-secondary">${user.role}</span>`;
                            const tipeBadge = user.tipe === 'Karyawan' ? `<span class="badge bg-info">${user.tipe}</span>` : `<span class="badge bg-light text-dark">${user.tipe}</span>`;
                            rows += `<tr>
                                <td>${user.id}</td>
                                <td>${user.nama}</td>
                                <td>${user.email}</td>
                                <td>${tipeBadge}</td>
                                <td>${roleBadge}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" title="Edit (Segera Hadir)" disabled><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" title="Hapus (Segera Hadir)" disabled><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="6" class="text-center">Belum ada data pengguna.</td></tr>';
                    }
                    $('#all-users-table-body').html(rows);
                });
            }
            loadAllUsers();
        });
    </script>
</body>
</html>