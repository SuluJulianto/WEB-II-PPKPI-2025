<?php
$query = mysqli_query($koneksi, "SELECT * FROM member WHERE deleted_at = 0 ORDER BY id DESC");
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "UPDATE member SET deleted_at = 1 WHERE id ='$id'");
    header('location:?pg=member&hapus=berhasil');
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($query)) : 
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $row['nama_lengkap'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['alamat'] ?></td>
                <td>
                    <!-- <a href="?pg=tambah-member&edit=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Edit </a> - -->
                    <a onclick="return confirm('yakin gak nieh?')" href="?pg=member&delete=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php endwhile ?>
    </tbody>
</table>