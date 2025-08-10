<?php
require_once './client/model/Product.php';
require_once './client/model/Comment.php';
class ProductController
{
    private $client, $brands;
    public function __construct()
    {
        $this->client = new Product();
        $this->brands = new Brand();
    }
    public function home()
    {
        $view = 'pages/site/home/home';
        $title = 'Trang chủ';
        $products_best_seller = $this->client->getBestSeller(4); // lấy 4 sản phẩm bán chạy nhất
        $products_brand_nike = $this->client->getBestBrand(1, 4); // lấy 4 sản theo brands
        // debug($products_best_seller);
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

        require_once PATH_VIEW_CLIENT . $view . '.php';
    }



    public function productDetail()
    {
        $slug = $_GET['slug'] ?? null;
        $title = "Chi tiết sản phẩm";
        $view = 'pages/site/product-detail/product-detail';

        // ===== 1. Lấy thông tin sản phẩm + các ảnh =====
        $this->client->setTable("
        products p
        LEFT JOIN product_images pi ON p.id = pi.productId
    ");

        $productDetailRaw = $this->client->select(
            'p.*, GROUP_CONCAT(DISTINCT pi.imageUrl) AS imageUrls',
            'p.slug = ? GROUP BY p.id',
            [$slug]
        );

        $productDetail = $productDetailRaw[0] ?? [];
        $images = explode(',', $productDetail['imageUrls'] ?? '');
        $relatedProducts = $this->client->paginate(1, 4, "*", 'brandId = :brandId', ["brandId" => $productDetail['brandId']]);

        // Nếu không tìm thấy sản phẩm thì quay về trang chủ
        if (empty($productDetail)) {
            header("Location: " . BASE_URL);
            exit;
        }

        // ===== 2. Lấy danh sách biến thể theo productId =====
        $this->client->setTable("variants");
        $variants = $this->client->select("*", "productId = ?", [$productDetail['id']]);

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
            [$productDetail['id']]
        );

        // Gom nhóm thuộc tính theo variantId
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

        // ===== 4. Lấy đánh giá theo productId =====
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByProduct($productDetail['id']);

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
