<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once $_SESSION["dir_root"] . "/module/dbconnect.php";

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

switch ($action) {
    case "createData":
        $result = createData();
        break;
    case "readData":
        $result = readData();
        break;
    case "queryData":
        $result = queryData();
        break;
    case "updateData":
        $result = updateData();
        break;
    case "deleteData":
        $result = deleteData();
        break;
    default:
        # code...
        break;
}

echo json_encode($result);
die();

function createData() {
    // isi fungsi createData sesuai kebutuhan
}

function readData() {
    $sql = "SELECT sales.*, customer.customer, customer.address
            FROM toko.sales JOIN customer ON sales.id_customer = customer.id";

    $stmt = db()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return ["response" => $row ? 1 : 0, "data" => $row];
}

function queryData() {
    $sales_id = (int) filter_input(INPUT_POST, 'sales_id', FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT sales_detail.*, product.sku, product.product, product.uom
            FROM toko.sales_detail
            JOIN product ON sales_detail.id_product = product.id
            WHERE id_sales = :id_sales";

    $stmt = db()->prepare($sql);
    $stmt->bindParam(':id_sales', $sales_id);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return ["response" => $row ? 1 : 0, "data" => $row];
}

function updateData() {
    // isi fungsi updateData sesuai kebutuhan
}

function deleteData() {
    // isi fungsi deleteData sesuai kebutuhan
}
