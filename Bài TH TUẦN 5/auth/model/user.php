<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername(string $username): array|false
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function usernameExists(string $username): bool
{
    return getUserByUsername($username) !== false;
}

function createUser(string $username, string $password): bool
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    return $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
}
