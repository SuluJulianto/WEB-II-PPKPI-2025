<?php

$querySetting = mysqli_query($koneksi, "SELECT * FROM setting ORDER BY id DESC");

if (isset($_POST['simpan'])) {
    $email_website = $_POST['email_website'];
    $tlp_website = $_POST['no_tlpn_website'];
    $alamat_website = $_POST['alamat_website'];
    $facebook_link = $_POST['fb'];
    $twitter_link = $_POST['twitter'];
    $instagram_link = $_POST['ig'];
    $linked_link = $_POST['linkedin'];

    if (mysqli_num_rows($querySetting) > 0) {
        //update

    } else {
        //insert

        $insert = mysqli_query($koneksi, "INSERT INTO setting (email_website, no_tlpn_website, alamat_website, ig, twitter, fb, linkedin)
     VALUES ('$email_website','$tlp_website','$alamat_website','$instagram_link','$twitter_link','$facebook_link','$linked_link')");
        // header("location:?pg=level&insert=berhasil");
    }
}

$rowSetting = mysqli_fetch_assoc($querySetting);

?>

<!-- multipart/formdata berfungsi untuk meng upload -->
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="">Email Website</label>
        <input value="<?php echo $rowSetting['email_website'] ?>" type="email" class="form-control" name="email_website" placeholder="Email Website">
    </div>

    <div class="mb-3">
        <label for="">Telpon Website</label>
        <input value="<?php echo $rowSetting['no_tlpn_website'] ?>" type="text" class="form-control" name="no_tlpn_website" placeholder="Telpon Website">
    </div>

    <div class="mb-3">
        <label for="">Alamat</label>
        <textarea value="<?php echo $rowSetting['alamat_website'] ?>" class="form-control" name="alamat_website" id=""></textarea>
    </div>
    <div class="mb-3">
        <label for="">Facebook Link</label>
        <input value="<?php echo $rowSetting['fb'] ?>" type="url" class="form-control" name="fb" placeholder="Facebook link">
    </div>
    <div class="mb-3">
        <label for="">Twitter Link</label>
        <input value="<?php echo $rowSetting['twitter'] ?>" type="url" class="form-control" name="twitter" placeholder="Twitter link">
    </div>
    <div class="mb-3">
        <label for="">Instagram Link</label>
        <input value="<?php echo $rowSetting['ig'] ?>" type="text" class="form-control" name="ig" placeholder="Instagram link">
    </div>

    <div class="mb-3">
        <label for="">Linkedin</label>
        <input value="<?php echo $rowSetting['linkedin'] ?>" type="text" class="form-control" name="linkedin" placeholder="Linkedid link">

        <div class="mb-3">
            <label for="">Logo</label>
            <input type="file" name="logo">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
        </div>
    </div>
</form>