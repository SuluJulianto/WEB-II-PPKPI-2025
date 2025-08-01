<?php
session_start();
include 'admin/koneksi.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

try {
    $id_product = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_qty = intval($_POST['qty']);

    if (isset($_SESSION['cart'][$id_product])) {
        $_SESSION['cart'][$id_product]['product_qty'] += $product_qty;
    } else {
        $_SESSION['cart'][$id_product] = [
            'id' => $id_product,
            'product_name'  => $product_name,
            'product_price' => $product_price,
            'product_qty'   => $product_qty,
        ];
    }

    $totalItems = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $totalItems += $value['product_qty'];
    }

    $response = [
        'success' => true,
        'message' => 'Produk berhasil ditambahkan ke keranjang!',
        'total_items' => $totalItems
    ];
    echo json_encode($response);
} catch (\Throwable $th) {
    echo json_encode([
        'success' => false,
        'message' => $th->getMessage(),
    ]);
}
