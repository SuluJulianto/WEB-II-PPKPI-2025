<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once $_SESSION["dir_root"] . '/module/product.php';
require_once $_SESSION["dir_root"] . '/module/dbconnect.php';

$site_root = $_SESSION["site_root"];

$hargamarkup = setHarga(10000);
$hargadiskon = setDiskon($hargamarkup);
$product = getProduct('HP XL 300', $hargadiskon);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>

<body>
    <table>
        <thead>
            <tr>
                <th> SKU </th>
                <th> Product </th>
                <th> UOM </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * from product order by product desc;";
            $stmt = db()->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['sku'] . "</td>";
                echo "<td>" . $row['product'] . "</td>";
                echo "<td>" . $row['uom'] . "</td>";
                echo "<td>";
                echo "<button id='btn_edit' onclick='btn_edit(" . $row['id'] . ',"' . $row['product'] . '")' . "'>";
                echo "<i class='fas fa-edit'></i>";
                echo "</button>";

                echo "</td>";
                echo "<td>";
                echo "<button id='btn_delete' onclick='btn_delete(" . $row['id'] . ',"' . $row['product'] . '")' . "'>";
                echo "<i class='fa fa-trash'></i></button>";
                echo "</td>";
                echo "</tr>";
            }
            $stmt->closeCursor();
            ?>
        </tbody>
    </table>
    <script src="<?= $site_root ?>/JS/tabel.js"></script>
</body>

</html>