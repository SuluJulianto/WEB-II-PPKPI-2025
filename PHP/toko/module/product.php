<?php

$harga = 1000000; //global scope
$diskon = 0.1;


function setHarga($markup)
{
    global $diskon;
    $harga = 50000; //local scope
    $price = $harga + $markup;
    return $price;
}


function setDiscount($harga){
    global $diskon;
    $price = $harga - ($harga * $diskon);
    return $price;

}

function getProduct($product, $harga)
{
    return ["name" => $product, "price" => $harga, "discount" => 500];
}

?>
<!-- $harga pada function setHarga($harga) tidak saling berpengaruh dengan function getProduct($product, $harga) -->
