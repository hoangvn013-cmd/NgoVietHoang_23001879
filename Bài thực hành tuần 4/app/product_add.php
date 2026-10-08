<?php

require_once __DIR__ . "/model/product.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {
        $error = "Tên sản phẩm không được để trống.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Số lượng phải lớn hơn hoặc bằng 0.";
    } else {

        if (addProduct($name, $price, $quantity)) {
            header("Location: product_list.php");
            exit;
        }

        $error = "Thêm sản phẩm thất bại.";
    }
}

require_once __DIR__ . "/view/product/add.php";