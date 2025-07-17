<?php
class UserController {
    private $user;
    public function __construct(){
        $this->user = new User();
    }
    public function index(){
        $view = 'users/index';
        $title = 'Danh sách user';
        $data = $this->user->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show(){
        try {
            if (!isset($_GET['id'])){
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if(empty($user)){
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
    public function create(){
        $view = 'users/create';
        $title = 'Them moi user';

        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function store(){
        try {
            if($_SERVER['REQUEST_METHOD'] != 'POST'){
                throw new Exception();
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];
            
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=users-create');
        exit();
    }
    public function edit(){}
    public function update(){}

    public function softDelete(){

    }
    public function delete(){
        try{
            if(!isset($_GET['id'])){
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $user = $this->user->find('*', 'id = :id', ['id' => $id]);

            if(empty($user)){
                throw new Exception("User co id = $id Khong ton tai!");
            }

            $rowCount = $this->user->delete('id = :id', ['id' => $id]);

            if($rowCount > 0){
                
                if (!empty($user['avatar']) && file_exists(PATH_ASSETS_UPLOADS . $user['avatarUrl'])){
                    unlink(PATH_ASSETS_UPLOADS . $user['avatarUrl']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'thao tac thanh cong!';
            }  else {
                throw new Exception('Thao tac khong thanh cong!');
            }
        } catch (\Throwable $th){
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=users-index');
        exit();
    } 
}