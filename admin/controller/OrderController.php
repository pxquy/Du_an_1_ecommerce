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
        if (!empty($_GET['ajax'])) {
            $filters = [
                'status' => $_GET['status'] ?? '',
                'keyword' => trim($_GET['keyword'] ?? ''),
                'sort' => $_GET['sort'] ?? 'newest',
            ];
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $perPage = max(1, (int) ($_GET['perPage'] ?? 10));

            $rows = $this->order->getOrderPage($filters, $page, $perPage);
            $total = $rows ? (int) $rows[0]['total_rows'] : 0;

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'data' => $rows,
                'meta' => [
                    'page' => $page,
                    'perPage' => $perPage,
                    'total' => $total,
                    'totalPage' => $perPage ? (int) ceil($total / $perPage) : 1,
                ],
            ]);
            exit;
        }

        $title = 'Danh sách đơn hàng';
        $view = 'orders/index';
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
        // debug($products);
        if (!$products || count($products) == 0) {
            $_SESSION['msg'] = 'Không tìm thấy đơn hàng!';
            $_SESSION['success'] = false;
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit;
        }


        $order = $products[0]; // lấy thông tin đơn từ bản ghi đầu tiên

        $title = 'Chi tiết đơn hàng';
        $view = 'orders/show';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ');
            }

            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$id || !$status) {
                throw new Exception('Thiếu ID hoặc trạng thái');
            }

            $res = $this->order->update([
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            ], 'id = :id', ['id' => $id]);

            if ($res) {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit;
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Cập nhật trạng thái đơn hàng thành công.';
            } else {
                throw new Exception('Không thể cập nhật trạng thái');
            }
        } catch (\Throwable $th) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'msg' => $th->getMessage()]);
                exit;
            }

            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
        exit;
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
            'status' => 5
        ], 'id = :id', ['id' => $id]);

        $_SESSION['msg'] = 'Hủy đơn hàng thành công.';
        $_SESSION['success'] = true;
        header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
        exit;
    }
}