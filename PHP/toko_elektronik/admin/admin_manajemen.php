<?php
// /admin/admin_manajemen.php

session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:../login.php?pesan=belum_login");
    exit;
}
// Hanya superadmin yang bisa mengakses
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'superadmin'){
    header("location:dashboard.php?pesan=dilarang");
    exit;
}
require_once '../core/koneksi.php';
$result = mysqli_query($koneksi, "SELECT id, username, role FROM admin");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manajemen Admin</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include '../templates/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Manajemen Pengguna Admin</h1>
                    <p class="mb-4">Halaman ini hanya dapat diakses oleh Superadmin.</p>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar Admin</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead><tr><th>ID</th><th>Username</th><th>Role</th></tr></thead>
                                    <tbody>
                                        <?php while($data = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $data['id']; ?></td>
                                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                                            <td><?php echo htmlspecialchars($data['role']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white"><div class="container my-auto"><div class="copyright text-center my-auto"><span>Copyright &copy; Toko Elektronik 2025</span></div></div></footer>
        </div>
    </div>
</body>
</html>