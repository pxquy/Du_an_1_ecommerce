<?php
class Order extends BaseModel
{
    protected $table = 'Orders';

    public function getOrderDetail($id)
    {
        $sql = '
        SELECT 
            o.id AS orderId,
            o.userId,
            u.fullname,
            o.orderAddress,
            o.total,
            o.status,
            o.createdAt,
            o.updatedAt,
            
            op.productId,
            p.title AS productTitle,
            op.variantId,
            op.quantity,
            op.price AS priceEach,

            GROUP_CONCAT(CONCAT(a.description, ": ", av.value) SEPARATOR ", ") AS variantAttributes

        FROM orders o
        JOIN users u ON o.userId = u.id
        JOIN order_products op ON o.id = op.orderId
        JOIN products p ON op.productId = p.id

        LEFT JOIN variants v ON op.variantId = v.id
        LEFT JOIN variant_values vv ON op.variantId = vv.variantId
       
        LEFT JOIN attribute_values av ON vv.valueId = av.id
         LEFT JOIN attributes a ON av.attributeId = a.id

        WHERE o.id = :id AND o.deletedAt IS NULL
        GROUP BY op.id
        ORDER BY o.id ASC
    ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(); // Trả về tất cả sản phẩm của đơn hàng
    }




    public function getOrderList()
    {
        $sql = 'SELECT 
                o.id,
                o.userId,
                u.fullname,
                o.orderAddress,
                o.total,
                o.status,
                o.createdAt,
                o.updatedAt
            FROM orders o
            JOIN users u ON o.userId = u.id
            WHERE o.deletedAt IS NULL
            ORDER BY o.createdAt DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}