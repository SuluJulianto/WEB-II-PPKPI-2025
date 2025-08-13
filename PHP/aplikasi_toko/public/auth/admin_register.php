<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["site_root"])) {
    $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
}
$site_root = $_SESSION["site_root"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Karyawan - Aplikasi Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #eef2f3; }
        .card { border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-6">
                <div class="card p-4 shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-4">
                           <i class="fas fa-user-plus fa-3x text-info"></i>
                           <h5 class="card-title mt-3">Pendaftaran Akun Karyawan</h5>
                           <p class="text-muted">Halaman ini khusus untuk mendaftarkan karyawan baru.</p>
                        </div>
                        <form id="registerForm">
                            <div id="alert-container"></div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nip" class="form-label">NIP (Nomor Induk Pegawai)</label>
                                    <input type="text" class="form-control" id="nip" name="nip" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                             <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                             <div class="mb-3">
                                <label for="role" class="form-label">Pilih Peran (Role)</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" disabled selected>-- Pilih jenis peran --</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Staf Gudang">Staf Gudang</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="special_code" class="form-label">Kode Khusus Pendaftaran</label>
                                <input type="text" class="form-control" id="special_code" name="special_code" required>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-info fw-bold text-white" type="submit" id="btn-submit">Daftarkan Karyawan</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-transparent border-0 pt-3">
                        <a href="admin_login.php" class="text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Login Karyawan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= $site_root ?>/admin_register_auth.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                        $('#alert-container').html(`<div class="alert ${alertClass}">${response.message}</div>`);
                        if (response.status === 'success') {
                            $('#registerForm')[0].reset();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>