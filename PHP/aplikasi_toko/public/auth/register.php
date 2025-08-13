<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION["site_root"])) {
        $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
    }
    $dashboard = $_SESSION['role'] == 'User' ? $_SESSION["site_root"] . '/public/user_dashboard.php' : $_SESSION["site_root"] . '/public/admin_dashboard.php';
    header("Location: $dashboard");
    exit();
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
    <title>Registrasi - Aplikasi Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(to right, #0052D4, #65C7F7, #9CECFB); height: 100vh; }
        .card { border: none; border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row vh-100 d-flex align-items-center justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="card p-4 shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-4">
                           <i class="fas fa-user-plus fa-3x text-primary"></i>
                           <h5 class="card-title mt-3">Buat Akun Baru</h5>
                        </div>
                        
                        <form id="registerForm">
                            <input type="hidden" name="action" value="register">
                            <div id="alert-container"></div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email">Alamat Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                             <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                                <label for="confirm_password">Konfirmasi Password</label>
                            </div>
                            <div class="d-grid mb-2">
                                <button class="btn btn-primary btn-lg fw-bold" type="submit" id="btn-submit">Daftar</button>
                            </div>
                             <div class="text-center">
                                <a class="small" href="login.php">Sudah punya akun? Login di sini!</a>
                            </div>
                        </form>
                    </div>
                     <div class="card-footer text-center bg-transparent border-0 pt-3">
                        <a href="<?= $site_root ?>/public/index.php" class="text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Utama
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
                const btn = $('#btn-submit');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Memproses...');

                $.ajax({
                    url: '<?= $site_root ?>/auth.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                        $('#alert-container').html(`<div class="alert ${alertClass} alert-dismissible fade show">${response.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`);
                        if (response.status === 'success') {
                            $('#registerForm')[0].reset();
                        }
                    },
                    error: function() {
                         $('#alert-container').html(`<div class="alert alert-danger alert-dismissible fade show">Terjadi kesalahan koneksi ke server.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`);
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Daftar');
                    }
                });
            });
        });
    </script>
</body>
</html>