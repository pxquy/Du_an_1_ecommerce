<?php
// require_once("./client/controller/client/product-controller/products.php");
$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProductController)->home(), //lấy dữ liệu tất cả sản phẩm
    'productDetail' => (new ProductController())->productDetail(), //chi tiết sản phẩm
    'signup' => (new SignupController())->locationCreate(), //chuyển hướng đến form đăng kí
    'createUser' => (new SignupController())->createUser(), // validate và nạp dữ liệu người dùng đăng kí lên database
    'signin' => (new SigninController())->signin(), //form dăng nhập
};
