<?php
require_once("./client/model/user.php");
class SigninController
{
    protected $client;
    public function __construct()
    {
        $this->client = new User();
    }
    public function locationSignin()
    {
        $views = "pages/site/login/login";
        $title = "Đăng nhập";
        require_once PATH_VIEW_CLIENT . $views . '.php';
    }
    public function signin()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception("Yêu cầu phương thức phải là POST");
            }

            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if (empty($email) || empty($password)) {
                throw new Exception("Email và mật khẩu không được bỏ trống");
            }

            // Lấy người dùng theo email
            $user = $this->client->find(
                '*',
                'email = :email',
                ['email' => $email]
            );

            if (empty($user)) {
                $_SESSION['error_message'] = "Email không tồn tại";
            }
            // echo 'Nhập: ' . $password . "<br>";
            // echo 'Trong DB: ' . $user['password'] . "<br>";
            // var_dump(password_verify($password, $user['password']));
            // die();

            // $user = $user[0];
            // debug($user);

            // Kiểm tra password
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error_message'] = "Mật khẩu không chính xác";
            }



            $_SESSION['user'] = $user;
            // require_Login();
            $_SESSION['success_message'] = 'Đăng nhập thành công';
            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Đăng nhập thành công';

            header("Location: " . BASE_URL);
            exit();
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . BASE_URL . "?action=form_signin");
            exit();
        }
    }
    public function logout()
    {
        session_destroy();
        header("Location:" . BASE_URL . "?action=form_signin");
    }
}
