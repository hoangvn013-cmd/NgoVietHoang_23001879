<?php
require_once __DIR__ . "/model/product.php";

$products = getAllProducts();

require_once __DIR__ . "/view/header.php";
require_once __DIR__ . "/view/product/list.php";
require_once __DIR__ . "/view/footer.php";