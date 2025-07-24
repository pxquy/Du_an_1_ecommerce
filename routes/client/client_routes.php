<?php
// require_once("./client/controller/client/product-controller/products.php");
$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProductController)->home(),
    'productDetail' => (new ProductController())->productDetail(),
};
