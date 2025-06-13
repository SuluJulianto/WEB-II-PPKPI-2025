<?php
const DB_HOST = 'localhost'; //db server IP Address
const DB_NAME = 'toko'; //DB Name
const DB_USER = 'ppkpi_edo'; // Root User
const DB_PASS = 'ppkpiwp12345'; //Root Password

function db(): PDO
{
    static $pdo;
    if (!$pdo) {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset-UTF8";
        $pdo = new PDO($dsn,DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
    }
    return $pdo;
}