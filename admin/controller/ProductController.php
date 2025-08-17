<?php
class ProductController
{
    private $product, $productImages, $brand, $category, $variant, $variantValue, $attribute, $attributeValue, $comment;

    public function __construct()
    {
        $this->product = new Product();
        $this->productImages = new ProductImage();
        $this->brand = new Brand();
        $this->category = new Category();
        $this->variant = new Variant();
        $this->attribute = new Attributes();
        $this->attributeValue = new AttributeValue();
        $this->variantValue = new VariantValue();
        $this->comment = new Comment();
    }

    private function validateProductData($data)
    {
        $errors = [];

        if (empty($data['title']) || strlen($data['title']) > 50) {
            $errors['title'] = "Tiêu đề là bắt buộc, tối đa 50 ký tự.";
        }

        if (!empty($data['shortDescription']) && strlen($data['shortDescription']) > 255) {
            $errors['shortDescription'] = "Mô tả ngắn tối đa 255 ký tự.";
        }

        if (isset($data['priceDefault']) && !is_numeric($data['priceDefault'])) {
            $errors['priceDefault'] = "Giá sản phẩm phải là số.";
        }

        if (empty($data['categoryId'])) {
            $errors['categoryId'] = "Danh mục là bắt buộc.";
        }

        if (empty($data['brandId'])) {
            $errors['brandId'] = "Thương hiệu là bắt buộc.";
        }

        if (!empty($data['thumbnail']['name'])) {
            $thumb = $data['thumbnail'];

            if ($thumb['size'] > 2 * 1024 * 1024) {
                $errors['thumbnail_size'] = "Ảnh đại diện vượt quá 2MB.";
            }

            // Thêm hỗ trợ AVIF
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/avif'];
            if (!in_array($thumb['type'], $allowedTypes)) {
                $errors['thumbnail_type'] = "Chỉ chấp nhận định dạng JPG, JPEG, PNG, GIF, AVIF";
            }
        }

        return $errors;
    }


