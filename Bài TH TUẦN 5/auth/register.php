<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Tên đăng nhập và mật khẩu không được để trống.';
    } elseif (mb_strlen($username) > 50) {
        $error = 'Tên đăng nhập tối đa 50 ký tự.';
    } elseif (usernameExists($username)) {
        $error = 'Tên đăng nhập đã tồn tại.';
    } elseif (createUser($username, $password)) {
        header('Location: login.php?registered=1');
        exit;
    } else {
        $error = 'Đăng ký thất bại.';
    }
}

require_once __DIR__ . '/view/header.php';
require_once __DIR__ . '/view/user/register.php';
require_once __DIR__ . '/view/footer.php';
