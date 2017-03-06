<?php

// Auto load classes
spl_autoload_register(function ($class) {
    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    include_once $file;
});

// Controller for demonstration xml to json conversion
(new \controller\StartController)->init();