<?php require_once "config/database.php"; ?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PPDB Online - Sekolah Coding Nusantara</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <header class="sticky-top">
      <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="index.php" style="font-weight: 600; font-size: 1.4rem;">
            <i class="fas fa-school text-primary"></i>
            Sekolah Coding Nusantara
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
              <li class="nav-item">
                <a class="nav-link mx-2" href="index.php">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-2" href="index.php?page=tampil">Pendaftar</a>
              </li>
              <li class="nav-item ml-lg-3">
                <a class="btn btn-primary shadow-sm" href="index.php?page=tambah" style="border-radius: 50px; padding: 0.6rem 1.5rem;">Daftar Sekarang</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <?php
      $page = isset($_GET['page']) ? $_GET['page'] : 'home';
      // Logika untuk memberikan padding pada halaman selain home
      if ($page == 'home') {
          include "home.php";
      } else {
          echo '<div class="container py-5">';
          switch ($page) {
              case 'tampil': include "tampil_data.php"; break;
              case 'tambah': include "form_tambah.php"; break;
              case 'ubah': include "form_ubah.php"; break;
          }
          echo '</div>';
      }
      ?>
    </main>

    <footer class="pt-5 pb-4">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <h5>Sekolah Coding Nusantara</h5>
            <p class="text-muted">Membentuk generasi siap kerja di bidang teknologi informasi melalui pendidikan yang relevan dan modern.</p>
          </div>
          <div class="col-md-4 mb-4">
            <h5>Jelajahi</h5>
            <ul class="list-unstyled">
              <li><a href="index.php" class="text-muted">Beranda</a></li>
              <li><a href="index.php?page=tampil" class="text-muted">Pendaftar</a></li>
              <li><a href="#" class="text-muted">Jurusan</a></li>
              <li><a href="#" class="text-muted">Tentang Kami</a></li>
            </ul>
          </div>
          <div class="col-md-4 mb-4">
            <h5>Hubungi Kami</h5>
            <p class="text-muted">
              <i class="fas fa-map-marker-alt mr-2"></i>Jl. Web Developer No. 123, Jakarta Timur<br>
              <i class="fas fa-envelope mr-2"></i>info@sekolahcoding.id<br>
              <i class="fas fa-phone mr-2"></i>(021) 123-4567
            </p>
          </div>
        </div>
        <hr style="border-color: #444;">
        <div class="text-center">
          <p class="mb-0 small">&copy; <?php echo date('Y'); ?> Sekolah Coding Nusantara. All Rights Reserved.</p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>