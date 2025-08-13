<?php
// Class Autoloader

spl_autoload_register(function ($class) {
    $base_dir = __DIR__;
    $class = str_replace('\\', '/', $class);

    $path = $base_dir . '/' . $class . '.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        die("Class tidak ditemukan: $class => $path");
    }
});