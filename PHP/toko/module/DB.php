<?php

namespace module;

class DB
{
    private static $pdo;

    public static function connect()
    {
        $db_host = 'localhost';     // DB Server IP Address
        $db_name = 'toko';          // Database Name
        $db_user = 'ppkpi_edo';       // Database User
        $db_pass = 'ppkpiwp12345';       // Database Password
        $dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=UTF8";

        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            // Cek jika koneksi belum ada, baru buat koneksi
            if (!self::$pdo) {
                self::$pdo = new \PDO($dsn, $db_user, $db_pass, $opt);
            }
        } catch (\PDOException $e) {
            die("Koneksi gagal : " . $e->getMessage());
        }

        // TAMBAHKAN BARIS INI: Mengembalikan objek koneksi
        return self::$pdo;
    }

    public static function query($sql, $params = [])
    {
        // Panggil connect() untuk memastikan $pdo sudah terisi
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}