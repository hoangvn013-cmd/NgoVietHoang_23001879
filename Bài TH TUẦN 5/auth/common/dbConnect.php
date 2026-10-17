<?php
$host = 'localhost';
$dbname = 'shopping_cart';
$username = 'root';
$password = '';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Avoid exposing connection details to end users in production.
    die('Kết nối database thất bại. Hãy kiểm tra cấu hình MySQL.');
}