    public function index()
    {
        $title = 'Danh sách sản phẩm';
        $view = 'products/index';

        $brands = $this->brand->select();
        $categories = $this->category->select();

        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['perPage'] ?? 10;

        $keyword = $_GET['search'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        $brandId = $_GET['brand'] ?? null;
        $sort = $_GET['sort'] ?? null; // asc | desc

        $condition = '1=1'; // chỉ lấy sản phẩm chưa xóa mềm
        $params = [];

        if ($keyword) {
            $condition .= ' AND title LIKE :keyword';
            $params['keyword'] = '%' . $keyword . '%';
        }

        if ($categoryId) {
            $condition .= ' AND categoryId = :categoryId';
            $params['categoryId'] = $categoryId;
        }

        if ($brandId) {
            $condition .= ' AND brandId = :brandId';
            $params['brandId'] = $brandId;
        }

        // Xử lý sắp xếp
        $orderBy = '';
        if ($sort === 'asc') {
            $orderBy = ' ORDER BY priceDefault ASC';
        } elseif ($sort === 'desc') {
            $orderBy = ' ORDER BY priceDefault DESC';
        }

        // Lấy tổng sản phẩm trước khi phân trang
        $total = $this->product->count($condition, $params);

        // Truy vấn có phân trang và sắp xếp
        $data = $this->product->paginate($page, $perPage, '*', $condition . $orderBy, $params);

        // Trả về JSON nếu là AJAX
        if (!empty($_GET['ajax'])) {
            echo json_encode([
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
            ]);
            exit;
        }

        // Nếu không phải ajax thì trả về view bình thường
        require_once PATH_VIEW_ADMIN_MAIN;
    }



    public function show()
    {
        try {
            // debug($_SESSION['user']);
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $productDetail = $this->product->getDetail($id);
            // debug($productDetail);
            if (empty($productDetail)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }


            $productImages = $this->productImages->select('*', 'productId = :productId', ['productId' => $id]);
            $variants = $this->variant->select('*', 'productId = :productId', ['productId' => $id]);
            foreach ($variants as &$variant) {
                $variantValues = $this->variantValue->getValuesByVariantId($variant['id']);
                foreach ($variantValues as $variantValue) {
                    $variant[$variantValue['name']] = $variantValue['value'];
                }
            }
            unset($variant);
            $comments = $this->comment->getCommentsByProduct($productDetail['id']);

            $productDetail['variants'] = $variants;

            $view = 'products/show';
            $title = "Chi tiết sản phẩm: " . $productDetail['title'];
            require_once PATH_VIEW_ADMIN_MAIN;
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
            exit();
        }
    }

    public function create()
    {
        $view = 'products/create';
        $title = 'Thêm mới sản phẩm';
        $categories = $this->category->select();
        $brands = $this->brand->select();
        $categoryPluck = array_column($categories, 'title', 'id');
        $brandPluck = array_column($brands, 'title', 'id');
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ');
            }

            $data = $_POST;
            $data['thumbnail'] = $_FILES['thumbnail'];

            $_SESSION['errors'] = $this->validateProductData($data);
            $data['slug'] = slugify($data['title']);

            if (!empty($this->product->find('*', 'slug = :slug', ['slug' => $data['slug']]))) {
                $_SESSION['errors']['slug'] = 'Tên sản phẩm đã tồn tại.';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ');
            }

            $data['thumbnail'] = $data['thumbnail']['size'] > 0 ? upload_file('products', $data['thumbnail']) : null;
            $rowCount = $this->product->insert($data);

            $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/avif'];
            if (isset($_FILES['images'])) {
                foreach ($_FILES['images']['name'] as $i => $name) {
                    $image = [
                        'name' => $name,
                        'full_path' => $_FILES['images']['full_path'][$i],
                        'type' => $_FILES['images']['type'][$i],
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'error' => $_FILES['images']['error'][$i],
                        'size' => $_FILES['images']['size'][$i]
                    ];

                    if ($image['error'] !== 0 || !in_array($image['type'], $allowedType) || $image['size'] > 2 * 1024 * 1024) {
                        $_SESSION['errors']['images'][$i] = 'Ảnh ' . ($i + 1) . ' không hợp lệ.';
                        continue;
                    }

                    $imageUrl = upload_file('products', $image);
                    if ($imageUrl) {
                        $this->productImages->insert([
                            'productId' => $rowCount,
                            'imageUrl' => $imageUrl,
                            'sortOrder' => $i + 1
                        ]);
                    }
                }
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Thêm sản phẩm thành công.';
            header('Location: ' . BASE_URL_ADMIN . '&action=variants-create&productId=' . $rowCount);
            exit();
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=products-create');
            exit();
        }
    }

    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }

            $view = 'products/edit';
            $title = "Cập nhật sản phẩm: $id";
            $categories = $this->category->select();
            $brands = $this->brand->select();
            $categoryPluck = array_column($categories, 'title', 'id');
            $brandPluck = array_column($brands, 'title', 'id');
            $productImages = $this->productImages->select('*', 'productId = :productId', ['productId' => $id]);
            require_once PATH_VIEW_ADMIN_MAIN;
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
            exit();
        }
    }

    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }

            $data = $_POST;
            $data['thumbnail'] = $_FILES['thumbnail'];
            $_SESSION['errors'] = $this->validateProductData($data);
            $data['slug'] = slugify($data['title']);

            // Kiểm tra slug trùng
            if (!empty($this->product->find('*', 'slug = :slug AND id != :id', ['slug' => $data['slug'], 'id' => $id]))) {
                $_SESSION['errors']['slug'] = 'Tên sản phẩm đã tồn tại.';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ');
            }

            // Upload ảnh đại diện nếu có
            if ($_FILES['thumbnail']['size'] > 0) {
                $data['thumbnail'] = upload_file('products', $_FILES['thumbnail']);
            } else {
                unset($data['thumbnail']); // Không thay đổi ảnh nếu không upload mới
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');
            $rowCount = $this->product->update($data, 'id = :id', ['id' => $id]);

            // Upload ảnh khác nếu có
            $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/avif'];
            if (isset($_FILES['images'])) {
                foreach ($_FILES['images']['name'] as $i => $name) {
                    $image = [
                        'name' => $name,
                        'full_path' => $_FILES['images']['full_path'][$i],
                        'type' => $_FILES['images']['type'][$i],
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'error' => $_FILES['images']['error'][$i],
                        'size' => $_FILES['images']['size'][$i]
                    ];

                    if ($image['error'] !== 0 || !in_array($image['type'], $allowedType) || $image['size'] > 2 * 1024 * 1024) {
                        $_SESSION['errors']['images'][$i] = 'Ảnh ' . ($i + 1) . ' không hợp lệ.';
                        continue;
                    }

                    $imageUrl = upload_file('products', $image);
                    if ($imageUrl) {
                        $this->productImages->insert([
                            'productId' => $id,
                            'imageUrl' => $imageUrl,
                            'sortOrder' => $i + 1
                        ]);
                    }
                }
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật sản phẩm thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-show&id=' . $id);
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }

            $rowCount = $this->product->softDelete($id);

            if ($rowCount <= 0) {
                throw new Exception('Xóa mềm không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Xóa mềm sản phẩm thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
        exit();
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }

            $rowCount = $this->product->restore($id);

            if ($rowCount <= 0) {
                throw new Exception('Khôi phục không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Khôi phục sản phẩm thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Sản phẩm có ID = $id không tồn tại!");
            }

            $rowCount = $this->product->delete('id = :id', ['id' => $id]);

            if ($rowCount <= 0) {
                throw new Exception('Xóa sản phẩm không thành công!');
            }

            if (!empty($product['thumbnail']) && file_exists(PATH_ASSETS_UPLOADS . $product['thumbnail'])) {
                unlink(PATH_ASSETS_UPLOADS . $product['thumbnail']);
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Xóa sản phẩm thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
        exit();
    }

    public function replyComment()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Phương thức không hợp lệ");
            }

            $data['userId'] = $_SESSION['user']['id'] ?? null;
            $data['productId'] = $_POST['productId'] ?? null;
            $data['parentId'] = $_POST['parentId'] ?? null;
            $data['content'] = trim($_POST['content'] ?? '');

            if (!$data['userId'] || !$data['productId'] || !$data['parentId'] || $data['content'] === '') {
                throw new Exception("Thiếu dữ liệu cần thiết");
            }

            $data['createdAt'] = date('Y-m-d H:i:s');
            $data['updatedAt'] = date('Y-m-d H:i:s');

            $this->comment->insert($data);

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Phản hồi thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-show&id=' . $data['productId']);
        exit();
    }

    public function deleteComment()
    {
        try {
            if (!isset($_GET['id']) || !isset($_GET['productId'])) {
                throw new Exception('Thiếu tham số ID bình luận hoặc sản phẩm.', 99);
            }

            $id = $_GET['id'];
            $productId = $_GET['productId'];

            // Kiểm tra comment tồn tại
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận có ID = $id không tồn tại!");
            }

            // Gọi soft delete từ model
            $rowCount = $this->comment->softDelete($id);

            if ($rowCount <= 0) {
                throw new Exception('Xóa mềm bình luận không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Xóa mềm bình luận thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-show&id=' . $_GET['productId']);
        exit();
    }
}
