<?php
    if (!isset($_SESSION)){
        session_start();
    }
if (!isset($_SESSION["dir_root"])){
    require_once 'boostrap.php';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="tabel.php">Tabel</a>
</body>
</html>
