<?php

require_once __DIR__ . "/model/product.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID sản phẩm không hợp lệ.");
}

$product = getProductById($id);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {

        $error = "Tên sản phẩm không được rỗng.";

    } elseif (!is_numeric($price) || $price <= 0) {

        $error = "Giá phải lớn hơn 0.";

    } elseif (!is_numeric($quantity) || $quantity < 0) {

        $error = "Số lượng phải lớn hơn hoặc bằng 0.";

    } else {

        if (updateProduct($id, $name, $price, $quantity)) {

            header("Location: product_list.php");
            exit;

        } else {

            $error = "Cập nhật sản phẩm thất bại.";
        }
    }
}

require_once __DIR__ . "/view/product/edit.php";