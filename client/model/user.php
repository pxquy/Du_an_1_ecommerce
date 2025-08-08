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
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateUser($id, $name, $email, $newPassword = null)
    {
        if ($newPassword) {
            $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
            $params = [
                ':name' => $name,
                ':email' => $email,
                ':password' => password_hash($newPassword, PASSWORD_BCRYPT),
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
            $params = [
                ':name' => $name,
                ':email' => $email,
                ':id' => $id
            ];
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    public function updateInfo($id, $fullname, $email, $address, $phone, $gender, $avatar = null)
    {
        if ($avatar) {
            $sql = "UPDATE users 
                SET fullname = :fullname, email = :email, address = :address, phone_number = :phone, gender = :gender, avatarUrl = :avatar 
                WHERE id = :id";
            $params = compact('fullname', 'email', 'address', 'phone', 'gender', 'avatar');
        } else {
            $sql = "UPDATE users 
                SET fullname = :fullname, email = :email, address = :address, phone_number = :phone, gender = :gender 
                WHERE id = :id";
            $params = compact('fullname', 'email', 'address', 'phone', 'gender');
        }

        $params['id'] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }


    public function updatePassword($id, $newPassword)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_BCRYPT),
            ':id' => $id
        ]);
    }

    public function checkOldPassword($id, $oldPassword)
    {
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($oldPassword, $user['password']);
    }
}
