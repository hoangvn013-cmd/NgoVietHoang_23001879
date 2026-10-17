<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$error = '';
$success = isset($_GET['registered']) ? 'Đăng ký thành công. Hãy đăng nhập.' : '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } else {
        $user = getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // chống session fixation
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        }
        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}

require_once __DIR__ . '/view/header.php';
require_once __DIR__ . '/view/user/login.php';
require_once __DIR__ . '/view/footer.php';
