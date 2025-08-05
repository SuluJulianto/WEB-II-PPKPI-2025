<?php
    include'../koneksi.php';

    function getdata($koneksi, $id)
    {
        $query = mysqli_query($koneksi, "SELECT * FROM member WHERE id ='$id'");
        $data = mysqli_fetch_assoc($query);

        return $data;
    }
?>