<?php
const DB_HOST = 'localhost';
const DB_NAME = 'datanegara';
const DB_USER = 'ppkpi_edo';
const DB_PASS = 'ppkpiwp12345';

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

$kata = $_POST['q'] ?? '';
$kata = trim($kata);

if ($kata !== '') {
    try {
        $stmt = db()->prepare("SELECT nama FROM negara WHERE nama LIKE :kata ORDER BY nama ASC LIMIT 10");
        $stmt->execute([':kata' => "$kata%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = count($results);

        if ($count > 0) {
            echo "<p><strong>Hasil: $count</strong></p>";
            echo "<table>";
            echo "<tr><th>Nama Negara</th></tr>";
            foreach ($results as $row) {
                echo "<tr><td>" . htmlspecialchars($row['nama']) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ditemukan hasil untuk '<strong>" . htmlspecialchars($kata) . "</strong>'.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
