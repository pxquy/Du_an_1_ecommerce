<?php
class Order extends BaseModel
{
    protected $table = 'Orders';
    public function getOrderPage(array $filters, int $page = 1, int $perPage = 10): array
    {
        $where = [];
        $params = [];

        // lọc trạng thái (ENUM '0'..'5' dưới dạng chuỗi)
        if (isset($filters['status']) && $filters['status'] !== '' && $filters['status'] !== null) {
            $where[] = 'o.status = :status';
            $params['status'] = (string) $filters['status'];
        }

        // tìm theo tên khách hàng
        if (!empty($filters['keyword'])) {
            $where[] = 'u.fullName LIKE :kw';
            $params['kw'] = '%' . $filters['keyword'] . '%';
        }

        // sort theo ngày tạo
        $sort = strtolower($filters['sort'] ?? 'newest');
        $orderBy = ($sort === 'oldest') ? 'ASC' : 'DESC'; // mặc định newest

        $conditionSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $offset = max(0, ($page - 1) * $perPage);

        $sql = "
        SELECT 
            o.id,
            o.userId,
            u.fullName AS fullname,
            o.orderAddress,
            o.total,
            o.status,
            o.createdAt,
            o.updatedAt,
            COUNT(*) OVER() AS total_rows
        FROM orders o
        JOIN users u ON u.id = o.userId
        $conditionSql
        ORDER BY o.createdAt $orderBy
        LIMIT :limit OFFSET :offset
    ";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', (int) $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOrderDetail($id)
    {
        $sql = "
        SELECT 
                u.fullName,
                o.id,
                o.status,
                p.title,
                op.quantity,
                op.price,
                u.fullName,
                op.total,
                GROUP_CONCAT(av.value ORDER BY vv.valueId SEPARATOR ',') value
        FROM order_products op
        JOIN orders  o ON op.orderId = o.id
        JOIN products p ON op.productId = p.id
        JOIN users u ON u.id = o.userId
        JOIN variant_values vv ON op.variantId = vv.variantId 
        JOIN attribute_values av ON vv.valueId = av.id
        WHERE orderId = :orderId 
        GROUP BY 
        op.id,
        p.title,
        op.quantity,
        op.price,
        u.fullName,
        op.total
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['orderId' => $id]);
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
            -- WHERE o.deletedAt IS NULL
            ORDER BY o.createdAt DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
