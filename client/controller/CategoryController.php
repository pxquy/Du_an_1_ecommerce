<?php
require_once './client/models/Category.php';
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
