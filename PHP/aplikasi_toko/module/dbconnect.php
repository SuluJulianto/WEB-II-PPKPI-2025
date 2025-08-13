<?php
// toko/module/dbconnect.php

const DB_HOST = 'localhost';    // Alamat Server DB
const DB_NAME = 'toko';         // Nama Database
const DB_USER = 'ppkpi_edo';      // User Database
const DB_PASS = 'ppkpiwp12345';      // Password Database

/**
 * Fungsi untuk membuat dan mengembalikan koneksi PDO ke database.
 * Menggunakan koneksi statis untuk efisiensi.
 * @return PDO
 */
function db(): PDO
{
    // Variabel statis untuk menyimpan objek koneksi agar tidak dibuat berulang kali
    static $pdo; 

    if (!$pdo) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8";
        
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            // Atur mode error untuk melempar exceptions, ini sangat membantu saat debugging
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Jika koneksi gagal, hentikan program dan tampilkan pesan yang jelas
            die("Koneksi ke database gagal: " . $e->getMessage());
        }
    }
    
    return $pdo;
}

// PERBAIKAN FINAL: Kurung kurawal '}' tambahan yang sebelumnya ada di bawah baris ini telah dihapus.
// Inilah sumber utama dari semua error JSON Anda.