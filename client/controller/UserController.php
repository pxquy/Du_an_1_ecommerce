<?php
require_once './client/model/User.php';

class UserController
{
    private $userModel, $orderModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->orderModel = new Order();
    }


    public function userDashboardPage()
    {

        $userId = $_SESSION['user']['id'];

        $recentOrders = $this->orderModel->getOrdersByUser($userId);

        $view = 'pages/user/dashboard/dashboard';
        $title = 'Trang thông tin người dùng';

        require_once PATH_VIEW_CLIENT . $view . '.php';
    }


    public function userOrderPage()
    {

        $userId = $_SESSION['user']['id'];

        $orders = $this->orderModel->getOrdersByUser($userId);

        $view = 'pages/user/order/order';
        $title = 'Trang thông tin người dùng';

        require_once PATH_VIEW_CLIENT . $view . '.php';
    }


    public function showUpdateInfoForm()
    {
        $user = $this->userModel->getUserById($_SESSION['user']['id']);
        $view = 'pages/user/information/information';
        require_once PATH_VIEW_CLIENT . $view . '.php';
    }

    public function handleUpdateInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? null;
            $email = $_POST['email'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone_number'] ?? null;
            $gender = $_POST['gender'] ?? null;
            $avatar = $_FILES['avatarUrl']['name'] ?? null;

            if (!$fullname || !$email) {
                $_SESSION['msg'] = 'Họ tên và Email là bắt buộc.';
                $_SESSION['success'] = false;
                header('Location: ' . BASE_URL . '?action=update_info');
                exit;
            }

            if ($avatar && $_FILES['avatar']['tmp_name']) {
                $uploadPath = 'public/uploads/users/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $avatarPath = $uploadPath . basename($avatar);
                move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
            } else {
                $avatar = null;
            }

            $userId = $_SESSION['user']['id'];
            $success = $this->userModel->updateInfo($userId, $fullname, $email, $address, $phone, $gender, $avatar);

            $_SESSION['msg'] = $success ? 'Cập nhật thành công!' : 'Cập nhật thất bại!';
            $_SESSION['success'] = $success;

            $_SESSION['user'] = array_merge($_SESSION['user'], compact('fullname', 'email', 'address', 'phone', 'gender'));
            if ($avatar) {
                $_SESSION['user']['avatarUrl'] = $avatar;
            }

            header('Location: ' . BASE_URL . '?action=form_update_profile');
            exit();
        } else {
            header('Location: ' . BASE_URL . '?action=update_info');
            exit();
        }
    }

    public function handleChangePassword()
    {
        $userId = $_SESSION['user']['id'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = "Mật khẩu xác nhận không khớp.";
        } elseif (!$this->userModel->checkOldPassword($userId, $oldPassword)) {
            $_SESSION['error_message'] = "Mật khẩu cũ không đúng.";
        } else {
            $this->userModel->updatePassword($userId, $newPassword);
            $_SESSION['success_message'] = "Đổi mật khẩu thành công!";
            // header('Location: ' . BASE_URL . '?action=change_password');
            // exit;
        }
        header('Location: ' . BASE_URL . '?action=change_password');
        exit();
    }
}
