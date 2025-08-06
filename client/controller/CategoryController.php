<?php
require_once './client/model/Category.php';
class CategoryController
{
    private $client;
    public function __construct()
    {
        $this->client = new Category();
    }
    public function listCategory()
    {
        $view = 'pages/products-detail/product-detail';
        $listCategory = $this->client->select('*');
        // debug($listCategory);
    }
}
