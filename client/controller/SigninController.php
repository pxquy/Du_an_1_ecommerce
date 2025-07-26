<?php
require_once("./client/models/user.php");
class SigninController
{
    protected $client;
    public function __construct()
    {
        $this->client = new User();
    }
    public function locationSignin()
    {
        $views = "/signin";
        $title = "signin";
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
            $user = $this->client->find(
                '*',
                'email=:email AND password = :password',
                [
                    'email' => $email,
                    'password' => $password
                ]
            );
            if (empty($user)) {
                throw new Exception("Thông tin tài khoản hoặc mật khẩu không chính xác");
            }
            $_SESSION['user'] = $user;
            // debug($user);
            header("Location:" . BASE_URL);
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
