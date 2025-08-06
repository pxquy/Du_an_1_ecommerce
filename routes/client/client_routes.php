<?php
// Nạp các controller cần thiết
require_once './client/controller/ProductController.php';
require_once './client/controller/CartController.php';
require_once './client/controller/SignupController.php';
require_once './client/controller/SigninController.php';
require_once './client/controller/CategoryController.php';
require_once './client/controller/OrderController.php';
require_once './client/controller/CommentController.php';
require_once './helper/format-helper.php';

// Nếu không có ?action thì mặc định là 'home'
$action = $_GET['action'] ?? 'home';

match ($action) {
    'home' => (new ProductController())->home(), // Trang chủ: danh sách sản phẩm
    'product_detail' => (new ProductController())->productDetail(), // Chi tiết sản phẩm

    'signup' => (new SignupController())->locationCreate(), // Form đăng ký
    'create_user' => (new SignupController())->createUser(), // Xử lý đăng ký

    'form_signin' => (new SigninController())->locationSignin(), // Form đăng nhập
    'signin' => (new SigninController())->signin(), // Xử lý đăng nhập
    'logout' => (new SigninController())->logout(), // Đăng xuất

    'add_to_cart' => (new CartController())->addToCart(), // Thêm giỏ hàng
    'my_cart' => (new CartController())->myCart(), // Hiển thị giỏ hàng
    'delete_cart' => (new CartController())->removeFromCart(), // Xóa khỏi giỏ

    'categories' => (new CategoryController())->listCategory(), // Danh mục sản phẩm

    'create_order' => (new OrderController())->createOrder(), // Form tạo đơn hàng
    'store_order' => (new OrderController())->storeOrder(), // Lưu đơn hàng

    'add_comment' => (new CommentController())->addComment(), // Thêm đánh giá

    default => http_response_code(404), // Nếu không khớp, trả về 404
};
