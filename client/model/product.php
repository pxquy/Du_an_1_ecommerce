<?php
class Product extends BaseModel
{
    protected $table = "products";
    public function setTable($tableName)
    {
        $this->table = $tableName;
    }
    public function searchProducts($keyword = '', $minPrice = 0, $maxPrice = 0, $order = 'ASC')
    {
        $sql = "SELECT * FROM {$this->table} WHERE isActive = 1";
        $params = [];

        // Lọc theo từ khóa (tên hoặc slug)
        if (!empty($keyword)) {
            $sql .= " AND (title LIKE :keyword OR slug LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        // Lọc theo giá
        if ($minPrice > 0) {
            $sql .= " AND priceDefault >= :minPrice";
            $params['minPrice'] = $minPrice;
        }
        if ($maxPrice > 0) {
            $sql .= " AND priceDefault <= :maxPrice";
            $params['maxPrice'] = $maxPrice;
        }

        // Sắp xếp theo tên sản phẩm
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sql .= " ORDER BY title $order";

        return $this->selectRaw($sql, $params);
    }
    public function getBestSeller($limit = 1)
    {
        $sql = "SELECT * FROM products ORDER BY soldCount DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestBrand($brandId, $limit = 1)
    {
        $sql = "SELECT * 
            FROM products 
            WHERE brandId = :brandId 
            ORDER BY soldCount DESC 
            LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':brandId', (int)$brandId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
