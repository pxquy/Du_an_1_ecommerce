<?php
class Order extends BaseModel
{
    protected $table = 'orders';

    /** Tạo đơn hàng mới */
    public function createOrder($userId, $fullName, $phoneNumber, $address, $total)
    {
        $this->setTable($this->table);
        return $this->insert([
            'userId'       => $userId,
            'fullName'     => $fullName,
            'phoneNumber'  => $phoneNumber,
            'orderAddress' => $address,
            'total'        => $total,
            'status'       => 1, // 1: chờ xử lý
            'paymentStatus' => 0  // 0: chưa thanh toán
        ]);
    }

    /** Thêm sản phẩm vào order_products */
    public function addOrderProduct($orderId, $productId, $variantId, $quantity, $price)
    {
        $this->setTable('order_products');
        return $this->insert([
            'orderId'   => $orderId,
            'productId' => $productId,
            'variantId' => $variantId,
            'quantity'  => $quantity,
            'price'     => $price,
            'total'     => $price * $quantity
        ]);
    }
}
