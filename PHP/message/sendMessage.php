<?php
session_start();
header('Content-Type: application/json');

$koneksi = new mysqli("localhost", "ppkpi_edo", "ppkpiwp12345", "message");
if ($koneksi->connect_error) {
    echo json_encode(["status" => "gagal", "error" => "Koneksi gagal"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$user = $_SESSION['username'] ?? '';
$text = $data['text'] ?? '';

if (!$user || !$text) {
    echo json_encode(["status" => "gagal", "error" => "Data kosong"]);
    exit;
}

$text = $koneksi->real_escape_string($text);
date_default_timezone_set("Asia/Jakarta");
$time = date("Y-m-d H:i:s");

$sql = "INSERT INTO message (user_name, message, post_time) VALUES ('$user', '$text', '$time')";
if ($koneksi->query($sql)) {
    echo json_encode(["status" => "sukses"]);
} else {
    echo json_encode(["status" => "gagal"]);
}

$koneksi->close();
