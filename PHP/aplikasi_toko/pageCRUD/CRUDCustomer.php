<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../module/dbconnect.php';
use module\Sanitize;

class CRUDCustomer extends Sanitize
{
    private $pdo;
    public function __construct() {
        $this->pdo = db();
        if(!empty($_POST)) $_POST = $this->sanitize($_POST);
        $this->handleRequest();
    }
    private function handleRequest() {
        $action = $_REQUEST['action'] ?? '';
        switch ($action) {
            case 'read': $this->read(); break;
            case 'getSingle': $this->getSingle(); break;
            case 'save': $this->save(); break;
            case 'delete': $this->delete(); break;
            default: $this->sendResponse('error', 'Aksi tidak valid.'); break;
        }
    }
    private function read() {
        $stmt = $this->pdo->query("SELECT * FROM customer ORDER BY id DESC");
        $this->sendResponse('success', 'Data customer dimuat.', $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    private function getSingle() {
        $id = $_GET['id'] ?? 0;
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE id = ?");
        $stmt->execute([$id]);
        $this->sendResponse('success', 'Data ditemukan.', $stmt->fetch(PDO::FETCH_ASSOC));
    }
    private function save() {
        $id = $_POST['id'] ?? null;
        $name = $_POST['customer'] ?? '';
        $address = $_POST['address'] ?? '';
        if(empty($name) || empty($address)) {
            $this->sendResponse('error', 'Semua kolom wajib diisi.'); return;
        }
        try {
            if(empty($id)) {
                $sql = "INSERT INTO customer (customer, address) VALUES (?, ?)";
                $params = [$name, $address];
            } else {
                $sql = "UPDATE customer SET customer = ?, address = ? WHERE id = ?";
                $params = [$name, $address, $id];
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->sendResponse('success', 'Data customer berhasil disimpan.');
        } catch(PDOException $e) {
            $this->sendResponse('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
    private function delete() {
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $this->pdo->prepare("DELETE FROM customer WHERE id = ?");
            $stmt->execute([$id]);
            $this->sendResponse('success', 'Customer berhasil dihapus.');
        } catch (PDOException $e) {
            $this->sendResponse('error', 'Gagal menghapus. Customer mungkin sudah digunakan dalam transaksi penjualan.');
        }
    }
    private function sendResponse($status, $message, $data = null) {
        echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]); exit;
    }
}
new CRUDCustomer();