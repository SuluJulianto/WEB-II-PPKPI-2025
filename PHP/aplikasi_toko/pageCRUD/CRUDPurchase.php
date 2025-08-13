<?php

// Pastikan namespace sesuai dengan struktur folder Anda
namespace pageCRUD;

// Panggil autoloader dan file koneksi dasar
require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../module/dbconnect.php'; // Menggunakan dbconnect lama untuk sementara

use module\Sanitize;
use PDO;
use PDOException;

// Atur header default untuk output JSON
header('Content-Type: application/json');

class CRUDPurchase extends Sanitize
{
    private $pdo;

    public function __construct()
    {
        // Gunakan fungsi db() dari dbconnect.php untuk mendapatkan koneksi PDO
        $this->pdo = db();
        
        // Sanitasi semua input (GET/POST)
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
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        switch ($action) {
            case 'create':
                $this->create();
                break;
            // Aksi lain seperti read, update, delete bisa ditambahkan di sini nanti
            default:
                $this->sendResponse('error', 'Aksi tidak valid.');
                break;
        }
    }

    private function create()
    {
        // Ambil data header
        $purchase_date = $_POST['purchase_date'] ?? null;
        $id_supplier = $_POST['id_supplier'] ?? null;
        
        // Ambil data detail (array produk)
        $details = $_POST['details'] ?? [];

        // Validasi dasar
        if (!$purchase_date || !$id_supplier || empty($details)) {
            $this->sendResponse('error', 'Data tidak lengkap. Pastikan tanggal, supplier, dan minimal satu barang telah diisi.');
            return;
        }

        try {
            // Memulai transaksi, memastikan semua query berhasil atau tidak sama sekali
            $this->pdo->beginTransaction();

            // 1. Simpan data header ke tabel 'purchase'
            $sql_header = "INSERT INTO purchase (purchase_date, id_supplier) VALUES (?, ?)";
            $stmt_header = $this->pdo->prepare($sql_header);
            $stmt_header->execute([$purchase_date, $id_supplier]);

            // Ambil ID dari header yang baru saja disimpan
            $id_purchase = $this->pdo->lastInsertId();

            // 2. Siapkan query untuk menyimpan detail
            $sql_detail = "INSERT INTO purchase_detail (id_purchase, id_product, qty, price) VALUES (?, ?, ?, ?)";
            $stmt_detail = $this->pdo->prepare($sql_detail);

            // 3. Looping dan simpan setiap barang di detail
            foreach ($details as $item) {
                if (empty($item['product_id']) || empty($item['qty']) || !isset($item['price'])) {
                    throw new PDOException("Data barang tidak lengkap pada salah satu baris.");
                }
                $stmt_detail->execute([
                    $id_purchase,
                    $item['product_id'],
                    $item['qty'],
                    $item['price']
                ]);
            }

            // Jika semua berhasil, commit transaksi
            $this->pdo->commit();
            $this->sendResponse('success', 'Transaksi pembelian berhasil disimpan.');

        } catch (PDOException $e) {
            // Jika ada satu saja error, batalkan semua perubahan (rollback)
            $this->pdo->rollBack();
            $this->sendResponse('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    private function sendResponse($status, $message, $data = [])
    {
        $response = ['status' => $status, 'message' => $message];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        echo json_encode($response);
        exit;
    }
}

// Inisialisasi kelas untuk menangani request
new CRUDPurchase();