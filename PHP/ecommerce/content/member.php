<?php
// print_r($_SESSION);
// die;
if (isset($_POST['simpan'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];

    $insertMember = mysqli_query($koneksi, "INSERT INTO member (nama_lengkap, email, password, alamat) 
    VALUES('$nama_lengkap','$email','$password','$alamat')");
    if ($insertMember) {
        $_SESSION['id_member'] = mysqli_insert_id($koneksi);
        $_SESSION['id_session'] = session_id();
        header("location:?pg=member&tambah=berhasil");
    }
}
?>

<div class="untree_co-section">
    <div class="container">

        <div class="block">
            <div class="row justify-content-center">

                <div class="col-md-8 col-lg-8 pb-4">

                    <form method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-black" for="fname">Nama Lengkap</label>
                                    <input name="nama_lengkap" type="text" class="form-control" id="fname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-black" for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-black" for="lname">Password</label>
                                <input name="password" type="password" class="form-control" id="lname">
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <label class="text-black" for="message">Alamat</label>
                            <textarea name="alamat" class="form-control" id="message" cols="30" rows="5"></textarea>
                        </div>

                        <button name="simpan" type="submit" class="btn btn-primary-hover-outline">Send Message</button>
                    </form>

                </div>

            </div>

        </div>

    </div>


</div>