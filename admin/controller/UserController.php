<?php
class UserController
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function index()
    {
        $view = 'users/index';
        $title = 'Danh sách user';
        $data = $this->user->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("User co ID = $id khong ton tai!");
            }

            $view = 'users/show';

            $title = "Chi tiet User co Id = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
            exit();
        }
    }
    public function create()
    {
        $view = 'users/create';
        $title = 'Them moi user';

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
                || !empty($this->user->find('*', 'email = :email', ['email' => $data['email']]))
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
                $_SESSION['data'] = $data;

                throw new Exception('Du lieu loi');
            }

            if ($data['avatarUrl']['size'] > 0) {
                $data['avatarUrl'] = upload_file('users', $data['avatarUrl']);
            } else {
                $data['avatarUrl'] = null;
            }

            $rowCount = $this->user->insert($data);

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
        header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
        exit();
    }
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thieu tham so id', 99);
            }

            $id = $_GET['id'];

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("User co ID = $id khong ton tai");
            }

            $view = 'users/edit';
            $title = "Cap nhat USER co ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
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

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("User co id  = $id khong ton tai");
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
                || !empty($this->user->find('*', 'email = :email AND id != :id', ['email' => $data['email'], 'id' => $id]))
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
                $_SESSION['data'] = $data;
                throw new Exception('Du lieu loi');
            }

            if ($data['avatarUrl']['size'] > 0) {
                $data['avatarUrl'] = upload_file('users', $data['avatarUrl']);
            } else {
                $data['avatarUrl'] = $user['avatarUrl'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            $rowCount = $this->user->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (
                    $_FILES['avatarUrl']['size'] > 0
                    && !empty($user['avatarUrl'])
                    && file_exists(PATH_ASSETS_UPLOADS . $user['avatarUrl'])
                ) {
                    unlink(PATH_ASSETS_UPLOADS . $user['avatarUrl']);
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
                header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-edit&id=' . $id);
    }
    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("User co id = $id Khong ton tai!");
            }

            $rowCount = $this->user->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {

                if (!empty($user['avatarUrl']) && file_exists(PATH_ASSETS_UPLOADS . $user['avatarUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $user['avatarUrl']);
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

        header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
        exit();
    }
}