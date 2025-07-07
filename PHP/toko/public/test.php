<?php
//Ternary 
(int) $harga = isset($_POST['harga']) ? $_POST['harga'] : 232323;
(int) $diskon = isset($_POST['diskon']) ? $_POST['diskon'] : 44;

$tax = 10.5; //float
$agree = true; //boolean

(string) $nama = 'sigit';
(string) $product = "HD Dell 1700";

$purchase = array("product" => 'HD Dell 1700', "price" => 12300);
$purchased = ["product" => 'HP XL 300', "price" => 56300];
$sales = [3200, 5000, 4000];

unset($purchase['product']);
// var_dump($purchase);
$purchase['discount'] = 456;
$purchase['Address'] = 'ps rebo';
$purchase['product'] = 'HP 5600';

echo 'Product : ' . $purchase["product"] . "<br>";
echo 'Price : ' . $purchase["price"] . "<br>";
echo 'Discount : ' . $purchase["discount"] . "<br>";
echo 'Alamat   : ' . $purchase["Address"] . "<br>";

$keys = array_keys($purchase);
$key = $keys[3];
$value = $purchase[$key];

echo 'New Product   : ' . $key . ' ' . $value . "<br>";
echo 'Sales   : ' . $sales[2] . "<br>";

$nourut = 1;
foreach ($purchase as $key => $value) {
    echo $nourut++ . ' ' . $key . ' ' . $value . "<br>";
}

echo $sales[2] = 5000 ? 'Benar' : 'Salah';
echo "<br>";

if ($sales[2] = 5000) {
    echo 'Benar';
} else {
    echo 'Salah';
}

echo "<br>";
for ($i = 1; $i >= -10; $i--) {
    echo  $i;
}

// for ($i = 1; $i <= 10; $i++) {
//     echo  $i;
// }

echo "<br>";

$i = 2;
for (;;) {
    if ($i > 10) {
        break;
    }
    $i++;
    echo $i;
}
echo "<br>";
echo "while <br>";
$x = 1;
while ($x <= 10):
    $x++;
    echo $x++;
    echo $x;
    $x++;

endwhile;

echo "<br>";
echo "do while <br>";
$x = 1;
do {
    echo $x++;
} while ($x <= 10);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="#">
        <div>
            <label id="labelharga" for="harga">harga :</label>
            <input id="harga" name="harga" value="<?= $harga ?>" />
            <p>Harga <?= $harga ?></p>

        </div>
        <div>
            <label for="diskon">diskon :</label>
            <input id="diskon" name="diskon" value="<?= $diskon ?>" />
        </div>
        <button id="btn_test">Test</button>
        <button type="submit">*** SAVE ***</button>
    </form>
    <script>
        const button = document.getElementById('btn_test');
        const harga = document.getElementById('harga');
        const diskon = document.getElementById('diskon');
        const lbl_harga = document.getElementById('labelharga');

        button.addEventListener('click', function(e) {
            diskon.value = harga.value >= 10000 ? 500 : 100;
            lbl_harga.innerHTML = "PRICE";

            $harga = 100;
            // <?= $harga ?> = 99;
            console.log("input harga = " + harga.value);
            console.log("??? $harga = " + $harga);
            console.log("php harga = " + "<?= $harga ?>");

        })

        harga.addEventListener('change', e => {
            diskon.value = 300;
        })
    </script>
</body>
<!-- localhost/toko/public/test.php -->

</html>