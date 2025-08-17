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
    'users-softDelete' => (new UserController)->softDelete(), //Xóa dữ liệu theo ID
    'users-restore' => (new UserController)->restore(), //Xóa dữ liệu theo ID

    //CRUD brands
    'brands-index' => (new BrandController)->index(), //hiển thị danh sách
    'brands-show' => (new BrandController)->show(), //hiển thị chi tiết ID
    'brands-create' => (new BrandController)->create(), //hiển thị form thêm mới
    'brands-store' => (new BrandController)->store(), //lưu dữ liệu thêm mới
    'brands-edit' => (new BrandController)->edit(), //hiển thị form cập nhật theo ID
    'brands-update' => (new BrandController)->update(), //lưu dữ liệu cập nhật theo ID
    'brands-delete' => (new BrandController)->delete(), //Xóa dữ liệu theo ID
    'brands-softDelete' => (new BrandController)->softDelete(), //Xóa dữ liệu theo ID
    'brands-restore' => (new BrandController)->restore(), //Xóa dữ liệu theo ID

    //CRUD categories
    'categories-index' => (new CategoryController)->index(), //hiển thị danh sách
    'categories-show' => (new CategoryController)->show(), //hiển thị chi tiết ID
    'categories-create' => (new CategoryController)->create(), //hiển thị form thêm mới
    'categories-store' => (new CategoryController)->store(), //lưu dữ liệu thêm mới
    'categories-edit' => (new CategoryController)->edit(), //hiển thị form cập nhật theo ID
    'categories-update' => (new CategoryController)->update(), //lưu dữ liệu cập nhật theo ID
    'categories-delete' => (new CategoryController)->delete(), //Xóa dữ liệu theo ID
    'categories-softDelete' => (new CategoryController)->softDelete(), //Xóa mềm dữ liệu theo ID
    'categories-restore' => (new CategoryController)->restore(), //khôi phục dữ liệu theo ID

    //CRUD products
    'products-index' => (new ProductController)->index(), //hiển thị danh sách
    'products-show' => (new ProductController)->show(), //hiển thị chi tiết ID
    'products-create' => (new ProductController)->create(), //hiển thị form thêm mới
    'products-store' => (new ProductController)->store(), //lưu dữ liệu thêm mới
    'products-edit' => (new ProductController)->edit(), //hiển thị form cập nhật theo ID
    'products-update' => (new ProductController)->update(), //lưu dữ liệu cập nhật theo ID
    'products-delete' => (new ProductController)->delete(), //Xóa dữ liệu theo ID
    'products-softDelete' => (new ProductController)->softDelete(), //Xóa mềm dữ liệu theo ID
    'products-restore' => (new ProductController)->restore(), //Xóa dữ liệu theo ID

    //CRUD attributes
    'attributes-index' => (new AttributeManagerController)->index(),

    'attributes-create' => (new AttributeManagerController)->attributeCreate(),

    'attributes-edit' => (new AttributeManagerController)->attributeEdit(),

    'attributes-store' => (new AttributeManagerController)->attributeStore(),

    'attributes-update' => (new AttributeManagerController)->attributeUpdate(),

    'attributes-softDelete' => (new AttributeManagerController)->attributeSoftDelete(),

    'attributes-restore' => (new AttributeManagerController)->attributeRestore(),

    'attributeValues-create' => (new AttributeManagerController)->valueCreate(),

    'attributeValues-edit' => (new AttributeManagerController)->valueEdit(),

    'attributeValues-store' => (new AttributeManagerController)->valueStore(),

    'attributeValues-update' => (new AttributeManagerController)->valueUpdate(),

    'attributeValues-softDelete' => (new AttributeManagerController)->valueSoftDelete(),

    'attributeValues-restore' => (new AttributeManagerController)->valueRestore(),

    //CRUD attributeValues
    'variants-index' => (new VariantController)->index(), //hiển thị danh sách
    'variants-show' => (new VariantController)->show(), //hiển thị chi tiết ID
    'variants-create' => (new VariantController)->create(), //hiển thị form thêm mới
    'variants-store' => (new VariantController)->store(), //lưu dữ liệu thêm mới
    'variants-edit' => (new VariantController)->edit(), //hiển thị form cập nhật theo ID
    'variants-update' => (new VariantController)->update(), //lưu dữ liệu cập nhật theo ID
    'variants-delete' => (new VariantController)->delete(), //Xóa dữ liệu theo ID

    //order
    'orders-index' => (new OrderController)->index(),
    'orders-show' => (new OrderController)->show(),
    'orders-updateStatus' => (new OrderController)->updateStatus(),
    'orders-softDelete' => (new OrderController)->softDelete(),

    //comment
    'reply_comment' => (new ProductController)->replyComment(),
    'comments-reply' => (new CommentController)->reply(),
    'comments-index' => (new CommentController)->index(), //hiển thị danh sách
    'comments-show' => (new CommentController)->show(), //hiển thị chi tiết ID
    'comments-create' => (new CommentController)->create(), //hiển thị form thêm mới
    'comments-store' => (new CommentController)->store(), //lưu dữ liệu thêm mới
    'comments-edit' => (new CommentController)->edit(), //hiển thị form cập nhật theo ID
    'comments-update' => (new CommentController)->update(), //lưu dữ liệu cập nhật theo ID
    'comments-softDelete' => (new CommentController)->softDelete(), //Xóa dữ liệu theo ID
    'comments-restore' => (new CommentController)->restore(), //Xóa dữ liệu theo ID

};
