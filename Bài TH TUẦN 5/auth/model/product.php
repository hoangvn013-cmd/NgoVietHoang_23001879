<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts(): array
{
    global $conn;
    $stmt = $conn->query('SELECT * FROM products ORDER BY id DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById(int $id): array|false
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addProduct(string $name, float $price, int $quantity): bool
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $price, $quantity]);
}

function updateProduct(int $id, string $name, float $price, int $quantity): bool
{
    global $conn;
    $stmt = $conn->prepare('UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?');
    return $stmt->execute([$name, $price, $quantity, $id]);
}

function deleteProduct(int $id): bool
{
    global $conn;
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    return $stmt->execute([$id]);
}
