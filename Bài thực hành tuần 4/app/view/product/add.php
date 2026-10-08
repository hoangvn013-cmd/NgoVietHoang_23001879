<h1>THÊM SẢN PHẨM</h1>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="product_add.php">

    <p>
        <label>Tên sản phẩm</label>
        <br>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label>Giá</label>
        <br>

        <input
            type="number"
            name="price"
            min="0.01"
            step="0.01"
            value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label>Số lượng</label>
        <br>

        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>"
            required
        >
    </p>

    <button type="submit">
        Thêm sản phẩm
    </button>

    <a href="product_list.php">
        Quay lại
    </a>

</form>