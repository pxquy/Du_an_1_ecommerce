<?php
class Variant extends BaseModel
{
    protected $table = 'variants';

    public function getAll()
    {
        $sql = "SELECT
            v.id                            ,
            v.imageUrl                      ,
            p.title             productTitle,
            v.stock                         ,
            v.price                         ,
            p.priceDefault      oldPrice,
            v.SKU                           

        FROM variants v
        JOIN products p ON v.productId = p.id
        ORDER BY v.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}