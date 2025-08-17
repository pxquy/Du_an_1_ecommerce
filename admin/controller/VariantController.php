<?php
class VariantController
{
    private $variant, $variantValue, $attributes, $attributeValue, $product;
    public function __construct()
    {
        $this->variant = new Variant();
        $this->variantValue = new VariantValue();
        $this->attributes = new Attributes();
        $this->product = new Product();
        $this->attributeValue = new AttributeValue();
    }

    public function index()
    {
        $view = 'variants/index';
        $name = 'Danh sách variant';
        $data = $this->variant->getAll();

        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co ID = $id khong ton tai!");
            }

            $view = 'variants/show';

            $name = "Chi tiet biến thể co Id = $id";

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
        $name = 'thêm mới biến thể';

        //xử lý khi Url có productId;
        if (isset($_GET['productId'])) {
            $product = $this->product->find('id, title, priceDefault', 'id =:id', ['id' => $_GET['productId']]);
        } else {
            $products = $this->product->select();
            $productPluck = array_column($products, 'title', 'id');
        }
        // debug($product);

        $attributes = $this->attributes->select();
        foreach ($attributes as &$attribute) {
            $attribute['value'] = $this->attributeValue->select('id, value', 'attributeId = :attributeId', ['attributeId' => $attribute['id']]);
        }
        unset($attribute);
        // debug($attributes[0]['value']);

        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Phương thức phải là POST');
            }

            // debug($_POST);

            $productId = $_POST['productId'] ?? null;
            $attributes = $_POST['attributes'] ?? null;

            if (!$productId || empty($attributes)) {
                throw new Exception('Thiếu dữ liệu sản phẩm hoặc thuộc tính');
            }

            $arrValues = array_values($attributes);            // Lấy các mảng valueId của từng attribute
            $combinations = dequy($arrValues);                 // Trả về mảng tổ hợp: ["1-5", "2-6", ...]

            // debug($arrValues);

            foreach ($combinations as $combination) {
                // Chuyển "1-5" thành [1, 5]
                $valueIds = array_map('intval', explode('-', $combination));
                sort($valueIds); // đảm bảo thứ tự để so sánh chính xác
                // debug($productId);
                if (!$this->variant->variantExists($productId, $valueIds)) {
                    // Biến thể chưa tồn tại → tạo mới
                    $variantId = $this->variant->insert(['productId' => $productId]); // hoặc truyền thêm price/stock nếu có
                    // debug($variantId);
                    foreach ($valueIds as $valueId) {
                        // Kiểm tra xem biến thể đã có valueId cùng attribute chưa
                        $isUsed = $this->variantValue->isAttributeUsedInVariant($variantId, $valueId);
                        echo "Variant: $variantId, valueId: $valueId, isUsed: ";
                        var_dump($isUsed);
                        if (!$isUsed) {
                            $this->variantValue->insert([
                                'variantId' => $variantId,
                                'valueId' => $valueId
                            ]);
                        }
                    }
                } else {

                }
            }
            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Tạo biến thể thành công';
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
                throw new Exception('Thiếu "productId" trên URL');
            }

            $productId = $_GET['productId'];

            // Lấy chi tiết sản phẩm
            $productDetail = $this->product->getDetail($productId);
            if (empty($productDetail)) {
                throw new Exception("Không tìm thấy sản phẩm có ID = $productId");
            }

            // Lấy tất cả biến thể của sản phẩm
            $variants = $this->variant->select('*', 'productId = :productId', ['productId' => $productId]);

            // Lấy toàn bộ danh sách giá trị theo attributeId
            $allAttributes = $this->attributes->select(); // [{id, name}]
            $allAttributeValues = $this->attributeValue->select(); // [{id, value, attributeId}]

            // Gom theo attributeId
            $allValuesByAttribute = [];
            foreach ($allAttributeValues as $val) {
                $allValuesByAttribute[$val['attributeId']][] = $val;
            }

            // Chuẩn bị danh sách valueId đang được dùng theo attributeId
            $usedValues = []; // [attributeId][variantId] = [valueId...]
            foreach ($variants as &$variant) {
                $variantValues = $this->variantValue->getValuesByVariantId($variant['id']);

                $variant['attributes'] = [];
                foreach ($variantValues as $vv) {
                    // var_dump($vv);
                    $variant['attributes'][] = [
                        'attributeId' => $vv['attributeId'],
                        'attributeName' => $vv['name'],
                        'value' => $vv['value'],
                        'valueId' => $vv['valueId'] ?? $vv['id'], // ✅ THÊM DÒNG NÀY
                    ];

                    // Ghi nhận giá trị đã dùng
                    $usedValues[$vv['attributeId']][$variant['id']] = $vv['id'];
                }
            }
            unset($variant);
            $existingCombinations = [];
            foreach ($variants as $variant) {
                $valueIds = array_column($this->variantValue->getValuesByVariantId($variant['id']), 'valueId');
                sort($valueIds);
                $combKey = implode('-', $valueIds);
                $existingCombinations[$combKey] = true;
            }
            $existingCombinationsJson = json_encode(array_keys($existingCombinations));

            $productDetail['variants'] = $variants;

            // Truyền sang view
            $view = 'variants/edit';
            $title = 'Cập nhật giá, tồn kho và thuộc tính biến thể';

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['variants'])) {
            foreach ($_POST['variants'] as $variantId => $fields) {
                $price = isset($fields['price']) ? (float) $fields['price'] : 0;
                $stock = isset($fields['stock']) ? (int) $fields['stock'] : 0;

                // Gọi đúng format yêu cầu của update()
                $this->variant->update(
                    ['price' => $price, 'stock' => $stock],  // dữ liệu cần cập nhật
                    'id = :id',                              // điều kiện WHERE
                    ['id' => $variantId]                    // tham số điều kiện
                );
                if (!empty($fields['attributes']) && is_array($fields['attributes'])) {
                    // Xoá các giá trị cũ
                    $this->variantValue->delete('variantId = :variantId', ['variantId' => $variantId]);

                    // Chèn lại các valueId mới
                    foreach ($fields['attributes'] as $attributeId => $valueId) {
                        $this->variantValue->insert([
                            'variantId' => $variantId,
                            'valueId' => $valueId
                        ]);
                    }
                }
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật biến thể thành công';
        } else {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = 'Không có dữ liệu để cập nhật';
        }

        // Redirect lại trang chi tiết sản phẩm
        header('Location: ' . BASE_URL_ADMIN . '&action=products-show&id=' . $_GET['productId']);
        exit;
    }


    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->variant->restore($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->variant->softDelete($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id']) || !isset($_GET['productId'])) {
                throw new Exception('Thiếu "id" hoặc "productId" trên URL', 99);
            }

            $id = $_GET['id'];
            $productId = $_GET['productId'];

            // Kiểm tra xem variant có tồn tại không
            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);
            if (empty($variant)) {
                throw new Exception("Biến thể với id = $id không tồn tại!");
            }

            // Xoá các giá trị thuộc bảng variant_values
            $this->variantValue->delete('variantId = :variantId', ['variantId' => $id]);

            // Xoá biến thể chính
            $rowCount = $this->variant->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xoá biến thể thành công!';
            } else {
                throw new Exception('Xoá biến thể không thành công!');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        // Trở về lại form cập nhật biến thể
        header('Location: ' . BASE_URL_ADMIN . '&action=variants-update&productId=' . $productId);
        exit();
    }


}