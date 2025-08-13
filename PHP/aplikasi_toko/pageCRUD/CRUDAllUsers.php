<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../module/dbconnect.php';
use module\Sanitize;

class CRUDAllUsers extends Sanitize
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = db();
        $this->handleRequest();
    }

    private function handleRequest()
    {
        $action = $_REQUEST['action'] ?? '';
        if ($action == 'read') {
            $this->readAll();
        } else {
            $this->sendResponse('error', 'Aksi tidak valid.');
        }
    }

    private function readAll()
    {
        // Query untuk mengambil data dari tabel karyawan
        $sql_karyawan = "
            SELECT 
                NIP AS id, 
                Nama AS nama, 
                Email AS email, 
                Role AS role, 
                'Karyawan' AS tipe 
            FROM tabeldatakaryawan
        ";

        // Query untuk mengambil data dari tabel user
        $sql_user = "
            SELECT 
                id, 
                username AS nama, 
                email, 
                role, 
                'User' AS tipe 
            FROM user
        ";

        // Gabungkan kedua query dengan UNION ALL
        $sql_union = $sql_karyawan . " UNION ALL " . $sql_user . " ORDER BY tipe, id";
        
        $stmt = $this->pdo->query($sql_union);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->sendResponse('success', 'Data semua pengguna dimuat.', $data);
    }
    
    private function sendResponse($status, $message, $data = null)
    {
        echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
        exit;
    }
}

new CRUDAllUsers();