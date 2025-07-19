<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new DashboardController)->index(),

    //CRUD users
    'users-index' => (new UserController)->index(), //hiển thị danh sách
    'users-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'users-create' => (new UserController)->create(), //hiển thị form thêm mới
    'users-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'users-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'users-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'users-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
};
