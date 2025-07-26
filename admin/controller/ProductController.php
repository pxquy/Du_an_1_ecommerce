<?php
class ProductController
{
    private $product, $brand, $category, $variant, $attribute, $attributeValue;


    public function __construct()
    {
        $this->product = new product();
        $this->brand = new Brand();
        $this->category = new Category();
        $this->variant = new Variant();
        $this->attribute = new attribute();
        $this->attributeValue = new AttributeValue();
    }
    public function index()
    {
        $view = 'products/index';
        $title = 'Danh sách product';
        $data = $this->product->getAll();
        // debug($data);
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            $productVariants = $this->product->getVariant($id);
            if (empty($product)) {
                throw new Exception("product co ID = $id khong ton tai!");
            }

            $view = 'products/show';

            $title = "Chi tiet product co Id = $id";

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
        $title = 'Them moi product';
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
                throw new Exception();
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "title bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['priceDefault'] = isset($data['priceDefault']) && is_numeric($data['priceDefault']) ? $data['priceDefault'] : null;
            $data['discountPercentage'] = isset($data['discountPercentage']) && is_numeric($data['discountPercentage']) ? $data['discountPercentage'] : null;

            if (isset($data['thumbnail']) && $data['thumbnail']['size'] > 0) {

                if ($data['thumbnail']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['thumbnail_size'] = 'Truong thumbnail co dung luong toi da 2MB';
                }

                $fileType = $data['thumbnail']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['thumbnail_type'] = "xin loi chi chap nhan cac loai file JPG, JPEG, PNG, GIF. ";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            if ($data['thumbnail']['size'] > 0) {
                $data['thumbnail'] = upload_file('products', $data['thumbnail']);
            } else {
                $data['thumbnail'] = null;
            }

            $data['slug'] = slugify($data['title']);

            if (
                !empty(
                $this->product->find(
                    '*',
                    'slug = :slug',
                    [
                        'slug' => $data['slug']
                    ]
                )
            )
            ) {
                $_SESSION['errors']['slug'] = 'Tên sản phẩm đã tồn tại.';
            }

            $rowCount = $this->product->insert($data);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thao tac thanh cong';
            } else {
                throw new Exception('Thao tac khong thanh cong');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

        }
        header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("product co ID = $id khong ton tai");
            }

            $view = 'products/edit';
            $title = "Cap nhat product co ID = $id";
            $categories = $this->category->select();
            $brands = $this->brand->select();
            $categoryPluck = array_column($categories, 'title', 'id');
            $brandPluck = array_column($brands, 'title', 'id');
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
                throw new Exception('Yeu cau phuong thuc phai la POST');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so "id"', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Product co id  = $id khong ton tai");
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "title bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['slug'] = slugify($data['title']);

            if (
                !empty(
                $this->product->find(
                    '*',
                    'slug = :slug AND id != :id',
                    [
                        'slug' => $data['slug'],
                        'id' => $id
                    ]
                )
            )
            ) {
                $_SESSION['errors']['slug'] = 'Tên sản phẩm đã tồn tại.';
            }

            $data['priceDefault'] = isset($data['priceDefault']) && is_numeric($data['priceDefault']) ? $data['priceDefault'] : null;
            $data['discountPercentage'] = isset($data['discountPercentage']) && is_numeric($data['discountPercentage']) ? $data['discountPercentage'] : null;

            if (isset($data['thumbnail']) && $data['thumbnail']['size'] > 0) {

                if ($data['thumbnail']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['thumbnail_size'] = 'Truong thumbnail co dung luong toi da 2MB';
                }

                $fileType = $data['thumbnail']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['thumbnail_type'] = "xin loi chi chap nhan cac loai file JPG, JPEG, PNG, GIF. ";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            if ($data['thumbnail']['size'] > 0) {
                $data['thumbnail'] = upload_file('products', $data['thumbnail']);
            } else {
                $data['thumbnail'] = $product['thumbnail'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->product->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (
                    $_FILES['thumbnail']['size'] > 0
                    && !empty($product['thumbnail'])
                    && file_exists(PATH_ASSETS_UPLOADS . $product['thumbnail'])
                ) {
                    unlink(PATH_ASSETS_UPLOADS . $product['thumbnail']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong';
            } else {
                throw new Exception('thao tac khong thanh cong!');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Line: ' . $th->getLine();

            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-edit&id=' . $id);
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Product co id = $id Khong ton tai!");
            }

            $rowCount = $this->product->softDelete($id);

            if ($rowCount > 0) {

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong!';
            } else {
                throw new Exception('Thao tac khong thanh cong!');
            }
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
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("Brand co id = $id Khong ton tai!");
            }

            $rowCount = $this->product->restore($id);

            if ($rowCount > 0) {

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong!';
            } else {
                throw new Exception('Thao tac khong thanh cong!');
            }
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
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $product = $this->product->find('*', 'id = :id', ['id' => $id]);

            if (empty($product)) {
                throw new Exception("product co id = $id Khong ton tai!");
            }

            $rowCount = $this->product->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {

                if (!empty($product['thumbnail']) && file_exists(PATH_ASSETS_UPLOADS . $product['thumbnail'])) {
                    unlink(PATH_ASSETS_UPLOADS . $product['thumbnail']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong!';
            } else {
                throw new Exception('Thao tac khong thanh cong!');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
        exit();
    }
}