<?php
class ProductController
{
    private $client;
    public function __construct()
    {
        $this->client = new product();
    }
    public function home()
    {
        // $view = 'products';
        $title = 'Trang chủ';
        $products = $this->client->select('*');
        // debug($products);
        require_once PATH_VIEW_CLIENT_MAIN;
    }
}
