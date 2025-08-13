<?php

const DB_HOST = 'localhost';          // Host database
const DB_NAME = 'users_db';           // Nama database yang simpel
const DB_USER = 'ppkpi_edo';               // User default XAMPP
const DB_PASS = 'ppkpiwp12345';                   // Password default XAMPP kosong

function db(): PDO
{
    static $pdo;
    if (!$pdo) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8";
        
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Koneksi ke database gagal: " . $e->getMessage());
        }
    }
    return $pdo;
}
date_default_timezone_set('Asia/Jakarta');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>