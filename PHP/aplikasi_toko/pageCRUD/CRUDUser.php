<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../module/dbconnect.php';

use module\Sanitize;

class CRUDUser extends Sanitize
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = db();
        if (!empty($_POST)) {
            $_POST = $this->sanitize($_POST);
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
            case 'getSingle':
                $this->getSingle();
                break;
            case 'save': // Satu fungsi untuk create dan update
                $this->save();
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
        $stmt = $this->pdo->query("SELECT id, username, email, is_admin, status FROM user ORDER BY id ASC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->sendResponse('success', 'Data pengguna dimuat.', $data);
    }
    
    private function getSingle()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $this->sendResponse('error', 'ID pengguna tidak valid.');
            return;
        }
        $stmt = $this->pdo->prepare("SELECT id, username, email, is_admin, status FROM user WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->sendResponse('success', 'Data ditemukan.', $data);
        } else {
            $this->sendResponse('error', 'Pengguna tidak ditemukan.');
        }
    }

    private function save()
    {
        $id = $_POST['id'] ?? 0;
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $is_admin = $_POST['is_admin'] ?? '0';

        if (empty($username) || empty($email)) {
            $this->sendResponse('error', 'Username dan Email wajib diisi.');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendResponse('error', 'Format email tidak valid.');
            return;
        }

        try {
            // Jika ini adalah user baru (create), password wajib diisi
            if (empty($id) && empty($password)) {
                $this->sendResponse('error', 'Password wajib diisi untuk pengguna baru.');
                return;
            }

            // Bagian untuk CREATE (id kosong)
            if (empty($id)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
                $params = [$username, $email, $hashed_password, $is_admin];
            } 
            // Bagian untuk UPDATE (id ada)
            else {
                // Jika password diisi saat update, hash password baru
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE user SET username = ?, email = ?, password = ?, is_admin = ? WHERE id = ?";
                    $params = [$username, $email, $hashed_password, $is_admin, $id];
                } 
                // Jika password dikosongkan saat update, jangan ubah password lama
                else {
                    $sql = "UPDATE user SET username = ?, email = ?, is_admin = ? WHERE id = ?";
                    $params = [$username, $email, $is_admin, $id];
                }
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->sendResponse('success', 'Data pengguna berhasil disimpan.');

        } catch (PDOException $e) {
            // Cek jika ada duplikasi username/email (kode error 23000)
            if ($e->getCode() == '23000') {
                $this->sendResponse('error', 'Gagal: Username atau Email sudah terdaftar.');
            } else {
                $this->sendResponse('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        }
    }

    private function delete()
    {
        $id = $_POST['id'] ?? 0;
        if (empty($id)) {
            $this->sendResponse('error', 'ID pengguna tidak valid.');
            return;
        }
        // Keamanan tambahan: Jangan biarkan admin menghapus dirinya sendiri
        session_start();
        if ($id == $_SESSION['user_id']) {
            $this->sendResponse('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$id]);
            $this->sendResponse('success', 'Pengguna berhasil dihapus.');
        } catch (PDOException $e) {
            $this->sendResponse('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
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

new CRUDUser();