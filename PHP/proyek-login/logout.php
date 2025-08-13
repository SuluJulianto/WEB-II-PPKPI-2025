<?php

require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    try {
        $pdo = db();

        $stmt = $pdo->prepare("UPDATE users SET status = 'offline' WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
    } catch (PDOException $e) {
    }
}

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>