<h1>DANH SÁCH SẢN PHẨM</h1>
<p><a class="btn" href="product_add.php">Thêm sản phẩm</a></p>

<table>
    <thead>
        <tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
    <?php if (empty($products)): ?>
        <tr><td colspan="5">Chưa có sản phẩm.</td></tr>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= (int)$product['id'] ?></td>
                <td><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= number_format((float)$product['price'], 2) ?></td>
                <td><?= (int)$product['quantity'] ?></td>
                <td>
                    <a href="product_edit.php?id=<?= (int)$product['id'] ?>">Sửa</a> |
                    <form class="inline-form" method="POST" action="product_delete.php?id=<?= (int)$product['id'] ?>" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                        <button type="submit" class="link-button">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
