<h1>DANH SÁCH SẢN PHẨM</h1>

<p>
    <a href="product_add.php">Thêm sản phẩm</a>
</p>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thao tác</th>
    </tr>

    <?php if (empty($products)): ?>

        <tr>
            <td colspan="5">Chưa có sản phẩm.</td>
        </tr>

    <?php else: ?>

        <?php foreach ($products as $product): ?>

            <tr>
                <td><?= (int)$product['id'] ?></td>

                <td>
                    <?= htmlspecialchars($product['name']) ?>
                </td>

                <td>
                    <?= number_format((float)$product['price'], 2) ?>
                </td>

                <td>
                    <?= (int)$product['quantity'] ?>
                </td>

                <td>
                    <a href="product_edit.php?id=<?= (int)$product['id'] ?>">
                        Sửa
                    </a>

                    |

                    <a
                        href="product_delete.php?id=<?= (int)$product['id'] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')"
                    >
                        Xóa
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    <?php endif; ?>

</table>