<?php
session_start();
include 'koneksi.php';

$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$rowEdit = [];

if ($edit) {
    $query    = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$edit'");
    $rowEdit  = mysqli_fetch_assoc($query);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];
    $category_slug = strtolower(str_replace(' ', '-', $category_name));

    if ($edit) {
        $query = "UPDATE categories SET 
                    category_name='$category_name',
                    category_slug='$category_slug',
                    description='$description' 
                  WHERE id ='$edit'";
        $update = mysqli_query($koneksi, $query);
        if ($update) {
            header("location:kategori.php?ubah=berhasil");
        }
    } else {
        $query = "INSERT INTO categories (category_name, category_slug, description) 
                  VALUES ('$category_name','$category_slug','$description')";
        $insert = mysqli_query($koneksi, $query);
        if ($insert) {
            header("location:kategori.php?tambah=berhasil");
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM categories WHERE id='$delete_id'");
    if ($delete) {
        header("location:kategori.php?hapus=berhasil");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel - <?= ($edit) ? "Edit" : "Tambah" ?> Kategori</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'inc/sidebar.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'inc/nav.php'; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">
                        <?= ($edit) ? "Edit" : "Tambah" ?> Kategori Produk
                    </h1>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Nama Kategori</label>
                                    <input type="text" id="category_name"
                                        placeholder="Masukkan nama kategori"
                                        name="category_name" class="form-control" required
                                        value="<?= ($edit) ? $rowEdit['category_name'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" 
                                        placeholder="Masukkan deskripsi singkat kategori"><?= ($edit) ? $rowEdit['description'] : '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="kategori.php" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
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
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>
</html>