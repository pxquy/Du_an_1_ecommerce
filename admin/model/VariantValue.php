<?php
class VariantValue extends BaseModel
{
    protected $table = "variant_values";

    public function getValuesByVariantId($variantId)
    {
        $sql = "SELECT
                    vv.id,
                    vv.variantId,
                    a.name name,
                    av.attributeId,
                    av.value value,
                    av.id valueId

                
                FROM variant_values vv
                JOIN attribute_values av ON av.id = vv.valueId
                JOIN attributes a ON a.id = av.attributeId
                WHERE vv.variantId = :variantId
                ORDER BY vv.id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['variantId' => $variantId]);
        return $stmt->fetchAll();
    }

    public function isAttributeUsedInVariant($variantId, $valueId)
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM variant_values vv
        JOIN attribute_values av ON av.id = vv.valueId
        WHERE vv.variantId = :variantId
          AND av.attributeId = (
              SELECT attributeId FROM attribute_values WHERE id = :valueId
          )
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'variantId' => $variantId,
            'valueId' => $valueId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return isset($result['total']) && $result['total'] > 0;
    }

}