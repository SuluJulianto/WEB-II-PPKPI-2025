<?php
header('Content-Type: application/json');

$koneksi = new mysqli("localhost", "ppkpi_edo", "ppkpiwp12345", "message");
if ($koneksi->connect_error) {
    echo json_encode(["error" => "Koneksi gagal"]);
    exit;
}

$sql = "SELECT * FROM message ORDER BY message_id ASC";
$result = $koneksi->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row['message_id'],
        "user" => htmlspecialchars($row['user_name']),
        "text" => htmlspecialchars($row['message']),
        "time" => $row['post_time']
    ];
}

echo json_encode(["messages" => ["pesan" => $data]], JSON_PRETTY_PRINT);
$koneksi->close();
