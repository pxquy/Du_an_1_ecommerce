<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới sản phẩm</title>
    <link rel="stylesheet" href="./views/layout/layout-admin.css">
    <link rel="stylesheet" href="./views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="./views/layout/header/header.css">
    <link rel="stylesheet" href="./views/pages/product/product-add/product-add.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include_once("./views/layout/sidebar/sidebar.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once("./views/layout/header/header.php") ?>
            <div class="content">
                <!-- Add Product Content -->
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="index.php?router=admin/product" class="breadcrumb-link">Quản lý sản phẩm</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Thêm mới sản phẩm</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Thêm mới sản phẩm</h1>
                        </div>
                    </div>

                </div>

                <!-- Product Form -->
                <div class="product-form-container">
                    <form id="addProduct" method="post" enctype="multipart/form-data" class="product-form">
                        <div class="form-card">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="ten_san_pham">Tên sản phẩm <span class="required">*</span></label>
                                    <input type="text" id="ten_san_pham" name="ten_san_pham" class="form-input"
                                        placeholder="Nhập tên sản phẩm" required>
                                    <div class="error-message"></div>
                                </div>
                                <div class="form-group">
                                    <label for="ma_san_pham">Mã sản phẩm <span class="required">*</span></label>
                                    <input type="text" id="ma_san_pham" name="ma_san_pham" class="form-input"
                                        placeholder="Nhập mã sản phẩm" required>
                                    <div class="error-message"></div>
                                </div>
                                <div class="form-group">
                                    <label for="danh_muc_id">Danh mục <span class="required">*</span></label>
                                    <select id="danh_muc_id" name="danh_muc_id" class="form-select" required>
                                        <option value="" hidden>Chọn danh mục</option>
                                        <?php
                                        foreach ($categories as $category) {
                                            extract($category);
                                        ?>
                                            <option value="<?= $danh_muc_id ?>"><?= $ten_danh_muc ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="gia">Giá gốc <span class="required">*</span></label>
                                    <input type="number" id="gia" name="gia" class="form-input" placeholder="0.00"
                                        step="0.01" min="0" required>
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="ngay_nhap">Ngày nhập <span class="required">*</span></label>
                                    <input type="date" name="ngay_nhap" id="ngay_nhap" class="form-input" required>
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="trang_thai">Trạng thái <span class="required">*</span></label>
                                    <select id="trang_thai" name="trang_thai" class="form-select" required>
                                        <option value="in-stock">Còn hàng</option>
                                        <option value="low-stock">Tồn kho</option>
                                        <option value="out-of-stock">Hết hàng</option>
                                    </select>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hinh">Ảnh sản phẩm</label>
                                <input id="hinh" name="hinh" type="file" accept="image/*" multiple class="form-input">
                                <div class="error-message"></div>
                            </div>

                            <div class="form-group img-preview">
                                <label>Ảnh hiện tại</label>
                                <img src="./assets/images/no_image.jpg" id="img-preview" width="160">
                            </div>

                            <div class="form-group">
                                <label for="mo_ta">Mô tả sản phẩm <span class="required">*</span></label>
                                <textarea id="mo_ta" name="mo_ta" class="form-textarea" placeholder="Nhập mô tả"
                                    rows="4"></textarea>
                                <div class="error-message"></div>
                            </div>

                            <div class="form-actions">
                                <a href="index.php?router=admin/product" class="btn-cancel">Quay lại</a>
                                <button type="submit" name="add-product" class="btn-save">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="./views/layout/admin/layout-admin.js"></script>

    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<script>toastr.error("' . $_SESSION['error_message'] . '")</script>';
        unset($_SESSION['error_message']);
    }
    ?>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<script>toastr.success("' . $_SESSION['success_message'] . '")</script>';
        unset($_SESSION['success_message']);
    }
    ?>

    <script>
        $(document).ready(function() {
            $.validator.addMethod(
                "imageExtension",
                function(value, element) {
                    return (
                        this.optional(element) || /\.(jpg|jpeg|png|gif|webp)$/i.test(value)
                    );
                },
                "Vui lòng chọn tệp ảnh có phần mở rộng là jpg, jpeg, png, gif hoặc webp."
            );

            $("#addProduct").validate({
                rules: {
                    ten_san_pham: {
                        required: true,
                    },
                    ma_san_pham: {
                        required: true,
                    },
                    gia: {
                        required: true,
                        number: true,
                        digits: true,
                    },
                    hinh: {
                        required: true,
                        imageExtension: true,
                    },
                    ngay_nhap: {
                        required: true,
                    },
                    danh_muc_id: {
                        required: true,
                    },
                    mo_ta: {
                        required: true,
                    },
                },
                messages: {
                    ten_san_pham: {
                        required: "Vui lòng nhập tên sản phẩm !",
                    },
                    ma_san_pham: {
                        required: "Vui lòng nhập mã sản phẩm !",
                    },
                    gia: {
                        required: "Vui lòng nhập giá !",
                        number: "Vui lòng nhập vào là số!",
                        digits: "Vui lòng nhập số nguyên dương!",
                    },
                    hinh: {
                        required: "Vui lòng chọn hình !",
                    },
                    ngay_nhap: {
                        required: "Vui lòng chọn ngày nhập !",
                    },
                    danh_muc_id: {
                        required: "Vui lòng chọn danh mục !",
                    },
                    mo_ta: {
                        required: "Vui lòng nhập mô tả !",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest(".form-group").find(".error-message"));
                },
                highlight: function(element) {
                    $(element)
                        .closest(".form-group")
                        .find("#ten_san_pham")
                        .addClass("invalid");
                    $(element).closest(".form-group").find("#ma_san_pham").addClass("invalid");
                    $(element).closest(".form-group").find("#gia").addClass("invalid");
                    $(element).closest(".form-group").find("#hinh").addClass("invalid");
                    $(element).closest(".form-group").find("#ngay_nhap").addClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#danh_muc_id")
                        .addClass("invalid");
                    $(element).closest(".form-group").find("#mo_ta").addClass("invalid");
                },
                unhighlight: function(element) {
                    $(element)
                        .closest(".form-group")
                        .find("#ten_san_pham")
                        .removeClass("invalid");
                    $(element).closest(".form-group").find("#ma_san_pham").removeClass("invalid");
                    $(element).closest(".form-group").find("#gia").removeClass("invalid");
                    $(element).closest(".form-group").find("#hinh").removeClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#ngay_nhap")
                        .removeClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#danh_muc_id")
                        .removeClass("invalid");
                    $(element).closest(".form-group").find("#mo_ta").removeClass("invalid");
                },
                submitHandler: function(form) {
                    if (this.checkForm()) {
                        form.submit();
                    } else {
                        $(form).find(":input.error:first").focus();
                    }
                    return false;
                },
            });

            const ImgPreviewElement = $("#img-preview");
            const InputFileElement = $("#hinh");

            InputFileElement.change(function() {
                const file = this.files[0];
                if (file) {
                    const extension = file.name.split(".").pop().toLowerCase();
                    if (["jpg", "jpeg", "png", "gif", "webp"].includes(extension)) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            ImgPreviewElement.attr("src", e.target.result);
                        };

                        reader.readAsDataURL(file);
                    } else {
                        // Nếu người dùng chọn tệp không phải là ảnh, reset input và hiển thị ảnh mặc định
                        ImgPreviewElement.attr("src", "./assets/images/no_image.jpg");
                    }
                } else {
                    // Nếu không có tệp được chọn, hiển thị ảnh mặc định
                    ImgPreviewElement.attr("src", "./assets/images/no_image.jpg");
                }
            });
        });
    </script>
</body>

</html>