<?php
// require_once("./client/controller/client/product-controller/products.php");
// require_once './client/controller/CartController.php';
$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProductController)->home(), //lấy dữ liệu tất cả sản phẩm
    'product_detail' => (new ProductController())->productDetail(), //chi tiết sản phẩm
    'signup' => (new SignupController())->locationCreate(), //chuyển hướng đến form đăng kí
    'create_user' => (new SignupController())->createUser(), // validate và nạp dữ liệu người dùng đăng kí lên database
    'form_signin' => (new SigninController())->locationSignin(), //chuyển hướng form dăng nhập
    'signin' => (new SigninController())->signin(), //dăng nhập
    'logout' => (new SigninController())->logout(), //đăng xuất
    'add_to_cart' => (new CartController())->addToCart(), //Thêm vào giỏ hàng
    'my_cart' => (new CartController())->myCart(), //Xe,m giỏ hàng
    'delete_cart' => (new CartController())->removeFromCart(),
    'categories' => (new CategoryController())->listCategory(), //Danh mục sản phẩm
    'create_order' => (new OrderController())->createOrder(), //Hiển thị form tạo đơn hàng
    'store_order' => (new OrderController())->storeOrder(), //tạo đơn hàng
    'add_comment' => (new CommentController())->addComment(), //đánh giá sản phẩm

};
