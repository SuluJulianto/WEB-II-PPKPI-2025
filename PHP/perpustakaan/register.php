<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun Baru - Perpustakaan</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <style>
        body { background-color: #f8f9fa; }
        .register-container { margin-top: 3%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center register-container">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-success text-white">
                        <h3>Pendaftaran Anggota Baru</h3>
                    </div>
                    <div class="card-body">
                        <?php 
                            if(isset($_GET['pesan']) && $_GET['pesan'] == 'exists') {
                                echo "<div class='alert alert-danger'>Email sudah terdaftar, silakan gunakan email lain.</div>";
                            }
                        ?>
                        <form action="register_act.php" method="post">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_anggota" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                             <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="text" name="no_telp" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-block" value="DAFTAR">
                            </div>
                        </form>
                        <div class="text-center">
                            <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>