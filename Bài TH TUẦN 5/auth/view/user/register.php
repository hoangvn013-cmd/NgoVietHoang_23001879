<h1>ĐĂNG KÝ</h1>

<?php if ($error !== ''): ?>
    <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="POST" action="register.php">
    <label for="username">Tên đăng nhập</label>
    <input id="username" type="text" name="username" maxlength="50" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="password">Mật khẩu</label>
    <input id="password" type="password" name="password" required>

    <button type="submit">Đăng ký</button>
    <a href="login.php">Đã có tài khoản? Đăng nhập</a>
</form>
