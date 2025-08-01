<?php
session_start();

$totalItems = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $val) {
        $totalItems += $val['product_qty'];
    }

    echo json_encode([
        'success' => true,
        'total_items' => $totalItems,
    ]);
}