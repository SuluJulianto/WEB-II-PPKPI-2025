<?php
// print_r("tess");
// die;
if (!isset($_SESSION['id-member'])) {
    header("location:?pg=member&message=Upss-REGISTER-DULU");
}else{
    $id_member = $_SESSION['id_member'];
    $id_produk = $_POST['id_produk'];
    $queryCart = mysqli_query($koneksi, "SELECT id_produk, qty FROM detail_penjual WHERE id_produk = '$id_produk'");
    while($rowCart = mysqli_fetch_assoc($queryCart)){

    }
    // $penjualan = mysqli_query($koneksi, "INSERT INTO penjualan
    //  (id_member, status) VALUES ('$id_member', 0)");

    //  if($penjualan){

    //  }
}
