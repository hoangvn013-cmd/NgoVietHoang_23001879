<?php
require_once __DIR__ . '/common/auth.php';
header('Location: ' . (isLoggedIn() ? 'product_list.php' : 'login.php'));
exit;
