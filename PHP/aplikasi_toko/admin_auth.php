<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/module/dbconnect.php';
require_once __DIR__ . '/autoloader.php';
use module\Sanitize;

class AdminAuthenticator extends Sanitize
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = db();
        $_POST = $this->sanitize($_POST);
        $this->login();
    }

    private function login()
    {
        header('Content-Type: application/json');
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Email dan Password wajib diisi.']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT NIP, Nama, Password, Role FROM tabeldatakaryawan WHERE Email = ? LIMIT 1");
            $stmt->execute([$email]);
            $karyawan = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($karyawan && password_verify($password, $karyawan['Password'])) {
                session_regenerate_id(true);
                
                // KUNCI PERBAIKAN: Gunakan session terpadu
                $_SESSION['auth_id'] = $karyawan['NIP'];
                $_SESSION['auth_nama'] = $karyawan['Nama'];
                $_SESSION['auth_role'] = $karyawan['Role'];
                $_SESSION['auth_type'] = 'karyawan'; // Penanda tipe login

                // Set site_root untuk pengalihan
                if (!isset($_SESSION['site_root'])) {
                     $_SESSION["site_root"] = "http://" . $_SERVER['HTTP_HOST'] . "/toko";
                }
                
                $redirect_url = $_SESSION['site_root'] . '/public/admin_dashboard.php';
                echo json_encode(['status' => 'success', 'data' => ['redirect' => $redirect_url]]);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Email atau Password Karyawan salah.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Kesalahan server.']);
        }
    }
}
new AdminAuthenticator();