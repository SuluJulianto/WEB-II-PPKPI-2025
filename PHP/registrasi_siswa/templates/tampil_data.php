<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php
      if (isset($_GET['alert'])) {
          $alert_type = "success";
          $alert_icon = "fas fa-check-circle";
          $alert_message = "";

          if ($_GET['alert'] == 1) {
              $alert_message = "<strong>Registrasi Berhasil!</strong> Data Anda telah tersimpan.";
          } elseif ($_GET['alert'] == 2) {
              $alert_message = "<strong>Perubahan Disimpan!</strong> Data pendaftar telah berhasil diperbarui.";
          }
          
          echo "<div class='alert alert-{$alert_type} alert-dismissible fade show' role='alert'>
                  <i class='{$alert_icon}'></i> {$alert_message}
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>";
      }
      ?>

      <div class="card form-card">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-table mr-2"></i>Data Calon Siswa</h5>
              <a href="index.php?page=tambah" class="btn btn-light btn-sm"><i class="fas fa-plus"></i> Tambah Baru</a>
          </div>
          <div class="card-body">

              <div class="form-group">
                  <input type="text" id="pencarianData" class="form-control" placeholder="Ketik untuk mencari data siswa (berdasarkan Nama, No. Reg, atau Jurusan)...">
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>No.</th><th>No. Registrasi</th><th>Nama</th><th>Jurusan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataSiswaTabel">
                    <?php
                    $batas = 5;
                    $halaman = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
                    $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                    
                    $query_jumlah = mysqli_query($db, "SELECT count(NoReg) as jumlah FROM registrasi");
                    $jumlah_data = mysqli_fetch_assoc($query_jumlah)['jumlah'];
                    $total_halaman = ceil($jumlah_data / $batas);
                    
                    $query = mysqli_query($db, "SELECT * FROM registrasi ORDER BY NoReg DESC LIMIT $halaman_awal, $batas");
                    $no = $halaman_awal + 1;
                    
                    if (mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr id="row-<?php echo $data['NoReg']; ?>">
                                <td class="text-center align-middle"><?php echo $no++; ?></td>
                                <td class="text-center align-middle"><?php echo $data['NoReg']; ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($data['Nama']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($data['Jurusan']); ?></td>
                                <td class="text-center align-middle">
                                    <a title="Cetak" class="btn btn-success btn-sm" href="cetak.php?NoReg=<?php echo $data['NoReg']; ?>" target="_blank"><i class="fas fa-print"></i></a>
                                    <a title="Ubah" class="btn btn-warning btn-sm" href="index.php?page=ubah&NoReg=<?php echo $data['NoReg']; ?>"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#konfirmasiHapusModal" data-noreg="<?php echo $data['NoReg']; ?>" data-nama="<?php echo htmlspecialchars($data['Nama']); ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">Belum ada pendaftar.</td></tr>';
                    }
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