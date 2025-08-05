<?php
$queryProduk = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC LIMIT 8");

?>
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7">

            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">

            <!-- Start Column 1 -->
            <?php while ($rowProduk = mysqli_fetch_assoc($queryProduk)) : ?>
                <div class="col-12 col-md-4 col-lg-3 mb-5">
                    <a class="product-item" href="#">
                        <img src="admin/upload/<?= $rowProduk['foto'] ?>" class="img-fluid product-thumbnail">
                        <h3 class="product-title"><?= $rowProduk['nama_barang'] ?></h3>
                        <strong class="product-price"><?= "Rp." . number_format($rowProduk['harga']) ?></strong>

                        <span class="icon-cross">
                            <img src="asset/fe/images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
            <?php endwhile ?>
            <!-- End Column 1 -->

        </div>
    </div>
</div>