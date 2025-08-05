<?php
class CategoryController
{
    private $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        $view = 'categories/index';
        $title = 'Danh sách danh mục';
        $data = $this->category->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục có ID = $id không tồn tại!");
            }

            $view = 'categories/show';
            $title = "Chi tiết danh mục có ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
            exit();
        }
    }

    public function create()
    {
        $view = 'categories/create';
        $title = 'Thêm mới danh mục';

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
                $_SESSION['errors']['title'] = "Tên danh mục là bắt buộc và không vượt quá 50 ký tự.";
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận định dạng JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            $data['logoUrl'] = $data['logoUrl']['size'] > 0
                ? upload_file('categories', $data['logoUrl'])
                : null;

            $data['slug'] = slugify($data['title']);
            $rowCount = $this->category->insert($data);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thêm danh mục thành công.';
            } else {
                throw new Exception('Thêm danh mục không thành công.');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
        exit();
    }

    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục không tồn tại.");
            }

            $view = 'categories/edit';
            $title = "Cập nhật danh mục có ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
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
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục không tồn tại.");
            }

            $data = $_POST + $_FILES;
            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "Tên danh mục là bắt buộc và không vượt quá 50 ký tự.";
            }

            $data['slug'] = slugify($data['title']);

            if (!empty($this->category->find('*', 'slug = :slug AND id != :id', ['slug' => $data['slug'], 'id' => $id]))) {
                $_SESSION['errors']['slug'] = 'Tên danh mục đã tồn tại.';
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận định dạng JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            $data['logoUrl'] = $data['logoUrl']['size'] > 0
                ? upload_file('categories', $data['logoUrl'])
                : $category['logoUrl'];

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->category->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if ($_FILES['logoUrl']['size'] > 0 && !empty($category['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $category['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $category['logoUrl']);
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
                header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-edit&id=' . $id);
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục không tồn tại.");
            }

            $rowCount = $this->category->restore($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục không tồn tại.");
            }

            $rowCount = $this->category->softDelete($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục không tồn tại.");
            }

            $rowCount = $this->category->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (!empty($category['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $category['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $category['logoUrl']);
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

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
        exit();
    }
}
