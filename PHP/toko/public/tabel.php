<?php
if (!isset($_SESSION)) {
    session_start();
}
//var_dump($_SESSION["dir_root"]);
print_r($_SESSION["dir_root"], true);

require_once $_SESSION["dir_root"] . '/module/product.php';
require_once $_SESSION["dir_root"] . '/module/dbconnect.php';
$hargamarkup = setHarga(100000);
$hargadiskon = setDiskon($hargamarkup);
$product = getProduct('HP XL 800', $hargadiskon);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TABEL PHP PRODUCT</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="../tabel.js"></script>
    <style>
        table {
            width: 30%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product</th>
                <th>UOM</th>
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
    echo "<button id='btn_edit' onclick='btn_edit(" . $row['id'] . ", \"" . $row['sku'] . "\", \"" . $row['product'] . "\")'><i class='fas fa-edit'></i></button>";
    echo "</td>";
    echo "<td>";
    echo "<button id='btn_delete' onclick='btn_delete(" . $row['id'] . ", \"" . $row['sku'] . "\", \"" . $row['product'] . "\")'><i class='fas fa-trash'></i></button>";
    echo "</td>";
    echo "</tr>";
}
$stmt->closeCursor();
?>
        </tbody>
    </table>
</body>

</html>
