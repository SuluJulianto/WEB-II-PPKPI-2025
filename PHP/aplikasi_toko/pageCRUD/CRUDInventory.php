<?php
// Perhatikan nama file ini adalah CRUDInventory.php
header('Content-Type: application/json');

require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../module/dbconnect.php';

use module\Sanitize;

class CRUDInventory extends Sanitize
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = db();
        if (!empty($_POST)) {
            $_POST = $this->sanitize($_POST);
        }
        if (!empty($_GET)) {
            $_GET = $this->sanitize($_GET);
        }
        $this->handleRequest();
    }

    private function handleRequest()
    {
        $action = $_REQUEST['action'] ?? '';
        switch ($action) {
            case 'read':
                $this->read();
                break;
            case 'create':
                $this->create();
                break;
            case 'getSingle':
                $this->getSingle();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->sendResponse('error', 'Aksi tidak valid.');
                break;
        }
    }

    private function read()
    {
        $stmt = $this->pdo->query("SELECT id, sku, product, uom FROM product ORDER BY id ASC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->sendResponse('success', 'Data inventori berhasil dimuat.', $data);
    }

    private function getSingle()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $this->sendResponse('error', 'ID item tidak disediakan.');
            return;
        }
        $stmt = $this->pdo->prepare("SELECT id, sku, product, uom FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->sendResponse('success', 'Data item ditemukan.', $data);
        } else {
            $this->sendResponse('error', 'Data item tidak ditemukan.');
        }
    }

    private function create()
    {
        $sku = $_POST['sku'] ?? '';
        $product = $_POST['product'] ?? '';
        $uom = $_POST['uom'] ?? '';

        if (empty($sku) || empty($product) || empty($uom)) {
            $this->sendResponse('error', 'Semua kolom wajib diisi.');
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO product (sku, product, uom) VALUES (?, ?, ?)");
            $stmt->execute([$sku, $product, $uom]);
            $this->sendResponse('success', 'Item baru berhasil ditambahkan ke inventori.');
        } catch (PDOException $e) {
            $this->sendResponse('error', 'Gagal menyimpan item: ' . $e->getMessage());
        }
    }

    private function update()
    {
        $id = $_POST['id'] ?? 0;
        $sku = $_POST['sku'] ?? '';
        $product = $_POST['product'] ?? '';
        $uom = $_POST['uom'] ?? '';

        if (empty($id) || empty($sku) || empty($product) || empty($uom)) {
            $this->sendResponse('error', 'Data tidak lengkap untuk proses update.');
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE product SET sku = ?, product = ?, uom = ? WHERE id = ?");
            $stmt->execute([$sku, $product, $uom, $id]);
            $this->sendResponse('success', 'Data item berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->sendResponse('error', 'Gagal memperbarui item: ' . $e->getMessage());
        }
    }

    private function delete()
    {
        $id = $_POST['id'] ?? 0;
        if (empty($id)) {
            $this->sendResponse('error', 'ID item tidak disediakan.');
            return;
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM product WHERE id = ?");
            $stmt->execute([$id]);
            $this->sendResponse('success', 'Item berhasil dihapus dari inventori.');
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                 $this->sendResponse('error', 'Gagal: Item ini sudah digunakan dalam transaksi penjualan atau pembelian.');
            } else {
                 $this->sendResponse('error', 'Gagal menghapus item: ' . $e->getMessage());
            }
        }
    }

    private function sendResponse($status, $message, $data = null)
    {
        $response = ['status' => $status, 'message' => $message];
        if ($data !== null) {
            $response['data'] = $data;
        }
        echo json_encode($response);
        exit;
    }
}

new CRUDInventory();