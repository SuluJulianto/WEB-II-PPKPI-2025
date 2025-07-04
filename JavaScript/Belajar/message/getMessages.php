<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database (versi modern)
$koneksi = new mysqli("localhost", "ppkpi_edo", "ppkpiwp12345", "message");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari tabel message
$sql = "SELECT * FROM message";
$result = $koneksi->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($x = $result->fetch_assoc()) {
        $data[] = [
            "id"   => $x['message_id'],
            "user" => htmlspecialchars($x['user_name']),
            "text" => htmlspecialchars($x['message']),
            "time" => $x['post_time']
        ];
    }
}

// Struktur JSON akhir
$output = [
    "messages" => [
        "pesan" => $data
    ]
];

// Encode dan simpan ke file
$json = json_encode($output, JSON_PRETTY_PRINT);
file_put_contents("messages.json", $json);

// Tampilkan ke browser juga
header('Content-Type: application/json');
echo $json;

$koneksi->close();
?>
