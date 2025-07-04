<?php
session_start();
header('Content-Type: application/json');

$koneksi = new mysqli("localhost", "ppkpi_edo", "ppkpiwp12345", "message");
if ($koneksi->connect_error) {
    echo json_encode(["status" => "gagal", "error" => "Koneksi gagal"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0);
$user = $_SESSION['username'] ?? '';

if (!$id || !$user) {
    echo json_encode(["status" => "gagal", "error" => "Tidak valid"]);
    exit;
}

// Hapus hanya jika user sesuai
$sql = "DELETE FROM message WHERE message_id = $id AND user_name = '$user'";
if ($koneksi->query($sql)) {
    echo json_encode(["status" => "sukses"]);
} else {
    echo json_encode(["status" => "gagal"]);
}

$koneksi->close();
