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
        $title = 'Danh sách brand';
        $data = $this->brand->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co ID = $id khong ton tai!");
            }

            $view = 'brands/show';

            $title = "Chi tiet Brand co Id = $id";

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
        $title = 'Them moi brand';

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

            if ($data['logoUrl']['size'] > 0) {

                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Truong logoUrl co dung luong toi da 2MB';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "xin loi chi chap nhan cac loai file JPG, JPEG, PNG, GIF. ";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
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
                $_SESSION['msg'] = 'Thao tac thanh cong';
            } else {
                throw new Exception('Thao tac khong thanh cong');
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
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co ID = $id khong ton tai");
            }

            $view = 'brands/edit';
            $title = "Cap nhat Brand co ID = $id";

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
                throw new Exception('Yeu cau phuong thuc phai la POST');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so "id"', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co id  = $id khong ton tai");
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "title bắt buộc và độ dài dưới 50 ký tự. ";
            }

            $data['slug'] = slugify($data['title']);

            if (
                !empty(
                $this->brand->find(
                    '*',
                    'slug = :slug AND id != :id',
                    [
                        'slug' => $data['slug'],
                        'id' => $id
                    ]
                )
            )
            ) {
                $_SESSION['errors']['slug'] = 'Tên thương hiệu đã tồn tại.';
            }

            if ($data['logoUrl']['size'] > 0) {

                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Truong logoUrl co dung luong toi da 2MB';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "xin loi chi chap nhan cac loai file JPG, JPEG, PNG, GIF. ";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            if ($data['logoUrl']['size'] > 0) {
                $data['logoUrl'] = upload_file('brands', $data['logoUrl']);
            } else {
                $data['logoUrl'] = $brand['logoUrl'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->brand->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (
                    $_FILES['logoUrl']['size'] > 0
                    && !empty($brand['logoUrl'])
                    && file_exists(PATH_ASSETS_UPLOADS . $brand['logoUrl'])
                ) {
                    unlink(PATH_ASSETS_UPLOADS . $brand['logoUrl']);
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
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co id = $id Khong ton tai!");
            }

            $rowCount = $this->brand->restore($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co id = $id Khong ton tai!");
            }

            $rowCount = $this->brand->softDelete($id);

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

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $brand = $this->brand->find('*', 'id = :id', ['id' => $id]);

            if (empty($brand)) {
                throw new Exception("Brand co id = $id Khong ton tai!");
            }

            $rowCount = $this->brand->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {

                if (!empty($brand['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $brand['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $brand['logoUrl']);
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

        header('Location: ' . BASE_URL_ADMIN . '&action=brands-index');
        exit();
    }
}