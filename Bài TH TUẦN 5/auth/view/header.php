<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
<?php if (!empty($_SESSION['username'])): ?>
    <div class="user-bar">
        Xin chào, <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong> |
        <a href="logout.php">Đăng xuất</a>
    </div>
<?php endif; ?>
