<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Informasi Perpustakaan</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { margin-top: 5%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center login-container">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Login Akun</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['pesan'])) {
                            if ($_GET['pesan'] == "gagal") { echo "<div class='alert alert-danger'>Login gagal! Periksa kembali username/password.</div>"; } 
                            else if ($_GET['pesan'] == "logout") { echo "<div class='alert alert-success'>Anda berhasil logout.</div>"; } 
                            else if ($_GET['pesan'] == "belumlogin") { echo "<div class='alert alert-warning'>Anda harus login untuk mengakses halaman ini.</div>"; } 
                            else if ($_GET['pesan'] == "haruslogin") { echo "<div class='alert alert-info'>Anda harus login untuk meminjam buku.</div>"; }
                            else if ($_GET['pesan'] == "registered") { echo "<div class='alert alert-success'>Pendaftaran berhasil! Silakan login.</div>"; }
                        }
                        ?>
                        <form action="login_act.php" method="post">
                            <div class="form-group">
                                <label>Username / Email</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" value="LOGIN">
                            </div>
                        </form>
                        <div class="text-center">
                            <a href="index.php">Kembali ke Halaman Utama</a><br>
                            <small>Belum punya akun? <a href="register.php">Daftar di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>