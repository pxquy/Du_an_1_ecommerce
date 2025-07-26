<?php
class AttributeController
{
    private $attributes, $attributeValue;
    public function __construct()
    {
        $this->attributes = new Attributes();
        $this->attributeValue = new AttributeValue();
    }
    public function index()
    {
        // // 1. Xác định class thực sự đang dùng
        // echo '<pre>';
        // echo '[DEBUG] Class của $this->attributes: ' . get_class($this->attributes) . PHP_EOL;

        // // 2. Xem file khai báo class đó (nếu có __FILE__ trong model)
        // if (method_exists($this->attributes, '__debugInfo')) {
        //     var_dump($this->attributes->__debugInfo());
        // }

        // // 3. Liệt kê tất cả method mà instance đó có
        // $methods = get_class_methods($this->attributes);
        // echo "[DEBUG] Phương thức có sẵn trong class " . get_class($this->attributes) . ': ' . PHP_EOL;
        // print_r($methods);

        // echo '</pre>';

        // // Dừng lại để bạn đọc output
        // die;
        $view = 'attributes/index';
        $name = 'Danh sách attributes';
        $data = $this->attributes->select('*', '1=1 ORDER BY id ASC');

        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);
            $attributeValues = $this->attributeValue->select('*', 'attributeId = :attributeId', ['attributeId' => $id]);
            if (empty($attributes)) {
                throw new Exception("Attribute co ID = $id khong ton tai!");
            }

            $view = 'attributes/show';

            $name = "Chi tiet Attribute co Id = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
            exit();
        }
    }
    public function create()
    {
        $view = 'attributes/create';
        $name = 'Them moi attributes';

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

            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = "name bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['name'] = trim(strip_tags($data['name']));

            $data['attributeCode'] = mb_strtoupper($data['name'], 'UTF-8');

            if (!empty($this->attributes->find('*', 'name = :name', ['name' => $data['name']]))) {
                $_SESSION['errors']['name'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
            }

            $rowCount = $this->attributes->insert($data);

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
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-create');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributes)) {
                throw new Exception("Attribute co ID = $id khong ton tai");
            }

            $view = 'attributes/edit';
            $name = "Cap nhat Attribute co ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
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

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributes)) {
                throw new Exception("Attribute co id  = $id khong ton tai");
            }

            $data = $_POST;

            $_SESSION['errors'] = [];

            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = "name bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['name'] = trim(strip_tags($data['name']));

            $data['attributeCode'] = mb_strtoupper($data['name'], 'UTF-8');

            if (!empty($this->attributes->find('*', 'name = :name AND id != :id', ['name' => $data['name'], 'id' => $id]))) {
                $_SESSION['errors']['name'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->attributes->update($data, 'id = :id', ['id' => $id]);

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
                header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributes)) {
                throw new Exception("Attribute co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributes->restore($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributes)) {
                throw new Exception("Attribute co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributes->softDelete($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributes = $this->attributes->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributes)) {
                throw new Exception("Attribute co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributes->delete('id = :id', ['id' => $id]);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }
}