<?php
const DB_HOST = 'localhost';    // DB Server IP Address
const DB_NAME = 'toko';         // Database Name
const DB_USER = 'ppkpi_edo';      // Database User
const DB_PASS = 'ppkpiwp12345';      // Database Password

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
