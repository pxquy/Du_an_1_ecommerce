<?php
class Variant extends BaseModel
{
    protected $table = 'variants';

    public function getAll()
    {
        $sql = "SELECT
            v.id                            ,
            p.title             productTitle,
            v.stock                         ,
            v.price                         ,
            v.productId                  

        FROM variants v
        JOIN products p ON v.productId = p.id
        ORDER BY v.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductVariant($productId)
    {
        $sql = "SELECT
            p.id productId,
            v.id variantId,
            vv.valueId
            FROM variants v 
            JOIN products p on v.productId = p.id
            JOIN variant_values vv on vv.variantId = v.id
            WHERE productId = :productId
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll();
    }

    public function variantExists($productId, $valueIds = [])
    {
        if (empty($valueIds)) {
            return false;
        }

        $valueCount = count(value: $valueIds);
        $placeholders = implode(',', array_fill(0, $valueCount, '?'));

        $sql = "
        SELECT vv.variantId
        FROM variant_values vv
        JOIN variants v ON vv.variantId = v.id
        WHERE v.productId = ?
        GROUP BY vv.variantId
        HAVING COUNT(*) = ? 
           AND SUM(vv.valueId IN ($placeholders)) = ?
        LIMIT 1
    ";

        $params = array_merge(
            [$productId],
            [$valueCount],
            $valueIds,
            [$valueCount]
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        return !empty($result);
    }




}