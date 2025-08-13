<?php
$harga = 100000; //global scope
$diskon = 0.1;

function setHarga($markup)
{
    $harga = 50000; //local scope
    $price = $harga + $markup;
    return $price;
}

function setDiskon($harga)
{
    global $diskon;
    $price = $harga - ($harga * $diskon);
    return $price;
}

function getProduct($product, $harga)
{
    $product = [
        ["name" => 'HP DSR 405', "price" => 15000, "discount" => 300],
        ["name" => 'HP 1345', "price" => 5400, "discount" => 100],
        ["name" => 'HP XL 345', "price" => 5000, "discount" => 500]
    ];
    // var_dump($product);
    return $product;
}

function getArray()
{
    $key = ["name", "price", "diskon"];
    $val = ['HP DSR 405', 15000, 300, 'HP 1345', 5400, 100, 'HP XL 345', 5000, 500];
    $product = [];
    $v = 0;
    while ($v <= 6) {
        // $row : [$key[0] => $val[$v], $key[1] => $val[$v + 1], $key[2] => $val[$v + 2]];
        $k = 0;
        $row = [];
        while ($k <= 2) {
            $row[$key[$k]] = $val[$v + $k];
            $k++;
        }
        $product[] = $row;
        $v = $v + 3;
    }
    // var_dump($product);
    return $product;
}
