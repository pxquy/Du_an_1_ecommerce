<?php
class VariantController
{
    private $variant, $variantValue, $attributes, $attributeValue, $product;

    public function __construct()
    {
        $this->variant = new Variant();
        $this->variantValue = new VariantValue();
        $this->attributes = new Attributes();
        $this->attributeValue = new AttributeValue();
        $this->product = new Product();
    }

    public function index()
    {
        $view = 'variants/index';
        $title = 'Danh sách biến thể';
        $data = $this->variant->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("Biến thể có ID = $id không tồn tại!");
            }

            $view = 'variants/show';
            $title = "Chi tiết biến thể: ID = $id";
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
            exit();
        }
    }

    public function create()
    {
        $view = 'variants/create';
        $title = 'Thêm mới biến thể';

        if (isset($_GET['productId'])) {
            $product = $this->product->find('id, title, priceDefault', 'id = :id', ['id' => $_GET['productId']]);
        } else {
            $products = $this->product->select();
            $productPluck = array_column($products, 'title', 'id');
        }

        $attributes = $this->attributes->select();
        foreach ($attributes as &$attribute) {
            $attribute['value'] = $this->attributeValue->select('id, value', 'attributeId = :attributeId', ['attributeId' => $attribute['id']]);
        }
        unset($attribute);

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Phương thức phải là POST');
            }

            $productId = $_POST['productId'] ?? null;
            $attributes = $_POST['attributes'] ?? null;

            if (!$productId || empty($attributes)) {
                throw new Exception('Thiếu dữ liệu sản phẩm hoặc thuộc tính');
            }

            $arrValues = array_values($attributes);
            $combinations = dequy($arrValues);

            foreach ($combinations as $combination) {
                $valueIds = array_map('intval', explode('-', $combination));
                sort($valueIds);

                if (!$this->variant->variantExists($productId, $valueIds)) {
                    $variantId = $this->variant->insert(['productId' => $productId]);
                    foreach ($valueIds as $valueId) {
                        $this->variantValue->insert([
                            'variantId' => $variantId,
                            'valueId' => $valueId
                        ]);
                    }
                }
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Tạo biến thể thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = 'Lỗi: ' . $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=variants-edit&productId=' . $productId);
        exit;
    }

    public function edit()
    {
        try {
            if (!isset($_GET['productId'])) {
                throw new Exception('Thiếu tham số productId', 99);
            }

            $productId = $_GET['productId'];
            $productDetail = $this->product->getDetail($productId);

            if (empty($productDetail)) {
                throw new Exception("Sản phẩm có ID = $productId không tồn tại!");
            }

            $variants = $this->variant->select('*', 'productId = :productId', ['productId' => $productId]);
            $allAttributes = $this->attributes->select();
            $allAttributeValues = $this->attributeValue->select();

            $allValuesByAttribute = [];
            foreach ($allAttributeValues as $val) {
                $allValuesByAttribute[$val['attributeId']][] = $val;
            }

            foreach ($variants as &$variant) {
                $variantValues = $this->variantValue->getValuesByVariantId($variant['id']);
                $variant['attributes'] = [];
                foreach ($variantValues as $vv) {
                    $variant['attributes'][] = [
                        'attributeId' => $vv['attributeId'],
                        'attributeName' => $vv['name'],
                        'value' => $vv['value'],
                        'valueId' => $vv['valueId'] ?? $vv['id']
                    ];
                }
            }
            unset($variant);

            $productDetail['variants'] = $variants;
            $view = 'variants/edit';
            $title = 'Cập nhật biến thể sản phẩm';
            require_once PATH_VIEW_ADMIN_MAIN;
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=products-index');
            exit;
        }
    }

    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['variants'])) {
                throw new Exception('Không có dữ liệu cập nhật');
            }

            foreach ($_POST['variants'] as $variantId => $fields) {
                $price = isset($fields['price']) ? (float) $fields['price'] : 0;
                $stock = isset($fields['stock']) ? (int) $fields['stock'] : 0;

                $this->variant->update(['price' => $price, 'stock' => $stock], 'id = :id', ['id' => $variantId]);

                if (!empty($fields['attributes']) && is_array($fields['attributes'])) {
                    $this->variantValue->delete('variantId = :variantId', ['variantId' => $variantId]);
                    foreach ($fields['attributes'] as $attributeId => $valueId) {
                        $this->variantValue->insert([
                            'variantId' => $variantId,
                            'valueId' => $valueId
                        ]);
                    }
                }
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật biến thể thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=products-show&id=' . $_GET['productId']);
        exit;
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id']) || !isset($_GET['productId'])) {
                throw new Exception('Thiếu tham số ID hoặc productId', 99);
            }

            $id = $_GET['id'];
            $productId = $_GET['productId'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);
            if (empty($variant)) {
                throw new Exception("Biến thể có ID = $id không tồn tại!");
            }

            $this->variantValue->delete('variantId = :variantId', ['variantId' => $id]);
            $rowCount = $this->variant->delete('id = :id', ['id' => $id]);

            if ($rowCount <= 0) {
                throw new Exception('Xóa biến thể không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Xóa biến thể thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=variants-edit&productId=' . $productId);
        exit();
    }
}
