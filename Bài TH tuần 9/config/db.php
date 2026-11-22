<?php
// Sửa lại thông tin kết nối cho đúng với máy của bạn
$pdo = new PDO(
    'mysql:host=localhost;dbname=product_db;charset=utf8mb4',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
