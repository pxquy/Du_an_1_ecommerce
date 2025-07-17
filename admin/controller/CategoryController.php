<?php
class CategoryController {
    private $category;
    public function __construct(){
        $this->category = new Category();
    }
    public function index(){
        $view = 'categories/index';
        $title = 'Danh sách categories';
        $data = $this->category->select('*', '1 = 1 ORDER BY id ASC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show(){
        try {
            if (!isset($_GET['id'])){
                throw new Exception('thieu "id"', 99);
            }

            $id = $_GET['id'];

            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if(empty($category)){
                throw new Exception("category co ID = $id khong ton tai!");
            }

            $view = 'categories/show';

            $title = "Chi tiet User co category = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
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