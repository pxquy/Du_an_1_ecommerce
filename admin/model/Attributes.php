<?php
class Attributes extends BaseModel
{
    protected $table = 'attributes';

    public function getAttributeValue($id)
    {
        $sql = 'SELECT
                    a.name           ,
                    a.description     ,
                    av.value
                FROM attributes a 
                JOIN attribute_value av ON av.attributeId = a.id

                WHERE av.attributeId = :attributeId
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['attributeId' => $id]);
        return $stmt->fetchAll();
    }
}