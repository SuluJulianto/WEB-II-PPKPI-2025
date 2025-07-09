<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once $_SESSION["dir_root"] . '/module/dbconnect.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));
$result = ["response" => 0, "data" => "Aksi tidak valid"];

switch ($action) {
    case 'readData':
        $result = readData();
        break;
    case 'queryData':
        $result = queryData();
        break;
    case 'getSalesData':
        $result = getSalesData();
        break;
    case 'updateData':
        $result = updateData();
        break;
    // Tambahkan case baru untuk delete
    case 'deleteData':
        $result = deleteData();
        break;
}

header('Content-Type: application/json');
echo json_encode($result);
die();

// ... (fungsi readData, queryData, getSalesData, updateData tetap sama) ...
function readData() {
    $sql = "SELECT s.id, s.sales_date, c.customer, 
                   (SELECT SUM(sd.price * sd.qty) FROM sales_detail sd WHERE sd.id_sales = s.id) as total
            FROM sales s
            JOIN customer c ON s.id_customer = c.id
            GROUP BY s.id
            ORDER BY s.sales_date DESC, s.id DESC;";
    $stmt = db()->prepare($sql);
    $stmt->execute();
    return ["response" => 1, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
}

function queryData() {
    $sales_id = (int) filter_input(INPUT_POST, 'sales_id', FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT p.sku, p.product, sd.price, sd.qty, p.uom
            FROM sales_detail sd
            JOIN product p ON sd.id_product = p.id
            WHERE sd.id_sales = :id_sales";
    $stmt = db()->prepare($sql);
    $stmt->bindParam(':id_sales', $sales_id);
    $stmt->execute();
    return ["response" => 1, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
}

function getSalesData() {
    $sales_id = (int) filter_input(INPUT_POST, 'sales_id', FILTER_SANITIZE_NUMBER_INT);
    if ($sales_id === 0) {
        return ["response" => 0, "data" => "ID tidak valid"];
    }

    $stmtHeader = db()->prepare("SELECT * FROM sales WHERE id = :id");
    $stmtHeader->bindParam(':id', $sales_id);
    $stmtHeader->execute();
    $header = $stmtHeader->fetch(PDO::FETCH_ASSOC);

    $stmtDetail = db()->prepare("SELECT * FROM sales_detail WHERE id_sales = :id_sales");
    $stmtDetail->bindParam(':id_sales', $sales_id);
    $stmtDetail->execute();
    $details = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

    if (!$header) {
        return ["response" => 0, "data" => "Data tidak ditemukan"];
    }

    return ["response" => 1, "data" => ["header" => $header, "details" => $details]];
}

function updateData() {
    parse_str($_POST['form'], $formData);
    $id = (int)$formData['id'];
    $details = $_POST['details'] ?? [];

    if (empty($details)) {
        return ["response" => 0, "data" => "Detail penjualan tidak boleh kosong."];
    }

    try {
        db()->beginTransaction();

        if ($id > 0) {
            $sql = "UPDATE sales SET id_customer = :customer, sales_date = :sales_date WHERE id = :id";
            $stmt = db()->prepare($sql);
            $stmt->bindParam(':id', $id);
        } else {
            $sql = "INSERT INTO sales (id_customer, sales_date) VALUES (:customer, :sales_date)";
            $stmt = db()->prepare($sql);
        }

        $customer = $formData['customer'];
        $salesDate = DateTime::createFromFormat('d-m-Y', $formData['sales_date'])->format('Y-m-d');
        
        $stmt->bindParam(':customer', $customer);
        $stmt->bindParam(':sales_date', $salesDate);
        $stmt->execute();

        $salesId = ($id > 0) ? $id : db()->lastInsertId();

        if ($id > 0) {
            $stmtDelete = db()->prepare("DELETE FROM sales_detail WHERE id_sales = :id_sales");
            $stmtDelete->bindParam(':id_sales', $salesId);
            $stmtDelete->execute();
        }

        $stmtDetail = db()->prepare("INSERT INTO sales_detail (id_sales, id_product, price, qty) VALUES (:id_sales, :id_product, :price, :qty)");
        foreach ($details as $item) {
            $stmtDetail->bindParam(':id_sales', $salesId);
            $stmtDetail->bindParam(':id_product', $item['product_id']);
            $stmtDetail->bindParam(':price', $item['price']);
            $stmtDetail->bindParam(':qty', $item['quantity']);
            $stmtDetail->execute();
        }

        db()->commit();
        return ["response" => 1, "data" => "Data berhasil disimpan"];

    } catch (Exception $e) {
        db()->rollBack();
        return ["response" => 0, "data" => $e->getMessage()];
    }
}


/**
 * Fungsi baru untuk menghapus data penjualan.
 */
function deleteData() {
    $sales_id = (int) filter_input(INPUT_POST, 'sales_id', FILTER_SANITIZE_NUMBER_INT);

    if ($sales_id <= 0) {
        return ["response" => 0, "data" => "ID Penjualan tidak valid."];
    }

    try {
        db()->beginTransaction();

        // Langkah 1: Hapus semua baris detail yang terkait dengan id_sales
        $stmtDetail = db()->prepare("DELETE FROM sales_detail WHERE id_sales = :id_sales");
        $stmtDetail->bindParam(':id_sales', $sales_id, PDO::PARAM_INT);
        $stmtDetail->execute();
        
        // Langkah 2: Hapus data header penjualan
        $stmtHeader = db()->prepare("DELETE FROM sales WHERE id = :id");
        $stmtHeader->bindParam(':id', $sales_id, PDO::PARAM_INT);
        $stmtHeader->execute();

        db()->commit();
        return ["response" => 1, "data" => "Data berhasil dihapus."];

    } catch (Exception $e) {
        db()->rollBack();
        return ["response" => 0, "data" => "Gagal menghapus data: " . $e->getMessage()];
    }
}