<?php
class BannerController
{
    private $banner;
    public function __construct()
    {
        $this->banner = new Banner();
    }
    public function index()
    {
        $view = 'banners/index';
        $title = 'Danh sách banner';
        $data = $this->banner->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $banner = $this->banner->find('*', 'id = :id', ['id' => $id]);

            if (empty($banner)) {
                throw new Exception("Banner co ID = $id khong ton tai!");
            }

            $view = 'banners/show';

            $title = "Chi tiet Banner co Id = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=banners-index');
            exit();
        }
    }
    public function create()
    {
        $view = 'banners/create';
        $title = 'Them moi banner';

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

            if (empty($data['fullname']) || strlen($data['fullname']) > 50) {
                $_SESSION['errors']['fullname'] = "fullname bắt buộc và độ dài dưới 50 ký tự. ";
            }

            if (
                empty($data['email'])
                || strlen($data['email']) > 100
                || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
                || !empty($this->banner->find('*', 'email = :email', ['email' => $data['email']]))
            ) {
                $_SESSION['errors']['email'] = 'Truong email bat buoc, do dai khong qua 100 ky tu va khong duoc trung';
            }

            if (empty($data['password']) || strlen($data['password']) < 6 || strlen($data['password']) > 30) {
                $_SESSION['errors']['password'] = 'Truong password bat buoc do dai trong khoang tu 6 - 30 ky tu';
            }

            if ($data['avatarUrl']['size'] > 0) {

                if ($data['avatarUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['avatarUrl_size'] = 'Truong avatarUrl co dung luong toi da 2MB';
                }

                $fileType = $data['avatarUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['avatarUrl_type'] = "xin loi chi chap nhan cac loai file JPG, JPEG, PNG, GIF. ";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $data['id'] = genId(4, 'banner-');
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
            }

            if ($data['avatarUrl']['size'] > 0) {
                $data['avatarUrl'] = upload_file('banners', $data['avatarUrl']);
            } else {
                $data['avatarUrl'] = null;
            }

            $rowCount = $this->banner->insert($data);

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
        header('Location: ' . BASE_URL_ADMIN . '&action=banners-index');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $banner = $this->banner->find('*', 'id = :id', ['id' => $id]);

            if (empty($banner)) {
                throw new Exception("Banner co ID = $id khong ton tai");
            }

            $view = 'banners/edit';
            $title = "Cap nhat USER co ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=banners-index');
            exit();
        }
    }
    public function update()
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Line: ' . $th->getLine();

            if ($th->getCode() == 99) {
                header('Location :' . BASE_URL_ADMIN . '&action=banners-index');
                exit();
            }
        }

        header('Location :' . BASE_URL_ADMIN . '&action=banners-edit&id=' . $id);
    }

    public function softDelete()
    {

    }
    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $banner = $this->banner->find('*', 'id = :id', ['id' => $id]);

            if (empty($banner)) {
                throw new Exception("Banner co id = $id Khong ton tai!");
            }

            $rowCount = $this->banner->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {

                if (!empty($banner['avatarUrl']) && file_exists(PATH_ASSETS_UPLOADS . $banner['avatarUrlUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $banner['avatarUrlUrl']);
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

        header('Location: ' . BASE_URL_ADMIN . '&action=banners-index');
        exit();
    }
}