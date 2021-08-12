<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=web_prog', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit($e->getMessage());
};

session_start();