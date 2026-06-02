<?php

spl_autoload_register(function ($class) {
    $dirs = ['helpers', 'controller', 'model', 'config'];
    foreach ($dirs as $dir) {
        $file = __DIR__ . "/../$dir/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

spl_autoload_register(function ($class) {
    if (strpos($class, 'Mustache') === 0) {
        // Saca el prefijo "Mustache\" y busca directo en src/
        $relative = str_replace('Mustache\\', '', $class);
        $relative = str_replace('\\', '/', $relative);
        $file = __DIR__ . '/../vendor/mustache/src/' . $relative . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});