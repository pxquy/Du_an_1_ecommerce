<?php
require_once("./client/model/User.php");
class SignupController
{
    private $client;
    public function __construct()
    {
        $this->client = new User();
    }
    public function locationCreate()
    {
        $view = "pages/site/register/register";
        $title = "Signup";
        require_once PATH_VIEW_CLIENT . $view . ".php";
    }
    public function createUser()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception();
            }

            $data = $_POST + $_FILES;
            $_SESSION['error'] = [];

            // Validate fullname
            if (empty($data['fullname']) || preg_match('/[^\p{L}\p{N}\s]/u', $data['fullname'])) {
                $_SESSION['error']['fullname'] = "Tên không được bỏ trống và không chứa kí tự đặc biệt";
            }

            // Validate email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || empty($data['email'])) {
                $_SESSION['error']['email'] = "Email không được bỏ trống và phải đúng định dạng";
            } elseif (!empty($this->client->find('*', 'email = :email', ['email' => $data['email']]))) {
                $_SESSION['error']['email'] = "Email đã được đăng kí";
            }

            // Validate password
            if (empty($data['password']) || strlen($data['password']) < 6) {
                $_SESSION['error']['password'] = "Mật khẩu không được bỏ trống và phải tối thiểu 6 kí tự";
            }
            if (empty($data['confirmPassword']) || $data['confirmPassword'] != $data['password']) {
                $_SESSION['error']['password'] = "Vui lòng nhập lại mật khẩu và phải khớp với mật khẩu đã đặt";
            }

            // Validate phoneNumber
            if (!empty($data['phoneNumber']) && !preg_match('/^(0[0-9]{9,10})$/', $data['phoneNumber'])) {
                $_SESSION['error']['phoneNumber'] = "Số điện thoại không hợp lệ";
            }

            // Validate avatar
            if ($data['avatarUrl']['size'] > 0) {
                if ($data['avatarUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['avatarUrl_size'] = 'Ảnh chỉ cho phép tối đa 2MB';
                }

                $fileType = $data['avatarUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['error']['avatarUrl_type'] = "Vui lòng dùng ảnh định dạng JPG, JPEG, PNG, GIF.";
                }
            }

            // Nếu có lỗi
            if (!empty($_SESSION['error'])) {
                $_SESSION['data'] = $data;
                throw new Exception("Vui lòng kiểm tra lại các thông tin bạn vừa nhập!");
            }

            // Xử lý avatar
            if ($data['avatarUrl']['size'] > 0) {
                $data['avatarUrl'] = upload_file('users', $data['avatarUrl']);
            } else {
                $data['avatarUrl'] = null;
            }

            // Chèn dữ liệu user
            $rowCount = $this->client->insert([
                'fullname'    => $data['fullname'],
                'email'       => $data['email'],
                'password'    => password_hash($data['password'], PASSWORD_DEFAULT),
                'avatarUrl'   => $data['avatarUrl'],
                'phone_number' => $data['phone_number'] ?? null,
                'address'     => $data['address'] ?? null,
                'createdAt'   => date('Y-m-d H:i:s'),
                'updatedAt'   => date('Y-m-d H:i:s')
            ]);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Đăng kí thành công';
                header('Location: ' . BASE_URL . "?action=form_signin");
                exit();
            } else {
                throw new Exception('Đăng kí thất bại');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL . "?action=signup");
            exit();
        }
    }
}
