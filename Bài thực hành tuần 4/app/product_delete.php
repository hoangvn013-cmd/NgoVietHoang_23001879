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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (deleteProduct($id)) {
        header("Location: product_list.php");
        exit;
    }

    die("Xóa sản phẩm thất bại.");
}

require_once __DIR__ . "/view/header.php";
?>

<h2>Xác nhận xóa sản phẩm</h2>

<p>
    Bạn có chắc muốn xóa sản phẩm
    <strong><?= htmlspecialchars($product['name']) ?></strong>?
</p>

<form method="POST" action="product_delete.php?id=<?= (int)$id ?>">

    <button type="submit">
        Xác nhận xóa
    </button>

    <a href="product_list.php">
        Hủy
    </a>

</form>

<?php
require_once __DIR__ . "/view/footer.php";
?>