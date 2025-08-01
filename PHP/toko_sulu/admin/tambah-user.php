<?php
session_start();
include 'koneksi.php';

// query edit
$edit = isset($_GET['edit']) ? $_GET['edit'] : ''; //1,2,3
$query    = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$edit'");
$rowEdit  = mysqli_fetch_assoc($query);

// jika user memasukkan nilai input / nilai inputnya ada
if (isset($_POST['name'])) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        if ($_POST['password']) {
            $password = $_POST['password'];
        } else {
            $password = $rowEdit['password'];
        }

        if ($edit) {
            $update = mysqli_query($koneksi, "UPDATE users SET 
            name='$name',
            email='$email',
            password='$password' WHERE id ='$edit'");
            header("location:user.php?ubah=berhasil");
        } else {
            // masukkan data ke dalam table users (name, email, password)
            // nilainya adalah nilai user yg input ('$name','$email','$password')
            $insert = mysqli_query($koneksi, "INSERT INTO users (name, email, password) 
            VALUES ('$name','$email','$password')");
            if ($insert) {
                header("location:user.php?tambah=berhasil");
            }
        }
    } catch (\Exception $th) {
        echo $th->getMessage();
        die;
    }
}

// delete area
if (isset($_GET['delete'])) {
    $delete = $_GET['delete']; //1,3
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$delete'");
    header("location:user.php?hapus=berhasil");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'inc/head.php' ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'inc/sidebar.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'inc/nav.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">
                        <?= isset($_GET['edit']) ? "Edit" : "Tambah" ?> Pengguna
                    </h1>

                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text"
                                        placeholder="Masukkan nama anda"
                                        name="name" class="form-control" value="<?= ($edit) ? $rowEdit['name'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email"
                                        placeholder="Masukkan email anda"
                                        name="email" class="form-control" value="<?= ($edit) ? $rowEdit['email'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password"
                                        placeholder="Masukkan password anda"
                                        name="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'inc/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>