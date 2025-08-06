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
                p.sku             sku,
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

    public function getDetail($id)
    {
        $sql = 'SELECT 
                p.id,
                p.title,
                p.thumbnail,
                p.shortDescription,
                p.description,
                p.priceDefault,
                p.discount,
                p.sku,
                c.title             categoryTitle,
                b.title             brandTitle,
                p.averageRating,
                p.ratingCount,
                p.stockTotal,
                p.seoTitle,
                p.seoDescription,
                p.isActive

            FROM products p
            JOIN categories c ON p.categoryId = c.id
            JOIN brands b ON p.brandId = b.id
            WHERE p.id = :id
            ORDER BY p.id ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
