<?php
session_start();
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $val) {
            $grandTotal += $val['product_price'] * $val['product_qty'];
        }

        echo json_encode([
            'success' => true,
            'grand_total' => $grandTotal,
            'message' => "Produk berhasil dihapus",
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Produk tidak ditemukan",
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Id tidak tersedia",
    ]);
}