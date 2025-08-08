<?php
class Brand extends BaseModel
{
    protected $table = 'brands';

    // Lấy tất cả sản phẩm theo brand
    public function getProductsByBrand($brandId)
    {
        $sql = "SELECT * FROM products WHERE brandId = :brandId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':brandId' => $brandId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
