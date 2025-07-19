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
        $title = 'Danh sách người dùng';
        $page = $_GET['page'] ?? 1;
        $perPage = 5;
        $keyword = $_GET['search'] ?? null;
        $role = $_GET['role'] ?? null;
        $status = $_GET['status'] ?? null;

        $condition = '1=1';
        $params = [];

        if ($keyword) {
            $condition .= ' AND fullname LIKE :kw';
            $params['kw'] = "%$keyword%";
        }

        if ($role !== null && $role !== '') {
            $condition .= ' AND role = :role';
            $params['role'] = $role;
        }

        if ($status !== null && $status !== '') {
            $condition .= ' AND isActive = :status';
            $params['status'] = $status;
        }

        $total = $this->user->count($condition, $params);
        $data = $this->user->paginate($page, $perPage, '*', $condition, $params);

        if (!empty($_GET['ajax'])) {
            echo json_encode([
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
            ]);
            exit;
        }

        require_once PATH_VIEW_ADMIN_MAIN;
    }


    public function show()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số ID', 99);

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);
            if (empty($user))
                throw new Exception("Người dùng có ID = $id không tồn tại!");

            $view = 'users/show';
            $title = "Chi tiết người dùng ID = $id";
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
        $title = 'Thêm người dùng mới';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST')
                throw new Exception();

            $data = $_POST + $_FILES;
            $errors = $this->validate($data);

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ');
            }

            $data['avatarUrl'] = $data['avatarUrl']['size'] > 0 ? upload_file('users', $data['avatarUrl']) : null;

            if ($this->user->insert($data) > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thêm người dùng thành công';
            } else {
                throw new Exception('Không thể thêm người dùng');
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
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số ID', 99);

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);
            if (empty($user))
                throw new Exception("Người dùng có ID = $id không tồn tại");

            $view = 'users/edit';
            $title = "Cập nhật người dùng ID = $id";
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
            if ($_SERVER['REQUEST_METHOD'] != 'POST')
                throw new Exception('Yêu cầu phải dùng phương thức POST');
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số ID', 99);

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);
            if (empty($user))
                throw new Exception("Người dùng có ID = $id không tồn tại");

            $data = $_POST + $_FILES;
            $errors = $this->validate($data, $id);

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ');
            }

            if ($data['avatarUrl']['size'] > 0) {
                $data['avatarUrl'] = upload_file('users', $data['avatarUrl']);
                if (!empty($user['avatarUrl']) && file_exists(PATH_ASSETS_UPLOADS . $user['avatarUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $user['avatarUrl']);
                }
            } else {
                $data['avatarUrl'] = $user['avatarUrl'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');

            if ($this->user->update($data, 'id = :id', ['id' => $id]) > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Cập nhật người dùng thành công';
            } else {
                throw new Exception('Không thể cập nhật người dùng');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-show&id=' . $id);
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id']))
                throw new Exception('Thiếu tham số ID', 99);

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);
            if (empty($user))
                throw new Exception("Người dùng có ID = $id không tồn tại");

            if ($this->user->delete('id = :id', ['id' => $id]) > 0) {
                if (!empty($user['avatarUrl']) && file_exists(PATH_ASSETS_UPLOADS . $user['avatarUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $user['avatarUrl']);
                }
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xóa người dùng thành công';
            } else {
                throw new Exception('Không thể xóa người dùng');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("Người dùng có ID = $id không tồn tại!");
            }

            $rowCount = $this->user->softDelete($id); // Cần triển khai phương thức softDelete trong model

            if ($rowCount <= 0) {
                throw new Exception('Khóa không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Khóa người dùng thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-index&id=' . $id);
        exit();
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số ID', 99);
            }

            $id = $_GET['id'];
            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if (empty($user)) {
                throw new Exception("Người dùng có ID = $id không tồn tại!");
            }

            $rowCount = $this->user->restore($id); // Cần triển khai phương thức restore trong model

            if ($rowCount <= 0) {
                throw new Exception('Khôi phục không thành công!');
            }

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Khôi phục người dùng thành công.';
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-index&id=' . $id);
        exit();
    }

    private function validate($data, $id = null)
    {
        $errors = [];

        if (empty($data['fullname']) || strlen($data['fullname']) > 50) {
            $errors['fullname'] = 'Họ tên bắt buộc và không quá 50 ký tự';
        }

        if (
            empty($data['email']) ||
            strlen($data['email']) > 100 ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
            !empty($this->user->find('*', 'email = :email' . ($id ? ' AND id != :id' : ''), $id ? ['email' => $data['email'], 'id' => $id] : ['email' => $data['email']]))
        ) {
            $errors['email'] = 'Email bắt buộc, hợp lệ, dưới 100 ký tự và không trùng lặp';
        }

        if (empty($data['password']) || strlen($data['password']) < 6 || strlen($data['password']) > 30) {
            $errors['password'] = 'Mật khẩu bắt buộc, từ 6 đến 30 ký tự';
        }

        if ($data['avatarUrl']['size'] > 0) {
            if ($data['avatarUrl']['size'] > 2 * 1024 * 1024) {
                $errors['avatarUrl_size'] = 'Ảnh đại diện tối đa 2MB';
            }

            $allowed = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($data['avatarUrl']['type'], $allowed)) {
                $errors['avatarUrl_type'] = 'Chỉ chấp nhận ảnh JPG, JPEG, PNG, GIF';
            }
        }

        return $errors;
    }
}
