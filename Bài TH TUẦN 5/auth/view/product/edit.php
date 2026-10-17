<h1>SỬA SẢN PHẨM</h1>

<?php if ($error !== ''): ?>
    <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="POST" action="product_edit.php?id=<?= (int)$product['id'] ?>">
    <label for="name">Tên sản phẩm</label>
    <input id="name" type="text" name="name" value="<?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="price">Giá</label>
    <input id="price" type="number" name="price" min="0.01" step="0.01" value="<?= htmlspecialchars($formData['price'], ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="quantity">Số lượng</label>
    <input id="quantity" type="number" name="quantity" min="0" step="1" value="<?= htmlspecialchars($formData['quantity'], ENT_QUOTES, 'UTF-8') ?>" required>

    <button type="submit">Cập nhật</button>
    <a href="product_list.php">Quay lại</a>
</form>
