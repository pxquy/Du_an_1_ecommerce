<?php
require_once './client/models/Product.php';
require_once './client/models/Comment.php';
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
    ");
        $page = 1;
        $perPage = 8;
        $columns = "p.*, pi.imageUrl AS imageUrl";
        $numRow = $this->client->count();
        // debug($numRow);
        $numPages = ceil($numRow / $perPage);
        $products = $this->client->paginate($page, $perPage, $columns);

        require_once PATH_VIEW_CLIENT_MAIN;
    }



    public function productDetail()
    {

        $id = $_GET['id'] ?? null;
        $title = "Chi tiết sản phẩm";
        $view = 'pages/products-detail/test_detail';

        // ===== 1. Lấy thông tin sản phẩm + các ảnh =====
        $this->client->setTable("
        products p
        LEFT JOIN product_images pi ON p.id = pi.productId
    ");

        $productDetailRaw = $this->client->select(
            'p.*, GROUP_CONCAT(DISTINCT pi.imageUrl) AS imageUrls',
            'p.id = ? GROUP BY p.id',
            [$id]
        );

        $productDetail = $productDetailRaw[0] ?? [];
        $images = explode(',', $productDetail['imageUrls'] ?? '');
        // debug($productDetail);
        // ===== 2. Lấy danh sách biến thể (variants) =====
        $this->client->setTable("variants");
        $variants = $this->client->select("*", "productId = ?", [$id]);
        // debug($variants);

        // ===== 3. Lấy các giá trị thuộc tính của từng biến thể =====
        $this->client->setTable("
        variant_values vv
        JOIN attribute_values av ON vv.valueId = av.id
        JOIN attributes a ON av.attributeId = a.id
    ");

        $variantAttributesRaw = $this->client->select(
            "vv.variantId, a.name AS attributeName, av.value AS attributeValue, a.id AS attributeId, av.id AS valueId",
            "vv.variantId IN (
            SELECT id FROM variants WHERE productId = ?
        )",
            [$id]
        );
        // debug($variantAttributesRaw);
        // ===== 4. Gom nhóm thuộc tính theo biến thể =====
        $variantAttributes = [];
        foreach ($variantAttributesRaw as $attr) {
            $variantId = $attr['variantId'];
            if (!isset($variantAttributes[$variantId])) {
                $variantAttributes[$variantId] = [];
            }
            $variantAttributes[$variantId][] = [
                'attributeId' => $attr['attributeId'],
                'attributeName' => $attr['attributeName'],
                'valueId' => $attr['valueId'],
                'attributeValue' => $attr['attributeValue'],
            ];
        }
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByProduct($productDetail['id'] ?? 0);
        // debug($variantAttributes);
        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
    public function search()
    {
        // Lấy dữ liệu từ query string
        $keyword   = $_GET['keyword'] ?? '';
        $minPrice  = floatval($_GET['minPrice'] ?? 0);
        $maxPrice  = floatval($_GET['maxPrice'] ?? 0);
        $order     = $_GET['order'] ?? 'ASC'; // A-Z hoặc Z-A

        // Gọi model tìm kiếm
        $products = $this->client->searchProducts($keyword, $minPrice, $maxPrice, $order);

        // View
        $title = 'Tìm kiếm sản phẩm';
        $view  = 'main';
        require_once PATH_VIEW_CLIENT . $view . '.php';
    }
}
