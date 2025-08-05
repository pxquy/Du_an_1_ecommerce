<?php
class User extends BaseModel
{
    protected $table = 'users';
    public function checkUser($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return ("Vui lòng kiểm tra lại thông tin đăng nhập");
        }
    }
}
