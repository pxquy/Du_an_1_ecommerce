<?php 
class VariantController
{
    private $variant, $attributes, $attributeValue, $product;
    public function __construct()
    {
        $this->variant = new Variant();
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

            $name = "Chi tiet AttributeValue co Id = $id";

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
        $name = 'Them moi variant';
        $attributes = $this->attributes->select();
        foreach ($attributes as $attribute ){
            
        }
        $attributePluck = array_column($attributes, 'name', 'id');
        $products = $this->product->select();
        $productPluck = array_column($products, 'title', 'id');
        $productOldPrices = [];

        foreach ($products as $product) {
            $productOldPrices[$product['id']] = $product['priceDefault'];
        }
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Method phai la POST');
            }

            $data = $_POST;

            $_SESSION['errors'] = [];

            $data['value'] = trim(strip_tags($data['value']));



            $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            if (!empty($this->variant->find('*', 'value = :value', ['value' => $data['value']]))) {
                $_SESSION['errors']['value'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
            }

            $rowCount = $this->variant->insert($data);

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
        header('Location: ' . BASE_URL_ADMIN . '&action=variants-create');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co ID = $id khong ton tai");
            }

            $view = 'variants/edit';
            $name = "Cap nhat AttributeValue co ID = $id";
            $attributes = $this->attributes->select();
            $attributePluck = array_column($attributes, 'name', 'id');
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
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

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co id  = $id khong ton tai");
            }

            $data = $_POST;

            $_SESSION['errors'] = [];

            if (empty($data['value']) || strlen($data['value']) > 50) {
                $_SESSION['errors']['value'] = "value bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['value'] = trim(strip_tags($data['value']));

            $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            if (!empty($this->variant->find('*', 'value = :value AND id != :id', ['value' => $data['value'], 'id' => $id]))) {
                $_SESSION['errors']['value'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->variant->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong';
            } else {
                throw new Exception('thao tac khong thanh cong!');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Line: ' . $th->getLine();
            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=variants-index');
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
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $variant = $this->variant->find('*', 'id = :id', ['id' => $id]);

            if (empty($variant)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->variant->delete('id = :id', ['id' => $id]);

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
}