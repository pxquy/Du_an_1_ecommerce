<?php
require_once './client/model/Order.php';
require_once './client/model/Cart.php';

// define('VNP_TMNCODE', 'BMTODY6W');
// define('VNP_HASHSECRET', 'VDGZ2CTXA8ABHRAV0RXD276DR2C9HUAZ');
// define('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
// define('VNP_RETURN_URL', BASE_URL . '?action=vnpay_return');

class OrderController
{
    protected $orderModel;
    protected $cartModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
    }

    /** Hiển thị form tạo đơn hàng từ giỏ hàng */
    public function createOrder()
    {
        require_Login();
        $userId = $_SESSION['user']['id'];
        $user = $_SESSION['user'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['selected'])) {
            $selected = $_POST['selected'];
            $cartItems = $this->cartModel->getCartDetails($userId);
            $selectedItems = array_filter($cartItems, fn($item) => in_array($item['cartProductId'], $selected));

            if (empty($selectedItems)) {
                $_SESSION['error_message'] = 'Vui lòng chọn sản phẩm hợp lệ để đặt hàng';
                header('Location: ?action=my_cart');
                exit;
            }

            $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $selectedItems));

            $view = 'pages/site/checkout/checkout';
            $title = "Xác thực thanh toán";
            require_once PATH_VIEW_CLIENT . $view . '.php';
        } else {
            $_SESSION['error_message'] = 'Vui lòng chọn ít nhất 1 sản phẩm để đặt hàng';
            header('Location: ?action=my_cart');
            exit;
        }
    }

    /** Đặt hàng với ship COD */
    public function storeOrder()
    {
        require_Login();
        $userId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['fullName'];
            $phone = $_POST['phoneNumber'];
            $address = $_POST['orderAddress'];
            $total = $_POST['amount'];
            $items = json_decode($_POST['items'], true);

            // 1. Tạo đơn hàng
            $orderId = $this->orderModel->createOrder(
                $userId,
                $fullName,
                $phone,
                $address,
                $total,
                'cod'
            );

            // 2. Thêm sản phẩm vào đơn hàng
            foreach ($items as $item) {
                $this->orderModel->addOrderProduct(
                    $orderId,
                    $item['productId'],
                    $item['variantId'],
                    $item['quantity'],
                    $item['price']
                );
                // Xoá khỏi giỏ hàng
                $this->cartModel->removeProduct(
                    $item['cartProductId'],
                    $item['cartId']
                );
            }

            // 3. Lấy lại thông tin đơn hàng và chi tiết
            $order = $this->orderModel->getOrderById($orderId);
            $listOrderDetail = $this->orderModel->getOrderDetails($orderId);

            // 4. Load view với dữ liệu
            $view = 'pages/site/order-complete/order-complete';
            $title = "Xác thực đơn hàng";
            require_once PATH_VIEW_CLIENT . $view . '.php';
        }
    }


    /** Thanh toán online qua VNPay */
    public function confirm_vnpay()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $_SESSION['vnpay_order'] = [
            'userId'       => $_SESSION['user']['id'],
            'fullName'     => $_POST['fullName'],
            'phoneNumber'  => $_POST['phoneNumber'],
            'orderAddress' => $_POST['orderAddress'],
            'total'        => $_POST['amount'],
            'items'        => json_decode($_POST['items'], true)
        ];

        $tongtien = $_POST['amount'];
        $vnp_TmnCode = "BMTODY6W";
        $vnp_HashSecret = "VDGZ2CTXA8ABHRAV0RXD276DR2C9HUAZ";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = BASE_URL . "?action=vnpay_post";
        $vnp_apiUrl = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        //thanh toan bang vnpay
        $vnp_TxnRef = time() . "";
        $vnp_OrderInfo = 'Thanh toán đơn hàng đặt tại web';
        $vnp_OrderType = 'billpayment';

        $vnp_Amount = $tongtien * 100;
        // debug($vnp_Amount);
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $vnp_ExpireDate = $expire;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate

        );


        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            print_r($returnData);
        }
    }




    /** Xử lý callback từ VNPay */
    public function vnpayReturn()
    {
        $vnp_HashSecret = "VDGZ2CTXA8ABHRAV0RXD276DR2C9HUAZ";

        $inputData = [];
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashDataArr = [];
        foreach ($inputData as $key => $value) {
            $hashDataArr[] = urlencode($key) . "=" . urlencode($value);
        }
        $hashData = implode('&', $hashDataArr);

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $orderId = null;

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $orderInfo = $_SESSION['vnpay_order'] ?? null;
                if ($orderInfo) {
                    $orderId = $this->orderModel->createOrderVnPay(
                        $orderInfo['userId'],
                        $orderInfo['fullName'],
                        $orderInfo['phoneNumber'],
                        $orderInfo['orderAddress'],
                        $orderInfo['total']
                    );
                    foreach ($orderInfo['items'] as $item) {
                        $this->orderModel->addOrderProduct(
                            $orderId,
                            $item['productId'],
                            $item['variantId'],
                            $item['quantity'],
                            $item['price']
                        );
                        $this->cartModel->removeProduct($item['cartProductId'], $item['cartId']);
                    }

                    unset($_SESSION['vnpay_order']);
                    $_SESSION['success'] = true;
                    $_SESSION['msg'] = "Thanh toán VNPay thành công! Mã đơn #$orderId";

                    // Hiển thị trang xác nhận đơn hàng
                    $order = $this->orderModel->getOrderById($orderId);
                    $listOrderDetail = $this->orderModel->getOrderDetails($orderId);

                    $view = 'pages/site/order-complete/order-complete';
                    $title = "Xác thực đơn hàng";
                    require_once PATH_VIEW_CLIENT . $view . '.php';
                    return;
                }
            } else {
                // Trường hợp thất bại hoặc hủy
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Thanh toán VNPay thất bại! Mã lỗi: " . $inputData['vnp_ResponseCode'];
            }
        } else {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = "Sai chữ ký bảo mật từ VNPay!";
        }

        // Nếu thất bại hoặc hủy thì quay về trang danh sách đơn hàng
        header('Location: ' . BASE_URL . '?action=my_order');
        exit;
    }


    //tất cả đơn hàng
    public function orderHistory()
    {
        if (!isset($_SESSION['user']['id'])) {
            // Nếu chưa đăng nhập thì chuyển về đăng nhập
            header('Location: ' . BASE_URL . '?action=signin');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getOrdersWithDetailsByUser($userId);

        $view = 'pages/site/order-complete/order-complete';
        $title = "Lịch sử đơn hàng";
        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
    public function cancelOrder()
    {
        require_Login();

        $userId = $_SESSION['user']['id'];
        $orderId = $_GET['id'] ?? null;

        if ($orderId && $this->orderModel->cancelOrder($orderId, $userId)) {
            $_SESSION['success_message'] = "Huỷ đơn hàng thành công.";
        } else {
            $_SESSION['error_message'] = "Không thể huỷ đơn hàng này.";
        }

        header('Location: ' . BASE_URL . '?action=my_order');
        exit;
    }
    //lịch sử đã mua hàng
    public function receivedOrders()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: ' . BASE_URL . '?action=signin');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getReceivedOrdersByUser($userId);

        $view = 'receivedOrders';
        require_once PATH_VIEW_CLIENT . $view . '.php';
    }

    public function userOrderDetail()
    {

        $orderId = isset($_GET["orderId"]) ? $_GET["orderId"] : null;
        $listOrderDetail = $this->orderModel->getOrderDetails($orderId);
        $order = $this->orderModel->getOrderById($orderId);

        $view = "pages/user/order-detail/order-detail";
        $title = "Chi tiết đơn hàng";
        require PATH_VIEW_CLIENT . $view . ".php";
    }
}
