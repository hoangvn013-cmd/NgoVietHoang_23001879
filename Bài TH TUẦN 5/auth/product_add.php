<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$error = '';
$formData = ['name' => '', 'price' => '', 'quantity' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name' => trim($_POST['name'] ?? ''),
        'price' => trim((string)($_POST['price'] ?? '')),
        'quantity' => trim((string)($_POST['quantity'] ?? '')),
    ];

    if ($formData['name'] === '') {
        $error = 'Tên sản phẩm không được để trống.';
    } elseif ($formData['price'] === '' || !is_numeric($formData['price']) || (float)$formData['price'] <= 0) {
        $error = 'Giá phải là số lớn hơn 0.';
    } elseif ($formData['quantity'] === '' || !preg_match('/^\d+$/', $formData['quantity'])) {
        $error = 'Số lượng phải là số nguyên không âm.';
    } else {
        if (addProduct($formData['name'], (float)$formData['price'], (int)$formData['quantity'])) {
            header('Location: product_list.php');
            exit;
        }
        $error = 'Thêm sản phẩm thất bại.';
    }
}

require_once __DIR__ . '/view/header.php';
require_once __DIR__ . '/view/product/add.php';
require_once __DIR__ . '/view/footer.php';
