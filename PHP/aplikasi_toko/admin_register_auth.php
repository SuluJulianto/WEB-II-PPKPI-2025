<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/module/dbconnect.php';
require_once __DIR__ . '/autoloader.php';

use module\Sanitize;

// ===================================================================
// KODE KHUSUS REGISTRASI - GANTI KODE INI SESUAI KEINGINAN ANDA
// ===================================================================
define('ADMIN_REGISTRATION_CODE', 'RAHASIA-TOKO-123');
// ===================================================================

class AdminRegistrar extends Sanitize
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = db();
        $_POST = $this->sanitize($_POST);
        $this->register();
    }

    private function register()
    {
        header('Content-Type: application/json');
        
        $nip = $_POST['nip'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? '';
        $special_code = $_POST['special_code'] ?? '';

        // Validasi 1: Semua field harus diisi
        if (empty($nip) || empty($nama) || empty($email) || empty($password) || empty($role) || empty($special_code)) {
            $this->sendResponse('error', 'Semua kolom wajib diisi.');
            return;
        }

        // Validasi 2: Cek Kode Khusus
        if ($special_code !== ADMIN_REGISTRATION_CODE) {
            $this->sendResponse('error', 'Kode Khusus Pendaftaran salah!');
            return;
        }
        
        // Validasi 3: Cek konfirmasi password
        if ($password !== $confirm_password) {
            $this->sendResponse('error', 'Konfirmasi password tidak cocok.');
            return;
        }

        // Validasi 4: Pastikan hanya ada satu Manager
        if ($role === 'Manager') {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tabeldatakaryawan WHERE Role = 'Manager'");
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $this->sendResponse('error', 'Peran "Manager" sudah ada. Hanya boleh ada satu Manager.');
                return;
            }
        }

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO tabeldatakaryawan (NIP, Nama, Email, Password, Role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nip, $nama, $email, $hashed_password, $role]);
            
            $this->sendResponse('success', 'Registrasi Karyawan berhasil! Akun sekarang dapat digunakan untuk login.');

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Error untuk duplikasi NIP atau Email
                $this->sendResponse('error', 'Gagal: NIP atau Email sudah terdaftar.');
            } else {
                $this->sendResponse('error', 'Terjadi kesalahan pada database: ' . $e->getMessage());
            }
        }
    }
    
    private function sendResponse($status, $message)
    {
        echo json_encode(['status' => $status, 'message' => $message]);
        exit;
    }
}

new AdminRegistrar();