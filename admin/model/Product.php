<?php
class Product extends BaseModel
{
    protected $table = 'products';

    public function getAll()
    {
        $sql = "
            SELECT 
                p.id                id,
                p.title             title,
                p.thumbnail         thumbnail,
                p.shortDescription  shortDescription,
                p.priceDefault             priceDefault,
                c.title             categoryTitle,
                b.title             brandTitle,
                p.averageRating     rating,
                p.stockTotal        stock,
                p.isActive          isActive

            FROM products p
            JOIN categories c ON p.categoryId = c.id
            JOIN brands b ON p.brandId = b.id
            ORDER BY p.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getVariant($id)
    {
        $sql = 'SELECT 
                v.id AS variantId,
                v.imageUrl,
                v.sku,
                v.stock,
                v.price,
                p.priceDefault AS oldPrice,
                
                a.name AS attributeName,
                av.value AS attributeValue

            FROM variants v
            JOIN attributes a ON v.attributeId = a.id
            JOIN attribute_values av ON v.valueId = av.id
            JOIN products p ON v.productId = p.id
            WHERE v.productId = :productId';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['productId' => $id]);
        return $stmt->fetchAll();
    }

    public function getComment($id)
    {
        $sql = 'SELECT
                v.id AS commentId,
                
        ';
    }

}