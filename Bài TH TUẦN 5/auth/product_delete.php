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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (deleteProduct($id)) {
        header('Location: product_list.php');
        exit;
    }
    $error = 'Xóa sản phẩm thất bại.';
}

require_once __DIR__ . '/view/header.php';
?>
<h1>XÁC NHẬN XÓA SẢN PHẨM</h1>
<?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<p>Bạn có chắc muốn xóa sản phẩm <strong><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></strong>?</p>
<form method="POST" action="product_delete.php?id=<?= (int)$id ?>">
    <button type="submit">Xác nhận xóa</button>
    <a href="product_list.php">Hủy</a>
</form>
<?php require_once __DIR__ . '/view/footer.php'; ?>
