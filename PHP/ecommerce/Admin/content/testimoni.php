<?php
$query = mysqli_query($koneksi, "SELECT * FROM testimoni ORDER BY id DESC");
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM testimoni WHERE id ='$id'");
    header("location:?pg=testimoni&hapus=berhasil");
}
?>
<div align="right" class="mb-3">
    <a href="?pg=tambah-testimoni" class="btn btn-primary">Tambah Instruktur</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $row['nama'] ?></td>
                <td><?php echo $row['jabatan'] ?></td>
                <td><?php echo $row['deskripsi'] ?></td>
                <td><a href="?pg=tambah-testimoni&edit=<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Edit
                        <a onclick="return confirm('yakin gak nieh?')" href="?pg=testimoni&delete=<?php echo $row['id'] ?>" class="btn btn-xs btn-danger">Delete</a>
                </td>
            </tr>
        <?php endwhile ?>
    </tbody>
</table>