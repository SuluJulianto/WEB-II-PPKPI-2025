<?php
session_start();
include 'koneksi.php';

// query edit
$edit = isset($_GET['edit']) ? $_GET['edit'] : ''; //1,2,3
$query    = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$edit'");
$rowEdit  = mysqli_fetch_assoc($query);

// jika user memasukkan nilai input / nilai inputnya ada
if (isset($_POST['product_name'])) {
    try {
        $id_category  = $_POST['id_category'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_size = $_POST['product_size'];
        $product_qty = $_POST['product_qty'];
        $product_desc = $_POST['product_desc'];
        $product_slug = str_replace(" ", "-", $_POST['product_name']);

        $product_photo = null;

        // cek jika gambar / file nya ada
        // $_FILES['product_photo']['name','size','error','tmp_name']
        if (isset($_FILES['product_photo']) && $_FILES['product_photo']['error'] == 0) {
            $name_photo = $_FILES['product_photo']['name'];
            $tmp_photo  = $_FILES['product_photo']['tmp_name'];
            $type_photo = mime_content_type($tmp_photo);
            $size_photo  = $_FILES['product_photo']['size'];

            $ext_allowed = ['image/png', 'image/jpg', 'image/jpeg'];
            // jika tipe gambarnya yang di upload tersedia / boleh
            if (in_array($type_photo, $ext_allowed)) {
                $path_upload = "uploads/";
                // kalo folder upload blm ada
                if (!is_dir($path_upload)) {
                    mkdir($path_upload, 0777, true);
                }

                $fileUnique = time() . "-" . basename($name_photo);
                $filePath   = $path_upload . $fileUnique;

                if (move_uploaded_file($tmp_photo, $filePath)) {
                    $product_photo = $fileUnique;
                } else {
                    echo "Gagal upload";
                    exit;
                }
            } else {
                echo "File harus berupa (Jpg/PNG/JPEG)";
                die;
            }
        }


        if ($edit) {

            if ($product_photo && $rowEdit['product_photo'] && file_exists("uploads/" . $rowEdit['product_photo'])) {
                unlink("uploads/" . $rowEdit['product_photo']);
            }

            $update = mysqli_query($koneksi, "UPDATE products SET 
            id_category='$id_category',
            product_name='$product_name',
            product_price='$product_price',
            product_size='$product_size',
            product_qty='$product_qty',
            product_desc='$product_desc',
            product_slug='$product_slug',
            product_photo='$product_photo' WHERE id ='$edit'");
            header("location:produk.php?ubah=berhasil");
        } else {
            // masukkan data ke dalam table users (name, email, password)
            // nilainya adalah nilai user yg input ('$name','$email','$password')
            $insert = mysqli_query($koneksi, "INSERT INTO products 
            (id_category, product_name, product_price, product_size, product_desc, 
            product_photo, product_qty, product_slug) 
            VALUES ('$id_category','$product_name','$product_price','$product_size',
            '$product_desc','$product_photo','$product_qty','$product_slug')");
            if ($insert) {
                header("location:produk.php?tambah=berhasil");
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
    $query    = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$delete'");
    $rowDelete  = mysqli_fetch_assoc($query);

    unlink("uploads/" . $rowDelete['product_photo']);

    $delete = mysqli_query($koneksi, "DELETE FROM products WHERE id='$delete'");
    header("location:produk.php?hapus=berhasil");
}

// get data kategori produk
$queryCategories = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
$rowCategories   = mysqli_fetch_all($queryCategories, MYSQLI_ASSOC);

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
                        <?= isset($_GET['edit']) ? "Edit" : "Tambah" ?> Produk
                    </h1>

                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kategori Produk *</label>
                                    <select name="id_category" id="" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($rowCategories as $rowCategory): ?>
                                            <option <?php echo ($edit && $rowCategory['id'] == $rowEdit['id_category']) ? 'selected' : ''  ?>
                                                value="<?php echo $rowCategory['id'] ?>">
                                                <?php echo $rowCategory['category_name'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Produk</label>
                                    <input type="text"
                                        placeholder="Masukkan nama produk"
                                        name="product_name" class="form-control" value="<?= ($edit) ? $rowEdit['product_name'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga</label>
                                    <input type="number"
                                        placeholder=""
                                        name="product_price" class="form-control" value="<?= ($edit) ? $rowEdit['product_price'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Qty</label>
                                    <input type="number"
                                        placeholder=""
                                        name="product_qty" class="form-control" value="<?= ($edit) ? $rowEdit['product_qty'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Ukuran</label>
                                    <input type="text"
                                        placeholder=""
                                        name="product_size" class="form-control" value="<?= ($edit) ? $rowEdit['product_size'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <input type="text"
                                        placeholder=""
                                        name="product_desc" class="form-control" value="<?= ($edit) ? $rowEdit['product_desc'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="file"
                                        name="product_photo">
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary" name="save" type="submit">Simpan</button>
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