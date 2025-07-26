<?php
require_once './client/models/Product.php';
class ProductController
{
    private $client;
    public function __construct()
    {
        $this->client = new Product();
    }
    public function home()
    {
        $view = 'main';
        $title = 'Trang chủ';
        $this->client->setTable("
        products p
        LEFT JOIN product_images pi ON p.id = pi.productId
        LEFT JOIN product_tags pt ON p.id = pt.productId
    ");

        $products = $this->client->select('p.*, pi.imageUrl AS imageUrl, pt.tag AS tag');
        // debug($products);

        require_once PATH_VIEW_CLIENT_MAIN;
    }


    public function productDetail()
    {
        require_Login();
        $id = $_GET['id'] ?? null;
        $title = "Chi tiết sản phẩm";
        $view = 'productDetail';

        $this->client->setTable("
        products p
        LEFT JOIN product_images pi ON p.id = pi.productId
        LEFT JOIN product_tags pt ON p.id = pt.productId
    ");

        $productDetailRaw = $this->client->select(
            'p.*, GROUP_CONCAT(DISTINCT pi.imageUrl) AS imageUrls, GROUP_CONCAT(DISTINCT pt.tag) AS tags',
            'p.id = ? GROUP BY p.id',
            [$id]
        );

        $productDetail = $productDetailRaw[0] ?? [];
        $images = explode(',', $productDetail['imageUrls'] ?? '');
        $tags = explode(',', $productDetail['tags'] ?? '');
        // debug($productDetail,);

        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
}
