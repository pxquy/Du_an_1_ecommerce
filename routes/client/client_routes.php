<?php
// require_once("./client/controller/client/product-controller/products.php");
$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProductController)->home(), //lấy dữ liệu tất cả sản phẩm
    'product_detail' => (new ProductController())->productDetail(), //chi tiết sản phẩm
    'signup' => (new SignupController())->locationCreate(), //chuyển hướng đến form đăng kí
    'create_user' => (new SignupController())->createUser(), // validate và nạp dữ liệu người dùng đăng kí lên database
    'form_signin' => (new SigninController())->locationSignin(), //chuyển hướng form dăng nhập
    'signin' => (new SigninController())->signin(), //dăng nhập
    'logout' => (new SigninController())->logout(), //đăng xuất

};
