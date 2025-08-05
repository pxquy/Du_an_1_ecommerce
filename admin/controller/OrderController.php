<?php
class OrderController
{
    private $order;
    private $orderProduct;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderProduct = new OrderProduct();
    }

    // Danh sách đơn hàng
    public function index()
    {
        $title = 'Danh sách đơn hàng';
        $view = 'orders/index';

        // Lấy danh sách đơn hàng có join với fullname từ bảng users
        $orders = $this->order->getOrderList();

        require_once PATH_VIEW_ADMIN_MAIN;
    }


    // Xem chi tiết đơn hàng
    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['msg'] = 'Thiếu ID đơn hàng!';
            $_SESSION['success'] = false;
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit;
        }

        $products = $this->order->getOrderDetail($id);
        if (!$products || count($products) == 0) {
            $_SESSION['msg'] = 'Không tìm thấy đơn hàng!';
            $_SESSION['success'] = false;
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit;
        }

        debug($products);
        $order = $products[0]; // lấy thông tin đơn từ bản ghi đầu tiên

        $title = 'Chi tiết đơn hàng';
        $view = 'orders/show';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Phương thức không hợp lệ']);
            return;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !in_array($status, ['pending', 'processing', 'completed', 'cancelled'])) {
            echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
            return;
        }

        $this->order->update([
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        ], 'id = :id', ['id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công.']);
    }

    // Xóa mềm đơn hàng
    public function softDelete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['msg'] = 'Thiếu ID đơn hàng!';
            $_SESSION['success'] = false;
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit;
        }

        $this->order->update([
            'deletedAt' => date('Y-m-d H:i:s')
        ], 'id = :id', ['id' => $id]);

        $_SESSION['msg'] = 'Xoá đơn hàng thành công.';
        $_SESSION['success'] = true;
        header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
        exit;
    }
}