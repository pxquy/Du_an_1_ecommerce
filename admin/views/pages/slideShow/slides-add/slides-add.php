<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới trình chiếu</title>
    <link rel="stylesheet" href="./views/layout/layout-admin.css">
    <link rel="stylesheet" href="./views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="./views/layout/header/header.css">
    <link rel="stylesheet" href="./views/pages/slides/slides-add/slides-add.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <!-- Font Awesome for icons -->
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
                        <a href="index.php?router=admin/slides" class="breadcrumb-link">Quản lý trình chiếu</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Thêm mới trình chiếu</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Thêm mới trình chiếu</h1>
                            <!-- <p class="content-description">Create a new product in your inventory.</p> -->
                        </div>
                    </div>

                </div>

                <!-- Product Form -->
                <div class="product-form-container">
                    <form id="add" method="post" enctype="multipart/form-data" class="product-form">
                        <div class="form-card">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="hinh">Ảnh sản phẩm</label>
                                    <input id="hinh" name="hinh" type="file" accept="image/*" multiple class="form-input">
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="san_pham_id">Sản phẩm <span class="required">*</span></label>
                                    <select id="san_pham_id" name="san_pham_id" class="form-select" required>
                                        <option value="" hidden>Chọn sản phẩm</option>
                                        <?php
                                        foreach ($products as $product) {
                                            extract($product);
                                        ?>
                                            <option value="<?= $san_pham_id ?>"><?= $ten_san_pham ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="trang_thai">Trạng thái <span class="required">*</span></label>
                                    <select id="trang_thai" name="trang_thai" class="form-select" required>
                                        <option value="" hidden>Chọn trạng thái</option>
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Không hoạt động</option>
                                    </select>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <div class="form-group img-preview">
                                <label>Ảnh hiện tại</label>
                                <img src="./assets/images/no_image.jpg" id="img-preview" width="160">
                            </div>

                            <div class="form-actions">
                                <a href="index.php?router=admin/slides" class="btn-cancel">Quay lại</a>
                                <button type="submit" name="add-slides" class="btn-save">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="./views/layout/admin/layout-admin.js"></script>

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

            $("#add").validate({
                rules: {
                    hinh: {
                        required: true,
                        imageExtension: true,
                    },
                    san_pham_id: {
                        required: true,
                    },
                    trang_thai: {
                        required: true,
                    },
                },
                messages: {
                    hinh: {
                        required: "Vui lòng chọn hình !",
                    },
                    san_pham_id: {
                        required: "Vui lòng chọn sản phẩm !",
                    },
                    trang_thai: {
                        required: "Vui lòng chọn trạng thái !",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest(".form-group").find(".error-message"));
                },
                highlight: function(element) {
                    $(element).closest(".form-group").find("#hinh").addClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#san_pham_id")
                        .addClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#trang_thai")
                        .addClass("invalid");
                },
                unhighlight: function(element) {
                    $(element).closest(".form-group").find("#hinh").removeClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#san_pham_id")
                        .removeClass("invalid");
                    $(element)
                        .closest(".form-group")
                        .find("#trang_thai")
                        .removeClass("invalid");
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