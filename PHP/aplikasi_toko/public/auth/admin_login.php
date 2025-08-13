<?php
session_start();
if (isset($_SESSION['karyawan_id']) || isset($_SESSION['user_id'])) {
    $dashboard = isset($_SESSION['karyawan_id']) ? '../admin_dashboard.php' : '../user_dashboard.php';
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
    <title>Login Karyawan - Aplikasi Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(to right, #434343, #000000); height: 100vh; }
        .card { border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row vh-100 d-flex align-items-center justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="card p-4 shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-4">
                           <i class="fas fa-user-shield fa-3x text-success"></i>
                           <h5 class="card-title mt-3">Login Karyawan</h5>
                        </div>
                        <form id="loginForm">
                            <div id="alert-container"></div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Karyawan" required>
                                <label for="email">Email Karyawan</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="d-grid mb-2">
                                <button class="btn btn-success btn-lg fw-bold" type="submit" id="btn-submit">Login</button>
                            </div>
                             <div class="text-center">
                                <a class="small" href="admin_register.php">Daftarkan Karyawan Baru</a>
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
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
                $.ajax({
                    url: '<?= $site_root ?>/admin_auth.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = response.data.redirect;
                        } else {
                            $('#alert-container').html(`<div class="alert alert-danger">${response.message}</div>`);
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Login');
                    }
                });
            });
        });
    </script>
</body>
</html>