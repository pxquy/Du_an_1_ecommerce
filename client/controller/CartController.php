<?php
require_once './client/model/Cart.php';

class CartController
{
    protected $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    /** Thêm sản phẩm vào giỏ hàng */
    public function addToCart()
    {
        require_Login();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'] ?? null;
            $productId = $_POST['productId'] ?? null;
            $variantId = $_POST['variantId'] ?? null;
            $quantity = max(1, intval($_POST['quantity'] ?? 1));
            $price = floatval($_POST['price'] ?? 0);

            if (!$userId || !$productId || !$variantId) {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = 'Dữ liệu không hợp lệ';
                header('Location:' . BASE_URL . ' ?action=product_detail');
                exit();
            }

            // Lấy giỏ hàng hoặc tạo mới
            $cart = $this->cartModel->getCartByUser($userId);
            $cartId = $cart['id'] ?? $this->cartModel->createCart($userId);

            // Thêm sản phẩm vào giỏ
            $this->cartModel->addProduct($cartId, $productId, $variantId, $quantity, $price);

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã thêm vào giỏ hàng';
            header('Location:' . BASE_URL . '?action=my_cart');
            exit();
        }
    }

    /** Hiển thị giỏ hàng */
    public function myCart()
    {
        $view = "cart";
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location:' . BASE_URL . ' ?action=form_signin');
            exit();
        }

        $cartItems = $this->cartModel->getCartDetails($userId);
        // debug($cartItems);
        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
    public function removeFromCart()
    {

        require_Login();
        $cartProductId = $_GET['cartProductId'] ?? null;
        $cartId = $_GET['cartId'] ?? null;

        if ($cartProductId && $cartId) {
            $this->cartModel->removeProduct((int) $cartProductId, (int) $cartId);
            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        } else {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = 'Dữ liệu không hợp lệ';
        }

        header('Location:' . BASE_URL . '?action=my_cart');
        exit();
    }
}
