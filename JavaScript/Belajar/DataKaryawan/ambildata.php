<?php
// Konstanta koneksi database
const DB_HOST = 'localhost';
const DB_NAME = 'datakaryawan';
const DB_USER = 'ppkpi_edo';
const DB_PASS = 'ppkpiwp12345';

// Fungsi koneksi PDO
function db(): PDO
{
    static $pdo;
    if (!$pdo) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}

if (isset($_GET['q'])) {
    $nip = $_GET['q'];
    try {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT Alamat FROM tabelDataKaryawan WHERE NIP = ?");
        $stmt->execute([$nip]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo $row['Alamat'];
        } else {
            echo "Alamat tidak ditemukan";
        }

    } catch (PDOException $e) {
        echo "Koneksi error: " . $e->getMessage();
    }
} else {
    echo "Parameter NIP tidak tersedia";
}
?>
