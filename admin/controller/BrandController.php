<?php
class BrandController
{
    private $brand;

    public function __construct()
    {
        $this->brand = new Brand();
    }

    public function index()
    {
        $view = 'brands/index';
        $title = 'Danh sách thương hiệu';

        $data = $this->brand->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu có ID = $id không tồn tại!");
            }

            $view = 'brands/show';
            $title = "";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
            exit();
        }
    }

    public function create()
    {
        $view = 'brands/create';
        $title = 'Thêm mới thương hiệu';

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ.');
            }

            $data = $_POST + $_FILES;
            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "Tên thương hiệu là bắt buộc và không được quá 50 ký tự.";
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            if ($data['logoUrl']['size'] > 0) {
                $data['logoUrl'] = upload_file('brands', $data['logoUrl']);
            } else {
                $data['logoUrl'] = null;
            }

            $data['slug'] = slugify($data['title']);
            $rowCount = $this->brand->insert($data);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thêm thương hiệu thành công.';
            } else {
                throw new Exception('Thêm thương hiệu không thành công.');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }

    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu không tồn tại.");
            }

            $view = 'brands/edit';
            $title = "" ;

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
            exit();
        }
    }

    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ.');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu không tồn tại.");
            }

            $data = $_POST + $_FILES;
            $_SESSION['errors'] = [];
            $data['slug'] = slugify($data['title']);

            if (!empty($this->brand->find('*', 'slug = :slug AND id != :id', ['slug' => $data['slug'], 'id' => $id]))) {
                $_SESSION['errors']['slug'] = 'Tên thương hiệu đã tồn tại.';
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            if ($data['logoUrl']['size'] > 0) {
                $data['logoUrl'] = upload_file('brands', $data['logoUrl']);
            } else {
                $data['logoUrl'] = $brand['logoUrl'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');
            $rowCount = $this->brand->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if ($_FILES['logoUrl']['size'] > 0 && !empty($brand['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $brand['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $brand['logoUrl']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Cập nhật thành công.';
            } else {
                throw new Exception('Cập nhật không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Dòng: ' . $th->getLine();

            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-edit&id=' . $id);
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu không tồn tại.");
            }

            $rowCount = $this->brand->restore($id);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Khôi phục thành công.';
            } else {
                throw new Exception('Khôi phục không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu không tồn tại.");
            }

            $rowCount = $this->brand->softDelete($id);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xóa tạm thời thành công.';
            } else {
                throw new Exception('Xóa tạm thời không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Thương hiệu không tồn tại.");
            }

            $rowCount = $this->brand->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (!empty($brand['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $brand['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $brand['logoUrl']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xóa vĩnh viễn thành công.';
            } else {
                throw new Exception('Xóa không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }
}
