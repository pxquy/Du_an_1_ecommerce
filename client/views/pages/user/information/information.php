<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Cập nhật thông tin</title>
    <link rel="stylesheet" href="./client/views/layout/user/layout-user.css">
    <link rel="stylesheet" href="./client/views/layout/user/sidebar-user/sidebar-user.css">
    <link rel="stylesheet" href="./client/views/layout/user/header-user/header-user.css">
    <link rel="stylesheet" href="./client/views/pages/user/information/information.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include_once("./client/views/layout/user/sidebar-user/sidebar-user.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once("./client/views/layout/user/header-user/header-user.php") ?>
            <div class="content">
                <!-- Edit Product Content -->
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Cập nhật thông tin</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Cập nhật thông tin</h1>
                            <!-- <p class="content-description">Update a product in your inventory.</p> -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="text">
                        <h2>CHÀO MỪNG QUAY TRỞ LẠI, <?= $_SESSION['user']['fullname'] ?></h2>
                        <p><i>Kiểm tra và chỉnh sửa thông tin cá nhân của bạn tại đây</i></p>
                    </div>
                    <img class="icon" src="./assets/images/icon-account-info.png">
                </div>


                <?php
                if (is_array($user)) {
                    extract($user);
                    $hinhPath = "./assets/images/user/" . $avatarUrl;
                    if (!is_file($hinhPath))
                        $hinhPath = "./assets/images/no_image.jpg";
                }
                ?>
                <!-- Product Form -->
                <div class="product-form-container">
                    <form action="<?= BASE_URL . '?action=update_info' ?>" id="edit" method="post" enctype="multipart/form-data" class="product-form">
                        <div class="form-card">
                            <h2 class="form-title">Cập nhật tài khoản</h2>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fullname">Họ và tên <span class="required">*</span></label>
                                    <input type="text" id="fullname" name="fullname" class="form-input"
                                        placeholder="Nhập họ và tên" value="<?= $user['fullname'] ?>" required>
                                    <div class="error-message"></div>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Số điện thoại <span class="required">*</span></label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-input"
                                        placeholder="Nhập số điện thoại" value="<?= $user['phone_number'] ?>" required>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" class="form-input"
                                        placeholder="Nhập email" value="<?= $user['email'] ?>" required>
                                    <div class="error-message"></div>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Giới tính <span class="required">*</span></label>
                                    <select id="gender" name="gender" class="form-select" required>
                                        <option value="" hidden>Chọn giới tính</option>
                                        <option value="1" <?php echo $user['gender'] == 1 ? 'selected' : '' ?>>Nam</option>
                                        <option value="2" <?php echo $user['gender'] == 2 ? 'selected' : '' ?>>Nữ</option>
                                    </select>
                                    <div class="error-message"></div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="avatarUrl">Ảnh đại diện</label>
                                <input id="avatarUrl" name="avatarUrl" type="file" accept="image/*" multiple class="form-input">
                                <div class="error-message"></div>
                            </div>

                            <div class="form-group img-preview">
                                <label>Ảnh hiện tại</label>
                                <img src="<?= $avatarUrl ?>" id="img-preview" width="160">
                            </div>

                            <div class="form-group">
                                <label for="dia_chi">Địa chỉ <span class="required">*</span></label>
                                <textarea id="dia_chi" name="address" class="form-textarea" placeholder="Nhập địa chỉ"
                                    rows="4"><?= $user['address'] ?></textarea>
                                <div class="error-message"></div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="edit-user-btn" class="btn-save">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                    <form action="<?= BASE_URL . '?action=change_password' ?>" id="change-password" method="post" class="product-form">
                        <div class="form-card">
                            <h2 class="form-title">Đổi mật khẩu</h2>

                            <div class="form-group">
                                <label for="old-password">Mật khẩu cũ <span class="required">*</span></label>
                                <input type="text" id="old-password" name="old_password" class="form-input"
                                    placeholder="Mật khẩu cũ" required>
                                <div class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label for="new-password">Mật khẩu mới <span class="required">*</span></label>
                                <input type="text" id="new-password" name="new_password" class="form-input"
                                    placeholder="Mật khẩu mới" required>
                                <div class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label for="confirm-password">Nhập lại mật khẩu <span class="required">*</span></label>
                                <input type="text" id="confirm-password" name="confirm_password" class="form-input"
                                    placeholder="Nhập lại mật khẩu" required>
                                <div class="error-message"></div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="change-password-btn" class="btn-save">Cập nhật mật khẩu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="./client/views/layout/admin/layout-admin.js"></script>

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
            $.validator.addMethod("imageExtension", function(value, element) {
                return this.optional(element) || /\.(jpg|jpeg|png|gif|webp)$/i.test(value);
            }, "Vui lòng chọn tệp ảnh có phần mở rộng là jpg, jpeg, png, gif hoặc webp.");

            $.validator.addMethod("regexEmail", function(value, element) {
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return this.optional(element) || emailRegex.test(value);
            }, "Địa chỉ email không hợp lệ !");

            $.validator.addMethod("regexPhoneNumber", function(value, element) {
                var phoneNumberRegex = /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
                return this.optional(element) || phoneNumberRegex.test(value);
            }, "Số điện thoại không hợp lệ !");

            $.validator.addMethod("regexPassword", function(value, element) {
                var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/;
                return this.optional(element) || passwordRegex.test(value);
            }, "Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm chữ cái viết hoa, viết thường, chữ số và ký tự đặc biệt !");

            $("#edit").validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        regexEmail: true
                    },
                    phone_number: {
                        required: true,
                        number: true,
                        digits: true,
                        regexPhoneNumber: true
                    },
                    hinh: {
                        imageExtension: true
                    },
                    mat_khau: {
                        required: true,
                        regexPassword: true
                    },
                    gender: {
                        required: true,
                    },
                    vai_tro: {
                        required: true,
                    },
                    dia_chi: {
                        required: true,
                    },
                },
                messages: {
                    fullname: {
                        required: "Vui lòng nhập họ và tên !",
                    },
                    email: {
                        required: "Vui lòng nhập email !",
                    },
                    phone_number: {
                        required: "Vui lòng nhập số điện thoại !",
                        number: "Vui lòng nhập số !",
                        digits: "Vui lòng nhập số nguyên dương !"
                    },
                    hinh: {
                        required: "Vui lòng chọn hình !",
                    },
                    mat_khau: {
                        required: "Vui lòng nhập mật khẩu !",
                    },
                    gender: {
                        required: "Vui lòng chọn giới tính !",
                    },
                    vai_tro: {
                        required: "Vui lòng chọn vai trò !",
                    },
                    dia_chi: {
                        required: "Vui lòng nhập địa chỉ !",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest(".form-group").find(".error-message"));
                },
                highlight: function(element) {
                    $(element).closest(".form-group").find("#fullname").addClass("invalid");
                    $(element).closest(".form-group").find("#email").addClass("invalid");
                    $(element).closest(".form-group").find("#phone_number").addClass("invalid");
                    $(element).closest(".form-group").find("#hinh").addClass("invalid");
                    $(element).closest(".form-group").find("#mat_khau").addClass("invalid");
                    $(element).closest(".form-group").find("#gender").addClass("invalid");
                    $(element).closest(".form-group").find("#vai_tro").addClass("invalid");
                    $(element).closest(".form-group").find("#dia_chi").addClass("invalid");
                },
                unhighlight: function(element) {
                    $(element).closest(".form-group").find("#fullname").removeClass("invalid");
                    $(element).closest(".form-group").find("#email").removeClass("invalid");
                    $(element).closest(".form-group").find("#phone_number").removeClass("invalid");
                    $(element).closest(".form-group").find("#hinh").removeClass("invalid");
                    $(element).closest(".form-group").find("#mat_khau").removeClass("invalid");
                    $(element).closest(".form-group").find("#gender").removeClass("invalid");
                    $(element).closest(".form-group").find("#vai_tro").removeClass("invalid");
                    $(element).closest(".form-group").find("#dia_chi").removeClass("invalid");
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
            const ExistingHinhValue = <?= json_encode($user['hinh']) ?>;
            ImgPreviewElement.attr('src', ExistingHinhValue ? `./assets/uploads/user/${ExistingHinhValue}` :
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
                        `./assets/uploads/user/${ExistingHinhValue}` : './assets/images/no_image.jpg'
                    );
                }
            });
        });
    </script>
</body>

</html>