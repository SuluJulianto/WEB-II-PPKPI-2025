<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="form-card">
        <h3 class="text-center mb-4">Formulir Pendaftaran</h3>
        <hr>
        <form class="needs-validation" action="proses_simpan.php" method="post" novalidate>
            <div class="form-group"><label>Nomor Registrasi</label><input type="text" class="form-control" name="NoReg" required></div>
            <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" name="Nama" required></div>
            <div class="form-group"><label>Jenis Kelamin</label><br><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="l" name="JK" class="custom-control-input" value="Laki-laki" required><label class="custom-control-label" for="l">Laki-laki</label></div><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="p" name="JK" class="custom-control-input" value="Perempuan" required><label class="custom-control-label" for="p">Perempuan</label></div></div>
            <div class="form-group"><label>Alamat Lengkap</label><textarea class="form-control" name="Alamat" rows="3" required></textarea></div>
            <div class="form-group"><label>Agama</label><select class="form-control" name="Agama" required><option value="">-- Pilih --</option><option>Islam</option><option>Kristen Protestan</option><option>Kristen Katolik</option><option>Hindu</option><option>Buddha</option></select></div>
            <div class="form-group"><label>Asal Sekolah</label><input type="text" class="form-control" name="AsalSekolah" required></div>
            <div class="form-group"><label>Jurusan Pilihan</label><select class="form-control" name="Jurusan" required><option value="">-- Pilih --</option><option>Rekayasa Perangkat Lunak</option><option>Teknik Komputer dan Jaringan</option><option>Desain Komunikasi Visual</option></select></div>
            <div class="text-right mt-4"><button type="submit" class="btn btn-primary btn-lg px-5" name="simpan">Kirim</button></div>
        </form>
    </div>
  </div>
</div>