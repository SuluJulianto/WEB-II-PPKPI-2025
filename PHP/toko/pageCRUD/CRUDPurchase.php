<?php

namespace pageCRUD;

// Pastikan autoloader dipanggil
require_once __DIR__ . '/../autoloader.php';

use module\DB;
use module\Sanitize;

class CRUDPurchase extends Sanitize
{
    public function __construct()
    {
        // Atur header untuk memastikan output adalah JSON
        header('Content-Type: application/json');
        
        // Sanitasi semua input (GET/POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = $this->sanitize($_POST);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $_GET = $this->sanitize($_GET);
        }

        // Arahkan ke metode yang sesuai berdasarkan 'action'
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
                $this->getSinglePurchase();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
                break;
        }
    }

    private function read()
    {
        // KEMBALIKAN KE QUERY SEMULA: Hanya mengambil data dari purchase_detail
        // karena tidak ada kolom penghubung untuk di-JOIN.
        $stmt = DB::query("SELECT id, id_product, qty, price FROM purchase_detail ORDER BY id ASC");
        $data = $stmt->fetchAll();
        echo json_encode(['status' => 'success', 'data' => $data]);
    }

    private function getSinglePurchase()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
            return;
        }
        // Query ini juga hanya dari purchase_detail
        $stmt = DB::query("SELECT id, id_product, qty, price FROM purchase_detail WHERE id = ?", [$id]);
        $data = $stmt->fetch();
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }
    }

    private function create()
    {
        // KITA TETAP SIMPAN TANGGAL DAN DETAIL, TAPI MEREKA TIDAK AKAN TERHUBUNG
        $purchase_date = $_POST['purchase_date'] ?? null;
        $id_product = $_POST['id_product'] ?? 0;
        $qty = $_POST['qty'] ?? 0;
        $price = $_POST['price'] ?? 0;

        if (!$purchase_date || !$id_product || !$qty) {
            echo json_encode(['status' => 'error', 'message' => 'Tanggal, ID Produk, dan Jumlah wajib diisi.']);
            return;
        }

        try {
            DB::connect()->beginTransaction();

            // Simpan header ke tabel purchase (ini akan menjadi data "yatim")
            DB::query("INSERT INTO purchase (purchase_date, id_supplier) VALUES (?, ?)", [$purchase_date, 1]);
            
            // Simpan detail ke tabel purchase_detail (juga "yatim")
            $query = "INSERT INTO purchase_detail (id_product, qty, price) VALUES (?, ?, ?)";
            DB::query($query, [$id_product, $qty, $price]);

            DB::connect()->commit();
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);

        } catch (\PDOException $e) {
            DB::connect()->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    private function update()
    {
        // Fungsi update kita biarkan seperti semula, hanya mengedit detail
        $id = $_POST['id'] ?? 0;
        $id_product = $_POST['id_product'] ?? 0;
        $qty = $_POST['qty'] ?? 0;
        $price = $_POST['price'] ?? 0;

        if (!$id || !$id_product || !$qty) {
            echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
            return;
        }

        $query = "UPDATE purchase_detail SET id_product = ?, qty = ?, price = ? WHERE id = ?";
        DB::query($query, [$id_product, $qty, $price, $id]);
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui.']);
    }

    private function delete()
    {
        // Fungsi delete juga hanya menghapus dari detail
        $id = $_POST['id'] ?? 0;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
            return;
        }
        DB::query("DELETE FROM purchase_detail WHERE id = ?", [$id]);
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
    }
}

new CRUDPurchase();