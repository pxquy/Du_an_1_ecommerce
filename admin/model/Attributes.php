<?php
class Attributes extends BaseModel
{
    protected $table = 'attributes';

    public function getAttributeValue($id)
    {
        $sql = 'SELECT
                    av.id           ,
                    av.value        ,
                    av.valueCode
                FROM attribute_values av

                WHERE av.attributeId = :attributeId
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['attributeId' => $id]);
        return $stmt->fetchAll();
    }
}