<?php
class AttributeValueController
{
    private $attributeValue, $attributes;
    public function __construct()
    {
        $this->attributeValue = new AttributeValue();
        $this->attributes = new Attributes();
    }
    public function index()
    {
        $view = 'attributeValues/index';
        $name = 'Danh sách attributeValue';
        $data = $this->attributeValue->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co ID = $id khong ton tai!");
            }

            $view = 'attributeValues/show';

            $name = "Chi tiet AttributeValue co Id = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
            exit();
        }
    }
    public function create()
    {
        $view = 'attributeValues/create';
        $name = 'Them moi attributeValue';
        $attributes = $this->attributes->select();
        $attributePluck = array_column($attributes, 'name', 'id');
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

            if (empty($data['value']) || strlen($data['value']) > 50) {
                $_SESSION['errors']['value'] = "value bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['value'] = trim(strip_tags($data['value']));

            $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            if (!empty($this->attributeValue->find('*', 'value = :value', ['value' => $data['value']]))) {
                $_SESSION['errors']['value'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
            }

            $rowCount = $this->attributeValue->insert($data);

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
        header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-create');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co ID = $id khong ton tai");
            }

            $view = 'attributeValues/edit';
            $name = "Cap nhat AttributeValue co ID = $id";
            $attributes = $this->attributes->select();
            $attributePluck = array_column($attributes, 'name', 'id');
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
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

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co id  = $id khong ton tai");
            }

            $data = $_POST;

            $_SESSION['errors'] = [];

            if (empty($data['value']) || strlen($data['value']) > 50) {
                $_SESSION['errors']['value'] = "value bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['value'] = trim(strip_tags($data['value']));

            $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            if (!empty($this->attributeValue->find('*', 'value = :value AND id != :id', ['value' => $data['value'], 'id' => $id]))) {
                $_SESSION['errors']['value'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->attributeValue->update($data, 'id = :id', ['id' => $id]);

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
                header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributeValue->restore($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributeValue->softDelete($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);

            if (empty($attributeValue)) {
                throw new Exception("AttributeValue co id = $id Khong ton tai!");
            }

            $rowCount = $this->attributeValue->delete('id = :id', ['id' => $id]);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=attributeValues-index');
        exit();
    }
}