<?php
// require_once("./client/controller/client/product-controller/products.php");
// require_once './client/controller/CartController.php';
require_once "./client/controller/SignupController.php";
require_once "./client/controller/SigninController.php";
require_once "./client/controller/UserController.php";
require_once "./client/controller/CartController.php";
require_once "./client/controller/CategoryController.php";
require_once "./client/controller/OrderController.php";
require_once "./client/controller/CommentController.php";
require_once "./client/controller/BrandsController.php";
require_once "./client/controller/ProductController.php";
require_once "./helper/format-helper.php";


$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProductController)->home(), //lấy dữ liệu tất cả sản phẩm
    'product-brand' => (new ProductController)->productBrandList(), //lấy dữ liệu tất cả sản phẩm theo brand
    'product_detail' => (new ProductController())->productDetail(), //chi tiết sản phẩm
    'products' => (new ProductController())->getAllProducts(), //tất cả sản phẩm
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
    'order-detail' => (new OrderController())->userOrderDetail(), //Chi tiết đơn hàng
    'pay_vnpay' => (new OrderController())->confirm_vnpay(), // chọn thanh toán qua vnpay
    'vnpay_return' => (new OrderController())->vnpayReturn(), // xử lý logic trả về sau khi thanh toán vnpay
    'vnpay_post' => (new OrderController())->vnpayReturn(), // xử lý logic trả về sau khi thanh toán vnpay
    'add_comment' => (new CommentController())->addComment(), //đánh giá sản phẩm
    'search' => (new ProductController())->search(), // chức năng tìm kiếm sản phẩm
    'products_by_brand' => (new BrandsController())->productsByBrand(), //Lấy sản phẩm theo brand
    'my_order' => (new OrderController())->orderHistory(), //Lấy sản phẩm theo brand
    'cancel_order' => (new OrderController())->cancelOrder(), //huỷ hàng
    'order_success' => (new OrderController())->receivedOrders(), //lịch sử mua hàng
    'userDashboardPage' => (new UserController)->userDashboardPage(), //Trang quản trị của người dùng;
    'userOrderPage' => (new UserController)->userOrderPage(), //Trang đơn hàng của người dùng;
    'update_info' => $_SERVER['REQUEST_METHOD'] === 'POST'
        ? (new UserController())->handleUpdateInfo()
        : (new UserController())->showUpdateInfoForm(),
    'change_password' => $_SERVER['REQUEST_METHOD'] === 'POST'
        ? (new UserController())->handleChangePassword()
        : (new UserController())->showUpdateInfoForm(),
    'form_update_profile' => (new UserController())->showUpdateInfoForm(),
    'form_update_password' => (new UserController())->showUpdateInfoForm(),
    default => require PATH_VIEW_CLIENT . "pages/site/404.php",
};
