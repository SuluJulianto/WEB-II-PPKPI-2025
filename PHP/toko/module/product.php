<?php
$harga = 1000000; //global  scope
$diskon = 0.2;

function setHarga($markup){

    global $diskon;
    $harga = 500000; # local scope
    $price = $harga + $markup;
    return $price;

}

    function setDiskon($harga){
    global $diskon;
    $price = $harga -($harga * $diskon);
    return $price;
} 

function getProduct($product, $harga)
{
$product = [

["name" =>'HP Samsung 405', "price" => 15000, "discount"=> 300],   
["name" =>'HP Xiaomi 405', "price" => 5000, "discount"=> 500],
["name" => $product, "price" => $harga, "discount" =>500]
];

return $product;
}

function getArray() {

    $key = ["name", "price", "diskon"];
    $val = ['HP DSR 405', 150000,300,'hp 1345', 5400,100,'hp xl 345', 5000, 500];
 //$product
//  Array chunks adalah cara untuk membagi sebuah array (atau list) menjadi potongan-potongan kecil (sub-array) dengan panjang tertentu.
// Chunks (dalam konteks pemrograman/data) artinya adalah potongan-potingan kecil dari data yang lebih besar. Istilah ini umum digunakan saat kita ingin membagi data besar menjadi bagian-bagian lebih kecil yang mudah dikelola, diproses, atau ditampilkan.
    $chunks = array_chunk($val,3);
    $product = array();
    foreach($chunks as $value) {
    $product[]
//     Array combine adalah proses menggabungkan dua array—biasanya satu sebagai key dan satu sebagai value—menjadi array asosiatif (map/dictionary/object), di mana:

// Array pertama berisi ke, Array kedua berisi value
    = array_combine($key,$value);
}
//  var_dump fungsi debugging dalam PHP yang digunakan untuk menampilkan informasi lengkap tentang sebuah variabel, termasuk:
//var_dump($product);
}
getArray();
