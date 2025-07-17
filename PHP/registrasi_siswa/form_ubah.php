<?php
if (isset($_GET['NoReg']) && !empty($_GET['NoReg'])) {
    $no_reg = $_GET['NoReg'];
    $query = mysqli_query($db, "SELECT * FROM registrasi WHERE NoReg = '$no_reg'");
    $data = mysqli_fetch_assoc($query);
    if (!$data) {
        echo "<script>alert('Data tidak ditemukan.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='index.php';</script>";
}
?>
<div class="form-page-background">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card form-card">
          <div class="card-header text-center">
            <h4 class="mb-0">Ubah Data Pendaftar</h4>
          </div>
          <div class="card-body">
            <form class="needs-validation" action="proses_ubah.php" method="post" novalidate>
              <input type="hidden" name="NoReg" value="<?php echo $data['NoReg']; ?>">

              <div class="form-group">
                <label for="NoReg_display">Nomor Registrasi</label>
                <input type="text" id="NoReg_display" class="form-control" value="<?php echo $data['NoReg']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="Nama">Nama Lengkap</label>
                <input type="text" id="Nama" class="form-control" name="Nama" value="<?php echo $data['Nama']; ?>" required>
              </div>
              <div class="form-group">
                <label>Jenis Kelamin</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="laki-laki-ubah" name="JK" class="custom-control-input" value="Laki-laki" <?php if ($data['JK'] == 'Laki-laki') echo 'checked'; ?> required>
                    <label class="custom-control-label" for="laki-laki-ubah">Laki-laki</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="perempuan-ubah" name="JK" class="custom-control-input" value="Perempuan" <?php if ($data['JK'] == 'Perempuan') echo 'checked'; ?> required>
                    <label class="custom-control-label" for="perempuan-ubah">Perempuan</label>
                </div>
              </div>
              <div class="form-group">
                <label for="Alamat">Alamat Lengkap</label>
                <textarea id="Alamat" class="form-control" name="Alamat" rows="3" required><?php echo $data['Alamat']; ?></textarea>
              </div>
              <div class="form-group">
                <label for="Agama">Agama</label>
                <select id="Agama" class="form-control" name="Agama" required>
                  <option value="<?php echo $data['Agama']; ?>" selected><?php echo $data['Agama']; ?></option>
                  <option value="Islam">Islam</option><option value="Kristen Protestan">Kristen Protestan</option><option value="Kristen Katolik">Kristen Katolik</option><option value="Hindu">Hindu</option><option value="Buddha">Buddha</option>
                </select>
              </div>
              <div class="form-group">
                <label for="AsalSekolah">Asal Sekolah</label>
                <input type="text" id="AsalSekolah" class="form-control" name="AsalSekolah" value="<?php echo $data['AsalSekolah']; ?>" required>
              </div>
              <div class="form-group">
                <label for="Jurusan">Jurusan Pilihan</label>
                <select id="Jurusan" class="form-control" name="Jurusan" required>
                  <option value="<?php echo $data['Jurusan']; ?>" selected><?php echo $data['Jurusan']; ?></option>
                  <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option><option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option><option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                </select>
              </div>
              <hr class="mt-4">
              <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg" name="simpan">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>