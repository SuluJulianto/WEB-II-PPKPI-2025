<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once $_SESSION["dir_root"] . '/module/dbconnect.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

switch ($action) {
    case 'createData':
        $result = createData();
        break;
    case 'readData':
        $result = readData();
        break;
    case 'queryData':
        $result = queryData();
        break;
    case 'updateData':
        $result = updateData();
        break;
    case 'deleteData':
        $result = deleteData();
        break;
    default:
        # code...
        break;
}

echo json_encode($result);
die();

function createData() {}

function readData()
{
    $sql = "SELECT sales.*, customer.customer, customer.address 
    FROM toko.sales JOIN customer ON sales.id_customer = customer.id;";

    $stmt = db()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return ["response" => $row ? 1 : 0, "data" => $row];
}

function queryData()
{
    $sales_id = (int) filter_input(INPUT_POST, 'sales_id', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT toko.sales.*, id_customer, sales_date, 
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
    try {
        // Ambil data POST
        parse_str($_POST['form'], $formData);
        
        $customer = $formData['customer']; // Fixed bracket
        $salesDate = DateTime::createFromFormat('d-m-Y', $formData['sales_date'])->format('Y-m-d');

        // ambil array produk
        $productIds = $_POST['product_id'] ?? [];
        $prices = $_POST['price'] ?? [];
        $quantities = $_POST['quantity'] ?? [];

        $itemCount = count($productIds);

        db()->beginTransaction();
        $sql = "INSERT INTO sales (id_customer, sales_date) VALUES (:customer, :sales_date)";

        $stmt = db()->prepare($sql);
        $stmt->bindParam(':customer', $customer, PDO::PARAM_INT);
        $stmt->bindParam(':sales_date', $salesDate);
        $stmt->execute();

        $salesId = db()->lastInsertId();
        db()->commit();
        return ["response" => 1, "data" => 'ok'];
    } catch (Exception $e) {    
        db()->rollBack();
        return ["response" => 0, "data" => $e->getMessage()]; // Fixed arrow syntax
    }
}


function deleteData() {}