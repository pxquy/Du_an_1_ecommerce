<?php
class AttributeManagerController
{
    private $attributes, $attributeValue;

    public function __construct()
    {
        $this->attributes = new Attributes();
        $this->attributeValue = new AttributeValue();
    }

    /* ======================= COMMON INDEX (trang chia đôi) ======================= */
    public function index()
    {
        $view = 'attributes/index';
        $name = 'Quản lý thuộc tính & giá trị';

        $attributes = $this->attributes->select('*', '1=1 ORDER BY id DESC');
        $attributeValues = $this->attributeValue->select('*', '1=1 ORDER BY id DESC');
        $attributePluck = array_column($attributes, 'name', 'id');

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    /* ======================= ATTRIBUTE (THUỘC TÍNH) ======================= */
    public function attributeCreate()
    {
        $view = 'attributes/create';
        $name = 'Thêm mới thuộc tính';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function attributeEdit()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số id', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributes->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");

            $view = 'attributes/edit';
            $name = "Cập nhật thuộc tính #$id";
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
            exit();
        }
    }

    public function attributeStore()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                throw new Exception('Method phải là POST');

            $data = $_POST;
            $_SESSION['errors'] = [];
            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = "Tên thuộc tính bắt buộc (<= 50 ký tự).";
            }
            $data['name'] = trim(strip_tags($data['name']));
            $data['description'] = isset($data['description']) ? trim(strip_tags($data['description'])) : '';
            if (strlen($data['description']) > 255) {
                $_SESSION['errors']['description'] = "Mô tả không được vượt quá 255 ký tự.";
            }


            if (!empty($this->attributes->find('*', 'name = :name', ['name' => $data['name']]))) {
                $_SESSION['errors']['name'] = 'Tên thuộc tính đã tồn tại';
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu lỗi');
            }

            $row = $this->attributes->insert($data);
            if ($row <= 0)
                throw new Exception('Thêm thuộc tính không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Thêm thuộc tính thành công';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function attributeUpdate()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                throw new Exception('Method phải là POST');
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số "id"', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributes->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");

            $data = $_POST;
            $_SESSION['errors'] = [];
            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = "Tên thuộc tính bắt buộc (<= 50 ký tự).";
            }
            $data['name'] = trim(strip_tags($data['name']));


            if (!empty($this->attributes->find('*', 'name = :name AND id != :id', ['name' => $data['name'], 'id' => $id]))) {
                $_SESSION['errors']['name'] = 'Tên thuộc tính đã tồn tại';
            }
            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu lỗi');
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');
            $row = $this->attributes->update($data, 'id = :id', ['id' => $id]);
            if ($row <= 0)
                throw new Exception('Cập nhật không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật thành công';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
                exit();
            }
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function attributeSoftDelete()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu "id"', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributes->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");

            $row = $this->attributes->update(
                ['isActive' => 0],
                'id = :id',
                ['id' => $id]
            );
            if ($row <= 0)
                throw new Exception('Xoá mềm không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã xoá (mềm) thuộc tính';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function attributeRestore()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu "id"', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributes->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");

            $row = $this->attributes->update(
                ['isActive' => 1],
                'id = :id',
                ['id' => $id]
            );
            if ($row <= 0)
                throw new Exception('Khôi phục không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã khôi phục thuộc tính';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    /* ======================= ATTRIBUTE VALUES (GIÁ TRỊ) ======================= */
    public function valueCreate()
    {
        $view = 'attributeValues/create';
        $name = 'Thêm mới giá trị thuộc tính';
        $attributes = $this->attributes->select();
        $attributePluck = array_column($attributes, 'name', 'id');
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function valueEdit()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số id', 99);
            $id = (int) $_GET['id'];

            $attributeValue = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);
            if (empty($attributeValue))
                throw new Exception("Giá trị thuộc tính ID = $id không tồn tại");

            $view = 'attributeValues/edit';
            $name = "Cập nhật giá trị thuộc tính #$id";
            $attributes = $this->attributes->select();
            $attributePluck = array_column($attributes, 'name', 'id');
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
            exit();
        }
    }

    public function valueStore()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                throw new Exception('Method phải là POST');

            $data = $_POST;
            $_SESSION['errors'] = [];
            if (empty($data['attributeId']))
                $_SESSION['errors']['attributeId'] = 'Chọn thuộc tính';
            if (empty($data['value']) || strlen($data['value']) > 50) {
                $_SESSION['errors']['value'] = "Giá trị bắt buộc (<= 50 ký tự).";
            }

            $data['attributeId'] = (int) $data['attributeId'];
            $data['value'] = trim(strip_tags($data['value']));
            // $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            // Kiểm tra thuộc tính tồn tại
            $attr = $this->attributes->find('*', 'id = :id', ['id' => $data['attributeId']]);
            if (empty($attr))
                $_SESSION['errors']['attributeId'] = 'Thuộc tính không tồn tại';

            // Trùng giá trị trong CÙNG thuộc tính
            $dup = $this->attributeValue->find(
                '*',
                'attributeId = :attributeId AND value = :value',
                ['attributeId' => $data['attributeId'], 'value' => $data['value']]
            );
            if (!empty($dup))
                $_SESSION['errors']['value'] = 'Giá trị đã tồn tại trong thuộc tính này';

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu lỗi');
            }

            $row = $this->attributeValue->insert($data);
            if ($row <= 0)
                throw new Exception('Thêm giá trị không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Thêm giá trị thành công';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function valueUpdate()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                throw new Exception('Method phải là POST');
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số "id"', 99);
            $id = (int) $_GET['id'];

            $valueRow = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);
            if (empty($valueRow))
                throw new Exception("Giá trị thuộc tính ID = $id không tồn tại");

            $data = $_POST;
            $_SESSION['errors'] = [];
            if (empty($data['attributeId']))
                $_SESSION['errors']['attributeId'] = 'Chọn thuộc tính';
            if (empty($data['value']) || strlen($data['value']) > 50) {
                $_SESSION['errors']['value'] = "Giá trị bắt buộc (<= 50 ký tự).";
            }

            $data['attributeId'] = (int) $data['attributeId'];
            $data['value'] = trim(strip_tags($data['value']));
            $data['valueCode'] = mb_strtoupper($data['value'], 'UTF-8');

            // Validate thuộc tính
            $attr = $this->attributes->find('*', 'id = :id', ['id' => $data['attributeId']]);
            if (empty($attr))
                $_SESSION['errors']['attributeId'] = 'Thuộc tính không tồn tại';

            // Trùng trong cùng thuộc tính (ngoại trừ chính nó)
            $dup = $this->attributeValue->find(
                '*',
                'attributeId = :attributeId AND value = :value AND id != :id',
                ['attributeId' => $data['attributeId'], 'value' => $data['value'], 'id' => $id]
            );
            if (!empty($dup))
                $_SESSION['errors']['value'] = 'Giá trị đã tồn tại trong thuộc tính này';

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu lỗi');
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');
            $row = $this->attributeValue->update($data, 'id = :id', ['id' => $id]);
            if ($row <= 0)
                throw new Exception('Cập nhật không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật thành công';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
                exit();
            }
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function valueSoftDelete()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu "id"', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");
            $row = $this->attributeValue->update(
                ['isActive' => 0],
                'id = :id',
                ['id' => $id]
            );
            if ($row <= 0)
                throw new Exception('Xoá mềm không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã xoá (mềm) giá trị thuộc tính';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    public function valueRestore()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu "id"', 99);
            $id = (int) $_GET['id'];

            $attribute = $this->attributeValue->find('*', 'id = :id', ['id' => $id]);
            if (empty($attribute))
                throw new Exception("Thuộc tính ID = $id không tồn tại");
            $row = $this->attributeValue->update(
                ['isActive' => 1],
                'id = :id',
                ['id' => $id]
            );
            if ($row <= 0)
                throw new Exception('Khôi phục không thành công');

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đã khôi phục giá trị thuộc tính';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=attributes-index');
        exit();
    }

    /* ============ KHÔNG hỗ trợ xoá cứng. Nếu có route cũ `...-delete`, hãy trỏ về softDelete. ============ */
}
