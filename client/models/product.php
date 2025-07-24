<?php
class Product extends BaseModel
{
    protected $table = "products";
    public function setTable($tableName)
    {
        $this->table = $tableName;
    }
}
