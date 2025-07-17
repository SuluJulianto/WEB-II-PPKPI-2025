<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php
      if (isset($_GET['alert'])) {
          if ($_GET['alert'] == 1) { echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle"></i> Registrasi Berhasil!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; } 
          elseif ($_GET['alert'] == 2) { echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle"></i> Data berhasil diubah!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; } 
          elseif ($_GET['alert'] == 3) { echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle"></i> Data berhasil dihapus!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; }
      }
      ?>

      <div class="card form-card">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-table mr-2"></i>Data Calon Siswa</h5>
              <a href="index.php?page=tambah" class="btn btn-light btn-sm"><i class="fas fa-plus"></i> Tambah Baru</a>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>No.</th><th>No. Registrasi</th><th>Nama</th><th>Jurusan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $batas = 5; $halaman = isset($_GET['hal']) ? (int)$_GET['hal'] : 1; $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                    $query_jumlah = mysqli_query($db, "SELECT count(NoReg) as jumlah FROM registrasi"); $jumlah_data = mysqli_fetch_assoc($query_jumlah)['jumlah']; $total_halaman = ceil($jumlah_data / $batas);
                    $query = mysqli_query($db, "SELECT * FROM registrasi ORDER BY NoReg DESC LIMIT $halaman_awal, $batas"); $no = $halaman_awal + 1;
                    
                    if (mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td class="text-center align-middle"><?php echo $no++; ?></td>
                                <td class="text-center align-middle"><?php echo $data['NoReg']; ?></td>
                                <td class="align-middle"><?php echo $data['Nama']; ?></td>
                                <td class="align-middle"><?php echo $data['Jurusan']; ?></td>
                                <td class="text-center align-middle">
                                    <a title="Cetak" class="btn btn-success btn-sm btn-action" href="cetak.php?NoReg=<?php echo $data['NoReg']; ?>" target="_blank"><i class="fas fa-print"></i></a>
                                    <a title="Ubah" class="btn btn-warning btn-sm btn-action" href="index.php?page=ubah&NoReg=<?php echo $data['NoReg']; ?>"><i class="fas fa-edit"></i></a>
                                    <a title="Hapus" class="btn btn-danger btn-sm btn-action" href="proses_hapus.php?NoReg=<?php echo $data['NoReg']; ?>" onclick="return confirm('Anda yakin ingin menghapus data <?php echo $data['Nama']; ?>?');"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php }
                    } else { echo '<tr><td colspan="5" class="text-center">Belum ada pendaftar.</td></tr>'; }
                    ?>
                    </tbody>
                </table>
              </div>
              <nav><ul class="pagination justify-content-center">
                <li class="page-item <?php if($halaman <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($halaman > 1){ echo "index.php?page=tampil&hal=".($halaman-1); } ?>">«</a></li>
                <?php for($x=1; $x <= $total_halaman; $x++){ ?><li class="page-item <?php if($halaman == $x) {echo 'active';} ?>"><a class="page-link" href="index.php?page=tampil&hal=<?php echo $x ?>"><?php echo $x ?></a></li><?php } ?>
                <li class="page-item <?php if($halaman >= $total_halaman) {echo 'disabled';} ?>"><a class="page-link" href="<?php if($halaman < $total_halaman) {echo "index.php?page=tampil&hal=".($halaman+1); } ?>">»</a></li>
              </ul></nav>
          </div>
      </div>
    </div>
  </div>
</div>