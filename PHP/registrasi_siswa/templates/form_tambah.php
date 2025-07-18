<?php
// --- Logika Membuat Nomor Registrasi Otomatis ---
// Format: REG-TAHUNBULANTANGGAL-URUTAN (misal: REG-20231027-0001)

// 1. Query untuk mengambil 4 digit terakhir dari NoReg terbaru.
$query_kode = mysqli_query($db, "SELECT RIGHT(NoReg, 4) as kode FROM registrasi 
                                 WHERE NoReg LIKE 'REG-" . date("Ymd") . "-%' 
                                 ORDER BY NoReg DESC LIMIT 1");
$data_kode = mysqli_fetch_assoc($query_kode);

// 2. Jika ada data hari ini, ambil kodenya. Jika tidak, mulai dari 0.
$kode_terakhir = $data_kode ? (int)$data_kode['kode'] : 0;

// 3. Tambah 1 untuk nomor urut berikutnya.
$kode_baru = $kode_terakhir + 1;

// 4. Gabungkan menjadi NoReg baru, dengan format 4 digit (misal: 0001).
$no_reg_otomatis = "REG-" . date("Ymd") . "-" . str_pad($kode_baru, 4, "0", STR_PAD_LEFT);
?>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="form-card">
        <h3 class="text-center mb-4">Formulir Pendaftaran Siswa Baru</h3>
        <hr>
        <form class="needs-validation" action="proses_simpan.php" method="post" novalidate>
            <div class="form-group"><label>Nomor Registrasi</label><input type="text" class="form-control" name="NoReg" value="<?php echo $no_reg_otomatis; ?>" readonly></div>
            
            <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" name="Nama" placeholder="Masukkan nama lengkap Anda" required></div>
            
            <div class="form-group"><label>Jenis Kelamin</label><br><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="l" name="JK" class="custom-control-input" value="Laki-laki" required><label class="custom-control-label" for="l">Laki-laki</label></div><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="p" name="JK" class="custom-control-input" value="Perempuan" required><label class="custom-control-label" for="p">Perempuan</label></div></div>
            
            <div class="form-group"><label>Alamat Lengkap</label><textarea class="form-control" name="Alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea></div>
            
            <div class="form-group"><label>Agama</label><select class="form-control" name="Agama" required><option value="">-- Pilih Agama --</option><option>Islam</option><option>Kristen Protestan</option><option>Kristen Katolik</option><option>Hindu</option><option>Buddha</option></select></div>
            
            <div class="form-group"><label>Asal Sekolah</label><input type="text" class="form-control" name="AsalSekolah" placeholder="Contoh: SMPN 1 Jakarta" required></div>
            
            <div class="form-group"><label>Jurusan Pilihan</label><select class="form-control" name="Jurusan" required><option value="">-- Pilih Jurusan --</option><option>Rekayasa Perangkat Lunak</option><option>Teknik Komputer dan Jaringan</option><option>Desain Komunikasi Visual</option></select></div>
            
            <div class="text-right mt-4"><button type="submit" class="btn btn-primary btn-lg px-5" name="simpan">Daftar</button></div>
        </form>
    </div>
  </div>
</div>