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

    //CRUD banners
    'banners-index' => (new BannerController)->index(), //hiển thị danh sách
    'banners-show' => (new BannerController)->show(), //hiển thị chi tiết ID
    'banners-create' => (new BannerController)->create(), //hiển thị form thêm mới
    'banners-store' => (new BannerController)->store(), //lưu dữ liệu thêm mới
    'banners-edit' => (new BannerController)->edit(), //hiển thị form cập nhật theo ID
    'banners-update' => (new BannerController)->update(), //lưu dữ liệu cập nhật theo ID
    'banners-delete' => (new BannerController)->delete(), //Xóa dữ liệu theo ID

    //CRUD slideshows
    'slideshows-index' => (new SlideshowController)->index(), //hiển thị danh sách
    'slideshows-show' => (new SlideshowController)->show(), //hiển thị chi tiết ID
    'slideshows-create' => (new SlideshowController)->create(), //hiển thị form thêm mới
    'slideshows-store' => (new SlideshowController)->store(), //lưu dữ liệu thêm mới
    'slideshows-edit' => (new SlideshowController)->edit(), //hiển thị form cập nhật theo ID
    'slideshows-update' => (new SlideshowController)->update(), //lưu dữ liệu cập nhật theo ID
    'slideshows-delete' => (new SlideshowController)->delete(), //Xóa dữ liệu theo ID

    //CRUD news
    'news-index' => (new NewsController)->index(), //hiển thị danh sách
    'news-show' => (new NewsController)->show(), //hiển thị chi tiết ID
    'news-create' => (new NewsController)->create(), //hiển thị form thêm mới
    'news-store' => (new NewsController)->store(), //lưu dữ liệu thêm mới
    'news-edit' => (new NewsController)->edit(), //hiển thị form cập nhật theo ID
    'news-update' => (new NewsController)->update(), //lưu dữ liệu cập nhật theo ID
    'news-delete' => (new NewsController)->delete(), //Xóa dữ liệu theo ID

    //CRUD orders
    'orders-index' => (new OrderController)->index(), //hiển thị danh sách
    'orders-show' => (new OrderController)->show(), //hiển thị chi tiết ID
    'orders-create' => (new OrderController)->create(), //hiển thị form thêm mới
    'orders-store' => (new OrderController)->store(), //lưu dữ liệu thêm mới
    'orders-edit' => (new OrderController)->edit(), //hiển thị form cập nhật theo ID
    'orders-update' => (new OrderController)->update(), //lưu dữ liệu cập nhật theo ID
    'orders-delete' => (new OrderController)->delete(), //Xóa dữ liệu theo ID

    //CRUD comments
    'comments-index' => (new CommentController)->index(), //hiển thị danh sách
    'comments-show' => (new CommentController)->show(), //hiển thị chi tiết ID
    'comments-create' => (new CommentController)->create(), //hiển thị form thêm mới
    'comments-store' => (new CommentController)->store(), //lưu dữ liệu thêm mới
    'comments-edit' => (new CommentController)->edit(), //hiển thị form cập nhật theo ID
    'comments-update' => (new CommentController)->update(), //lưu dữ liệu cập nhật theo ID
    'comments-delete' => (new CommentController)->delete(), //Xóa dữ liệu theo ID

    //CRUD vouchers
    'vouchers-index' => (new VoucherController)->index(), //hiển thị danh sách
    'vouchers-show' => (new VoucherController)->show(), //hiển thị chi tiết ID
    'vouchers-create' => (new VoucherController)->create(), //hiển thị form thêm mới
    'vouchers-store' => (new VoucherController)->store(), //lưu dữ liệu thêm mới
    'vouchers-edit' => (new VoucherController)->edit(), //hiển thị form cập nhật theo ID
    'vouchers-update' => (new VoucherController)->update(), //lưu dữ liệu cập nhật theo ID
    'vouchers-delete' => (new VoucherController)->delete(), //Xóa dữ liệu theo ID

    //CRUD attributes
    'attributes-index' => (new AttributeController)->index(), //hiển thị danh sách
    'attributes-show' => (new AttributeController)->show(), //hiển thị chi tiết ID
    'attributes-create' => (new AttributeController)->create(), //hiển thị form thêm mới
    'attributes-store' => (new AttributeController)->store(), //lưu dữ liệu thêm mới
    'attributes-edit' => (new AttributeController)->edit(), //hiển thị form cập nhật theo ID
    'attributes-update' => (new AttributeController)->update(), //lưu dữ liệu cập nhật theo ID
    'attributes-delete' => (new AttributeController)->delete(), //Xóa dữ liệu theo ID

    //CRUD attributeValues
    'attributeValues-index' => (new AttributeValueController)->index(), //hiển thị danh sách
    'attributeValues-show' => (new AttributeValueController)->show(), //hiển thị chi tiết ID
    'attributeValues-create' => (new AttributeValueController)->create(), //hiển thị form thêm mới
    'attributeValues-store' => (new AttributeValueController)->store(), //lưu dữ liệu thêm mới
    'attributeValues-edit' => (new AttributeValueController)->edit(), //hiển thị form cập nhật theo ID
    'attributeValues-update' => (new AttributeValueController)->update(), //lưu dữ liệu cập nhật theo ID
    'attributeValues-delete' => (new AttributeValueController)->delete(), //Xóa dữ liệu theo ID

    //CRUD variants
    'variants-index' => (new VariantController)->index(), //hiển thị danh sách
    'variants-show' => (new VariantController)->show(), //hiển thị chi tiết ID
    'variants-create' => (new VariantController)->create(), //hiển thị form thêm mới
    'variants-store' => (new VariantController)->store(), //lưu dữ liệu thêm mới
    'variants-edit' => (new VariantController)->edit(), //hiển thị form cập nhật theo ID
    'variants-update' => (new VariantController)->update(), //lưu dữ liệu cập nhật theo ID
    'variants-delete' => (new VariantController)->delete(), //Xóa dữ liệu theo ID
};