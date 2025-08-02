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
        $data = $this->user->select('*', '1 = 1 ORDER BY id DESC');
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function show() {}
    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function delete() {}
}
