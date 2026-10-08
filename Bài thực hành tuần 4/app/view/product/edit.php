<h1>SỬA SẢN PHẨM</h1>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="product_edit.php?id=<?= (int)$product['id'] ?>">

    <label>Tên sản phẩm</label>

    <input
        type="text"
        name="name"
        value="<?= htmlspecialchars($product['name']) ?>"
        required
    >

    <label>Giá</label>

    <input
        type="number"
        name="price"
        min="0.01"
        step="0.01"
        value="<?= htmlspecialchars($product['price']) ?>"
        required
    >

    <label>Số lượng</label>

    <input
        type="number"
        name="quantity"
        min="0"
        value="<?= htmlspecialchars($product['quantity']) ?>"
        required
    >

    <button type="submit">
        Cập nhật
    </button>

    <a href="product_list.php">
        Quay lại
    </a>

</form>