<?php
namespace pageCRUD;
require_once  '..\autoloader.php';


use module\DB;


class CRUDPurchase {
    public $id_product;
    public $qty;
  
    public function __construct() {
        var_dump('test');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST = $this->sanitize($_POST);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = $this->sanitize($_GET);
        }
        $this->handleRequest();
    }

    public function sanitize($data) {
        if (is_array($data)){
            return array_map([$this, 'sanitize'], $data);
        } else {
            $data = htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
            $data = trim($data);
            return $data;
        }
    }

    public function handleRequest() {
        $action = $_REQUEST['action'] ?? '';
        switch ($action) {
            case "read":
            $stmt = $this->read();
            while ($row = $stmt->fetch()) {
                echo"
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['id_product']}</td>
                        <td>{$row['qty']}</td>
                        <td>{$row['price']}</td>
                        <td>
                            <button class='btn-edit' data_id='{$row['id']}'>Edit</button>
                            <button class='btn-delete' data_id='{$row['id']}'>Delete</button>
                        </td>
                    </tr>";
            }

            exit;

            case "create":
                $this -> id_product = $_POST['id_product'];
                $this -> qty = $_POST['qty'];
                if($this->create()) echo "Data berhasil disimpan";
                exit;


        }
    }

    public function read() {
        // $query = "SELECT * FROM purchase_detail";
        // $stmt = DB::query($query);
        // return $stmt;
        return DB::query("SELECT * FROM purchase_detail");
    }

    public function create() {
        //  var_dump($this->id_product, $this->qty);
        $query = "INSERT INTO purchase_detail (id_product, qty) VALUES (:id_product, :qty)";
        return DB::query($query, [
        ':id_product' => $this->id_product,
        ':qty' => $this->qty
    ]);

    }
}

new CRUDPurchase();