<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/module/dbconnect.php';
require_once __DIR__ . '/autoloader.php';
use module\Sanitize;

class Authenticator extends Sanitize
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
        $action = $_POST['action'] ?? '';
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            default:
                $this->sendResponse('error', 'Aksi tidak valid.');
                break;
        }
    }

    private function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->sendResponse('error', 'Username dan password wajib diisi.');
            return;
        }

        try {
            // Tabel yang dituju adalah 'user'
            $stmt = $this->pdo->prepare("SELECT id, username, password, role FROM user WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                
                // Gunakan session terpadu yang benar
                $_SESSION['auth_id'] = $user['id'];
                $_SESSION['auth_nama'] = $user['username'];
                $_SESSION['auth_role'] = $user['role']; // Peran dari tabel user (seharusnya 'User')
                $_SESSION['auth_type'] = 'user'; // Penanda tipe login

                if (!isset($_SESSION['site_root'])) {
                     $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
                }
                
                // Arahkan ke dashboard yang sesuai (hanya user_dashboard.php untuk peran 'User')
                $redirect_url = $_SESSION['site_root'] . '/public/user_dashboard.php';
                
                $this->sendResponse('success', 'Login berhasil!', ['redirect' => $redirect_url]);
            } else {
                $this->sendResponse('error', 'Username atau password salah.');
            }
        } catch (PDOException $e) {
            $this->sendResponse('error', 'Terjadi kesalahan pada server.');
        }
    }

    private function register()
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            $this->sendResponse('error', 'Semua kolom wajib diisi.');
            return;
        }
        if ($password !== $confirm_password) {
            $this->sendResponse('error', 'Konfirmasi password tidak cocok.');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendResponse('error', 'Format email tidak valid.');
            return;
        }

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Saat registrasi, peran otomatis di-set ke 'User'
            $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, 'User')");
            $stmt->execute([$username, $email, $hashed_password]);
            
            $this->sendResponse('success', 'Registrasi berhasil! Silakan login.');

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $this->sendResponse('error', 'Username atau Email sudah terdaftar.');
            } else {
                $this->sendResponse('error', 'Gagal melakukan registrasi.');
            }
        }
    }

    private function sendResponse($status, $message, $data = null)
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
        exit;
    }
}

new Authenticator();