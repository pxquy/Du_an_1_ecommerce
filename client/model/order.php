<?php
class Order extends BaseModel
{
    protected $table = 'orders';

    /**
     * Tạo đơn hàng mới
     * @param string $paymentMethod - 'cod' hoặc 'vnpay'
     */
    public function createOrder($userId, $fullName, $phoneNumber, $address, $total, $paymentMethod = 'cod')
    {
        $this->setTable($this->table);
        return $this->insert([
            'userId'        => $userId,
            'fullName'      => $fullName,
            'phoneNumber'   => $phoneNumber,
            'orderAddress'  => $address,
            'total'         => $total,
            'paymentMethod' => $paymentMethod,
            'status'        => 1, // Chờ xác nhận
            'paymentStatus' => 0, // Chưa thanh toán
            'createdAt'     => date('Y-m-d H:i:s'),
            'updatedAt'     => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Thêm sản phẩm vào bảng order_products
     */
    public function addOrderProduct($orderId, $productId, $variantId, $quantity, $price)
    {
        $this->setTable('order_products');
        return $this->insert([
            'orderId'   => $orderId,
            'productId' => $productId,
            'variantId' => $variantId,
            'quantity'  => $quantity,
            'price'     => $price,
            'total'     => $price * $quantity,
        ]);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     * @param int $status - 1: Chờ xác nhận, 2: Đã xác nhận,...
     * @param int $paymentStatus - 0: Chưa thanh toán, 1: Đã thanh toán
     */
    public function updateStatus($orderId, $status = 4, $paymentStatus = 0)
    {
        $this->setTable($this->table);
        return $this->update([
            'status'        => $status,
            'paymentStatus' => $paymentStatus,
            'updatedAt'     => date('Y-m-d H:i:s'),
        ], 'id = :id', ['id' => $orderId]);
    }

    /**
     * Lấy danh sách đơn hàng theo người dùng
     */
    public function getOrdersByUser($userId)
    {
        $this->setTable($this->table);
        return $this->select('*', 'userId = :userId ORDER BY createdAt DESC', ['userId' => $userId]);
    }

    /**
     * Lấy chi tiết sản phẩm trong đơn hàng
     */
    public function getOrderProducts($orderId)
    {
        $sql = "
            SELECT op.*, p.title, p.thumbnail, v.sku
            FROM order_products op
            JOIN products p ON op.productId = p.id
            JOIN variants v ON op.variantId = v.id
            WHERE op.orderId = :orderId
        ";
        return $this->selectRaw($sql, ['orderId' => $orderId]);
    }
    //lấy tất cả đơn hàng
    public function getOrdersWithDetailsByUser($userId)
    {
        $sql = "
            SELECT 
                o.id AS orderId,
                o.status,
                o.createdAt AS orderDate,
                op.productId,
                op.variantId,
                op.quantity,
                op.price,
                p.title AS productTitle,
                (
                    SELECT GROUP_CONCAT(CONCAT(a.name, ': ', av.value) SEPARATOR ', ')
                    FROM variant_values vv
                    JOIN attribute_values av ON vv.valueId = av.id
                    JOIN attributes a ON av.attributeId = a.id
                    WHERE vv.variantId = op.variantId
                ) AS attributes
            FROM orders o
            JOIN order_products op ON o.id = op.orderId
            JOIN products p ON op.productId = p.id
            WHERE o.userId = :userId
            ORDER BY o.createdAt DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //chức năng huỷ đơn hàng
    public function cancelOrder($orderId, $userId)
    {
        // Chỉ huỷ khi đơn thuộc user đó và status = 1 hoặc 2
        $sql = "UPDATE orders
            SET status = '5'
            WHERE id = :orderId AND userId = :userId AND status IN (1, 2)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':orderId' => $orderId,
            ':userId' => $userId
        ]);

        return $stmt->rowCount() > 0;
    }
    //lịch sử mua hàng
    public function getReceivedOrdersByUser($userId)
    {
        $sql = "
        SELECT 
            o.id AS orderId,
            o.status,
            o.createdAt AS orderDate,
            op.productId,
            op.variantId,
            op.quantity,
            op.price,
            p.title AS productTitle,
            (
                SELECT GROUP_CONCAT(CONCAT(a.name, ': ', av.value) SEPARATOR ', ')
                FROM variant_values vv
                JOIN attribute_values av ON vv.valueId = av.id
                JOIN attributes a ON av.attributeId = a.id
                WHERE vv.variantId = op.variantId
            ) AS attributes
        FROM orders o
        JOIN order_products op ON o.id = op.orderId
        JOIN products p ON op.productId = p.id
        WHERE o.userId = :userId AND o.status = '5'
        ORDER BY o.createdAt DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOrderById($orderId)
    {
        $sql = "
        SELECT o.*, u.fullname, u.email, u.phone_number, u.address 
        FROM orders o
        JOIN users u ON o.userId = u.id
        WHERE o.id = :orderId
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getOrderDetails($orderId)
    {
        $sql = "
        SELECT op.*, p.title
        FROM order_products AS op
        JOIN products AS p ON op.productId = p.id
        WHERE op.orderId = ?
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrderVnPay($userId, $fullName, $phoneNumber, $address, $total)
    {
        $this->setTable($this->table);
        return $this->insert([
            'userId'        => $userId,
            'fullName'      => $fullName,
            'phoneNumber'   => $phoneNumber,
            'orderAddress'  => $address,
            'total'         => $total,
            'paymentMethod' => 'vnpay',
            'status'        => 2,
            'paymentStatus' => 1,
            'createdAt'     => date('Y-m-d H:i:s'),
            'updatedAt'     => date('Y-m-d H:i:s'),
        ]);
    }
    // public function updateStatusOrder($orderId, $userId, $newStatus)
    // {
    //     $sql = "UPDATE orders SET status = :status WHERE id = :id AND userId = :userId";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->bindValue(':status', (int)$newStatus, PDO::PARAM_INT);
    //     $stmt->bindValue(':id', (int)$orderId, PDO::PARAM_INT);
    //     $stmt->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }
}
