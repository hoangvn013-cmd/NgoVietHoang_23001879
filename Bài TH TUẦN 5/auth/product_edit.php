<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    die('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);
if (!$product) {
    http_response_code(404);
    die('Sản phẩm không tồn tại.');
}

$error = '';
$formData = [
    'name' => (string)$product['name'],
    'price' => (string)$product['price'],
    'quantity' => (string)$product['quantity'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Keep submitted values when validation fails, instead of reverting to DB values.
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
        if (updateProduct($id, $formData['name'], (float)$formData['price'], (int)$formData['quantity'])) {
            header('Location: product_list.php');
            exit;
        }
        $error = 'Cập nhật sản phẩm thất bại.';
    }
}

require_once __DIR__ . '/view/header.php';
require_once __DIR__ . '/view/product/edit.php';
require_once __DIR__ . '/view/footer.php';
