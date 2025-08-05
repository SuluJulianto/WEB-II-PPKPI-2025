<?php
// print_r($_SESSION);
// die;
if (isset($_POST['simpan'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    //PILIH database bernama user dan level dari user bergabung dengan level. data base kolom id level = level.id dmana user kolom email adalah variabel email
    $query = mysqli_query($koneksi, "SELECT * FROM member WHERE member.email='$email' ");
    //jika data base lebih bersar dari >0 maka program akan berjalan $_SESSION
    //session menampung data sementara (menampung data di dalam browser)
    if (mysqli_num_rows($query) > 0) {
        $dataUser = mysqli_fetch_assoc($query);
        // == ini untuk mebandingkan
        if ($dataUser['password'] == $password) {
            $_SESSION['id_member'] = $dataUser['id'];
            $_SESSION['id_session'] = session_id();
            header('location:index.php');
        }
    }
}
?>

<div class="untree_co-section">
    <div class="container">

        <div class="block">
            <div class="row justify-content-center">

                <div class="col-md-8 col-lg-8 pb-4">

                    <?php if (isset($_SESSION['id_member'])) : ?>
                        Selamat Datang Di Website E-commerce
                    <?php else : ?>
                        <form method="post">
                            <div class="row">
                                <div class="col-12">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-black" for="email">Email</label>
                                <input name="email" type="email" class="form-control" id="email">
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="text-black" for="lname">Password</label>
                                    <input name="password" type="password" class="form-control" id="lname">
                                </div>
                            </div>

                            <button name="simpan" type="submit" class="btn btn-primary-hover-outline">Login</button>
                            <a href="?pg=member">Registrasi</a>
                        </form>

                    <?php endif ?>

                </div>

            </div>

        </div>

    </div>


</div>