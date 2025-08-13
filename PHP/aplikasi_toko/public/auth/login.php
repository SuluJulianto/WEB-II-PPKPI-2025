<?php
session_start();
// Jika sudah login, langsung arahkan ke dashboard yang sesuai
if (isset($_SESSION['auth_id'])) {
    if (!isset($_SESSION["site_root"])) {
        $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
    }
    // Menggunakan session terpadu yang baru
    $dashboard = $_SESSION['auth_type'] == 'user' ? $_SESSION["site_root"] . '/public/user_dashboard.php' : $_SESSION["site_root"] . '/public/admin_dashboard.php';
    header("Location: $dashboard");
    exit();
}
// Set site_root jika belum ada
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
    <title>Login - Aplikasi Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row vh-100 d-flex align-items-center justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                           <i class="fas fa-store-alt fa-3x text-primary"></i>
                           <h5 class="card-title mt-3">Aplikasi Toko</h5>
                           <p class="text-muted">Silakan login untuk melanjutkan</p>
                        </div>
                        
                        <form id="loginForm">
                            <input type="hidden" name="action" value="login">
                            <div id="alert-container"></div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="d-grid mb-2">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" id="btn-submit">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Login
                                </button>
                            </div>
                            <div class="text-center">
                                <a class="small" href="register.php">Belum punya akun? Daftar di sini!</a>
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
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const btn = $('#btn-submit');
                const spinner = btn.find('.spinner-border');
                const alertContainer = $('#alert-container');

                btn.attr('disabled', true);
                spinner.removeClass('d-none');
                alertContainer.html('');

                $.ajax({
                    url: '<?= $site_root ?>/auth.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // =============================================================
                            // INI BAGIAN YANG DIPERBAIKI
                            // Kita langsung gunakan URL lengkap dari backend, tidak perlu menambah-nambah lagi.
                            // =============================================================
                            window.location.href = response.data.redirect;
                            // =============================================================
                        } else {
                             let alertMsg = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ${response.message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;
                            alertContainer.html(alertMsg);
                        }
                    },
                    error: function() {
                        let alertMsg = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            Terjadi kesalahan koneksi.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;
                        alertContainer.html(alertMsg);
                    },
                    complete: function() {
                        btn.attr('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
</body>
</html>