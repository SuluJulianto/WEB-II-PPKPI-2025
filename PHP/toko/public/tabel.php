<?php
    require_once ("../module/product.php");
    $hargahmarkup = setHarga(50000);
    $hargadiskon = setDiscount($hargahmarkup);
    $product = getProduct('HP XL 300', $hargadiskon)
?>

<!-- $product = getProduct('HP XL 300', 345); -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Toko</title>
</head>
<body>
    <table border="1" style="color: DodgerBlue" ;>
        
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Discount</th>
            </tr>
        </thead>
        <tbody>
             <tr>
                <td><?= $product["name"] ?></td>
                <td><?= $product["price"] ?></td>
                <td><?= $product["discount"] ?></td>
            </tr>
            <tr>
                <?php 
                    foreach ($product as $key => $value){
                        echo '<td>' . $value . "</td>";
                    }
                ?>
            </tr>
        </tbody>
    </table>
</body>
</html>