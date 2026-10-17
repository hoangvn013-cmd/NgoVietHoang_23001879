<h1>ĐĂNG NHẬP</h1>

<?php if ($success !== ''): ?>
    <p class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<?php if ($error !== ''): ?>
    <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label for="username">Tên đăng nhập</label>
    <input id="username" type="text" name="username" maxlength="50" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="password">Mật khẩu</label>
    <input id="password" type="password" name="password" required>

    <button type="submit">Đăng nhập</button>
    <a href="register.php">Chưa có tài khoản? Đăng ký</a>
</form>
