<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trình chiếu</title>
    <link rel="stylesheet" href="./views/layout/layout-admin.css">
    <link rel="stylesheet" href="./views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="./views/layout/header/header.css">
    <link rel="stylesheet" href="./views/pages/banner/banner-edit/banner-edit.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

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
                <!-- Edit Product Content -->
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="index.php?router=admin/slides" class="breadcrumb-link">Quản lý banner</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Cập nhật banner</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Cập nhật banner</h1>
                        </div>
                    </div>
                </div>


                <?php
                if (is_array($slides)) {
                    extract($slides);
                    $hinhPath = "./assets/images/slides/" . $hinh;
                    if (!is_file($hinhPath))
                        $hinhPath = "./assets/images/no_image.jpg";
                }
                ?>
                <!-- Product Form -->
                <div class="product-form-container">
                    <form id="edit" method="post" enctype="multipart/form-data" class="product-form">
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
                                            if ($product['san_pham_id'] == $product['san_pham_id'])
                                                $s = 'selected';
                                            else
                                                $s = '';
                                            echo '<option value="' . $product['san_pham_id'] . '" ' . $s . '>' . $product['ten_san_pham'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="trang_thai">Trạng thái <span class="required">*</span></label>
                                    <select id="trang_thai" name="trang_thai" class="form-select" required>
                                        <option value="" hidden>Chọn trạng thái</option>
                                        <option value="1" <?php echo $slides['trang_thai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="2" <?php echo $slides['trang_thai'] == 2 ? 'selected' : '' ?>>Không hoạt động</option>
                                    </select>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <div class="form-group img-preview">
                                <label>Ảnh hiện tại</label>
                                <img src="<?= $hinhPath ?>" id="img-preview" width="160">
                            </div>

                            <div class="form-actions">
                                <a href="index.php?router=admin/slides" class="btn-cancel">Quay lại</a>
                                <button type="submit" name="edit-slides" class="btn-save">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="./views/layout/layout-admin.js"></script>



    <script>
        $(document).ready(function() {
            $.validator.addMethod("imageExtension", function(value, element) {
                return this.optional(element) || /\.(jpg|jpeg|png|gif|webp)$/i.test(value);
            }, "Vui lòng chọn tệp ảnh có phần mở rộng là jpg, jpeg, png, gif hoặc webp.");

            $("#edit").validate({
                rules: {
                    hinh: {
                        imageExtension: true
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
                    $(element).closest(".form-group").find("#san_pham_id").addClass("invalid");
                    $(element).closest(".form-group").find("#trang_thai").addClass("invalid");
                },
                unhighlight: function(element) {
                    $(element).closest(".form-group").find("#hinh").removeClass("invalid");
                    $(element).closest(".form-group").find("#san_pham_id").removeClass("invalid");
                    $(element).closest(".form-group").find("#trang_thai").removeClass("invalid");
                },
                submitHandler: function(form) {
                    if (this.checkForm()) {
                        form.submit();
                    } else {
                        $(form).find(":input.error:first").focus();
                    }
                    return false;
                }
            });

            const ImgPreviewElement = $('#img-preview');
            const InputFileElement = $('#hinh');
            const ExistingHinhValue = <?= json_encode($slides['hinh']) ?>;
            ImgPreviewElement.attr('src', ExistingHinhValue ? `./assets/uploads/slides/${ExistingHinhValue}` :
                './assets/images/no_image.jpg');

            InputFileElement.change(function() {
                const file = this.files[0];
                if (file) {
                    const extension = file.name.split('.').pop().toLowerCase();
                    if (['jpg', 'jpeg', 'png', 'gif', "webp"].includes(extension)) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            ImgPreviewElement.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        ImgPreviewElement.attr('src', './assets/images/no_image.jpg');
                    }
                } else {
                    ImgPreviewElement.attr('src', ExistingHinhValue ?
                        `./assets/uploads/slides/${ExistingHinhValue}` : './assets/images/no_image.jpg'
                    );
                }
            });
        });
    </script>
</body>

</html>