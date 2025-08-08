<?php
require_once './client/model/Order.php';
require_once './client/model/Cart.php';

class OrderController
{
    protected $orderModel;
    protected $cartModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->cartModel  = new Cart();
    }

    /** Hiển thị form tạo đơn hàng từ giỏ hàng */
    public function createOrder()
    {
        require_Login();
        $user = $_SESSION['user'];
        $userId = $_SESSION['user']['id'];
        // debug($user);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['selected'])) {
            $selected = $_POST['selected'];
            $cartItems = $this->cartModel->getCartDetails($userId);

            $selectedItems = array_filter($cartItems, fn($item) => in_array($item['cartProductId'], $selected));

            if (empty($selectedItems)) {
                $_SESSION['msg'] = 'Vui lòng chọn sản phẩm hợp lệ để đặt hàng';
                header('Location: ?action=my_cart');
                exit;
            }

            $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $selectedItems));
            $view = 'pages/site/checkout/checkout';
            $title = "Xác thực thanh toán";
            require_once PATH_VIEW_CLIENT . $view . '.php';
        } else {
            $_SESSION['msg'] = 'Vui lòng chọn ít nhất 1 sản phẩm để đặt hàng';
            header('Location: ?action=my_cart');
            exit;
        }
    }

    public function storeOrder()
    {
        require_Login();
        $userId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName    = $_POST['fullName'];
            $phoneNumber = $_POST['phoneNumber'];
            $address     = $_POST['orderAddress'];
            $total       = $_POST['total'];
            $items       = json_decode($_POST['items'], true);

            $orderId = $this->orderModel->createOrder($userId, $fullName, $phoneNumber, $address, $total);

            foreach ($items as $item) {
                $this->orderModel->addOrderProduct(
                    $orderId,
                    $item['productId'],
                    $item['variantId'],
                    $item['quantity'],
                    $item['price']
                );

                $this->cartModel->removeProduct($item['cartProductId'], $item['cartId']);
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đặt hàng thành công!';
?>
            <script>
                alert("Đặt hàng thành công");
            </script>
<?php
            header('Location: ?action=my_cart');
            exit();
        }
    }
}
