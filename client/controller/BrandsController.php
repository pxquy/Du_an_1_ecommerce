<?php
require_once './client/model/Brand.php';

class BrandsController
{
    private $client;

    public function __construct()
    {
        $this->client = new Brand();
    }

    public function productsByBrand()
    {
        $brandId = $_GET['brandId'] ?? null;
        if (!$brandId) {
            die("Thiếu brandId");
        }

        $products = $this->client->getProductsByBrand($brandId);
        // debug($products);
        $view = 'pages/products-detail/products-by-brand';
        require_once PATH_VIEW_CLIENT . 'layout.php';
    }
}
