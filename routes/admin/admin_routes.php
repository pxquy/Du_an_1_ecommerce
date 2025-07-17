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
    
    //CRUD brands
    'brands-index' => (new UserController)->index(), //hiển thị danh sách
    'brands-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'brands-create' => (new UserController)->create(), //hiển thị form thêm mới
    'brands-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'brands-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'brands-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'brands-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD categories
    'categories-index' => (new CategoryController)->index(), //hiển thị danh sách
    'categories-show' => (new CategoryController)->show(), //hiển thị chi tiết ID
    'categories-create' => (new CategoryController)->create(), //hiển thị form thêm mới
    'categories-store' => (new CategoryController)->store(), //lưu dữ liệu thêm mới
    'categories-edit' => (new CategoryController)->edit(), //hiển thị form cập nhật theo ID
    'categories-update' => (new CategoryController)->update(), //lưu dữ liệu cập nhật theo ID
    'categories-delete' => (new CategoryController)->delete(), //Xóa dữ liệu theo ID

    //CRUD products
    'products-index' => (new UserController)->index(), //hiển thị danh sách
    'products-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'products-create' => (new UserController)->create(), //hiển thị form thêm mới
    'products-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'products-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'products-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'products-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD banners
    'banners-index' => (new UserController)->index(), //hiển thị danh sách
    'banners-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'banners-create' => (new UserController)->create(), //hiển thị form thêm mới
    'banners-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'banners-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'banners-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'banners-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD slideshows
    'slideshows-index' => (new UserController)->index(), //hiển thị danh sách
    'slideshows-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'slideshows-create' => (new UserController)->create(), //hiển thị form thêm mới
    'slideshows-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'slideshows-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'slideshows-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'slideshows-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD news
    'news-index' => (new UserController)->index(), //hiển thị danh sách
    'news-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'news-create' => (new UserController)->create(), //hiển thị form thêm mới
    'news-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'news-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'news-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'news-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
    
    //CRUD orders
    'orders-index' => (new UserController)->index(), //hiển thị danh sách
    'orders-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'orders-create' => (new UserController)->create(), //hiển thị form thêm mới
    'orders-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'orders-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'orders-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'orders-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
    
    //CRUD comments
    'comments-index' => (new UserController)->index(), //hiển thị danh sách
    'comments-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'comments-create' => (new UserController)->create(), //hiển thị form thêm mới
    'comments-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'comments-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'comments-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'comments-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
    
    //CRUD vouchers
    'vouchers-index' => (new UserController)->index(), //hiển thị danh sách
    'vouchers-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'vouchers-create' => (new UserController)->create(), //hiển thị form thêm mới
    'vouchers-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'vouchers-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'vouchers-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'vouchers-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD attributes
    'attributes-index' => (new UserController)->index(), //hiển thị danh sách
    'attributes-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'attributes-create' => (new UserController)->create(), //hiển thị form thêm mới
    'attributes-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'attributes-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'attributes-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'attributes-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID

    //CRUD attributeValues
    'attributeValues-index' => (new UserController)->index(), //hiển thị danh sách
    'attributeValues-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'attributeValues-create' => (new UserController)->create(), //hiển thị form thêm mới
    'attributeValues-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'attributeValues-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'attributeValues-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'attributeValues-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
    
    //CRUD variants
    'variants-index' => (new UserController)->index(), //hiển thị danh sách
    'variants-show' => (new UserController)->show(), //hiển thị chi tiết ID
    'variants-create' => (new UserController)->create(), //hiển thị form thêm mới
    'variants-store' => (new UserController)->store(), //lưu dữ liệu thêm mới
    'variants-edit' => (new UserController)->edit(), //hiển thị form cập nhật theo ID
    'variants-update' => (new UserController)->update(), //lưu dữ liệu cập nhật theo ID
    'variants-delete' => (new UserController)->delete(), //Xóa dữ liệu theo ID
};