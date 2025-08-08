<?php
require_once './client/model/Product.php';
require_once './client/model/Comment.php';

class ProductController
{
    private $client, $categories, $brands;

    public function __construct()
    {
        $this->client = new Product();
        $this->categories = new Category();
        $this->brands = new Brand();
    }

    public function home()
    {
        // Set bảng với join ảnh sản phẩm
        $this->client->setTable("
        products p
        LEFT JOIN product_images pi ON p.id = pi.productId
    ");

        // Lấy dữ liệu phân trang
        $page = 1;
        $perPage = 8;
        $columns = "p.*, pi.imageUrl AS imageUrl";

        $numRow = $this->client->count();
        $numPages = ceil($numRow / $perPage);

        $products = $this->client->paginate($page, $perPage, $columns);
        $categories = $this->categories->select();

        $title = 'Trang chủ';
        $view = 'pages/site/home/home';

        extract(compact('products', 'title', 'view'));

        require_once PATH_VIEW_CLIENT . $view . ".php";
    }


    public function productDetail()
    {

        $id = $_GET['id'] ?? null;
        $title = "Chi tiết sản phẩm";
        $view = 'pages/site/product-detail/product-detail';

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


        $relatedProducts = $this->client->paginate(1, 4, "*", 'brandId = :brandId', ["brandId" => $productDetail['brandId']]);

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

        extract([
            'productDetail' => $productDetail,
            'images' => $images,
            'variants' => $variants,
            'variantAttributes' => $variantAttributes,
            'relatedProducts' => $relatedProducts,
            'comments' => $comments,
            'view' => $view,
            'title' => $title,
        ]);

        // debug($variantAttributes);


        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
}
