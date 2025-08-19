<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrowwai - Giày thể thao cao cấp</title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/register/register.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Arrowwai" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />

    <!-- Add Slick Slider CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include_once("./client/views/layout/site/header-site/header-site.php") ?>
    <!-- Main Content - Register Page -->
    <main class="main-content">
        <div class="login-container register-container">
            <div class="login-wrapper register-wrapper">
                <div class="login-header">
                    <h1 class="login-title">Đăng ký tài khoản</h1>
                    <p class="login-subtitle">Tạo tài khoản để trải nghiệm mua sắm tốt hơn</p>
                </div>

                <form action="<?= BASE_URL . '?action=create_user' ?>" class="login-form register-form" method="post" id="registerForm" novalidate enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fullname">Họ và tên</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên" value="<?= $_SESSION['data']['fullname'] ?? '' ?>" required>
                        </div>
                        <div class="error-message" id="fullnameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="Nhập email" value="<?= $_SESSION['data']['email'] ?? '' ?>" required>
                        </div>
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" id="phone" name="phone_number" placeholder="Nhập số điện thoại" value="<?= $_SESSION['data']['phone_number'] ?? '' ?>" required>
                        </div>
                        <div class="error-message" id="phoneError"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" value="<?= $_SESSION['data']['password'] ?? '' ?>" required>
                            <button type="button" class="toggle-password" aria-label="Hiển thị mật khẩu">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="passwordError"></div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Xác nhận mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                            <button type="button" class="toggle-password confirm-password" aria-label="Hiển thị mật khẩu">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="text" id="address" name="address" placeholder="Nhập địa chỉ" value="<?= $_SESSION['data']['address'] ?? '' ?>" required>
                            <button type="button" class="toggle-password confirm-password" aria-label="Hiển thị mật khẩu">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <label for="avatarUrl">Hình ảnh:</label>
                        <div class="input-wrapper">
                            <input type="file" id="avatarUrl" name="avatarUrl" class="imageUrl">
                        </div>
                        <div class=" error-message" id="confirmPasswordError">
                        </div>
                    </div>

                    <!-- Gender Field -->
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="gender-options">
                            <div class="gender-option">
                                <input type="radio" id="male" name="gender" value="1" checked <?= (isset($_SESSION['data']['gender']) && $_SESSION['data']['gender'] == 1) ? 'checked' : '' ?>>
                                <label for="male">Nam</label>
                            </div>
                            <div class="gender-option">
                                <input type="radio" id="female" name="gender" value="2" <?= (isset($_SESSION['data']['gender']) && $_SESSION['data']['gender'] == 2) ? 'checked' : '' ?>>
                                <label for="female">Nữ</label>
                            </div>
                        </div>
                        <div class="error-message" id="genderError"></div>
                    </div>

                    <div class="form-group terms-group">
                        <div class="remember-me">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">Tôi đồng ý với <a href="#" class="terms-link">Điều khoản dịch vụ</a> và <a href="#" class="terms-link">Chính sách bảo mật</a> của Arrowwai</label>
                        </div>
                        <div class="error-message" id="termsError"></div>
                    </div>

                    <button type="submit" class="register-button" name="register-submit">Đăng ký</button>

                    <div class="login-divider">
                        <span>Hoặc đăng ký bằng</span>
                    </div>

                    <div class="social-login">
                        <button type="button" class="social-login-button facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </button>
                        <button type="button" class="social-login-button google">
                            <i class="fab fa-google"></i>
                            <span>Google</span>
                        </button>
                    </div>

                    <div class="register-link">
                        <p>Bạn đã có tài khoản? <a href="index.php?router=login">Đăng nhập ngay</a></p>
                    </div>
                </form>
            </div>

            <div class="login-banner">
                <img src="./assets/images/login-bg.webp" alt="Arrowwai">
                <div class="login-banner-content">
                    <h2>Chào mừng đến với Arrowwai</h2>
                    <p>Thương hiệu giày da nam cao cấp hàng đầu Việt Nam</p>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("./client/views/layout/site/footer-site/footer-site.php") ?>

    <script src="./client/views/layout/site/layout-site.js"></script>

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
        // Toggle password visibility
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('.toggle-password.confirm-password');
        const confirmPasswordInput = document.querySelector('#confirmPassword');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Toggle icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });


        $(document).ready(function() {
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

            $("#registerForm").validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        regexEmail: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        digits: true,
                        regexPhoneNumber: true
                    },
                    password: {
                        required: true,
                        regexPassword: true
                    },
                    confirmPassword: {
                        required: true,
                        regexPassword: true,
                        equalTo: "#password",
                    },
                    terms: {
                        required: true,
                    }
                },
                messages: {
                    fullname: {
                        required: "Vui lòng nhập họ và tên !",
                    },
                    email: {
                        required: "Vui lòng nhập email !",
                    },
                    phone: {
                        required: "Vui lòng nhập số điện thoại !",
                        number: "Vui lòng nhập số !",
                        digits: "Vui lòng nhập số nguyên dương !"
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu !",
                    },
                    confirmPassword: {
                        required: "Vui lòng nhập mật khẩu !",
                        equalTo: "Mật khẩu không trùng khớp !",
                    },
                    terms: {
                        required: "Vui lòng đồng ý với điều khoản !",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest(".form-group").find(".error-message"));
                },
                highlight: function(element) {
                    $(element).closest(".form-group").find("#fullname").addClass("invalid");
                    $(element).closest(".form-group").find("#email").addClass("invalid");
                    $(element).closest(".form-group").find("#phone").addClass("invalid");
                    $(element).closest(".form-group").find("#password").addClass("invalid");
                    $(element).closest(".form-group").find("#confirmPassword").addClass("invalid");
                    $(element).closest(".form-group").find("#terms").addClass("invalid");
                },
                unhighlight: function(element) {
                    $(element).closest(".form-group").find("#fullname").removeClass("invalid");
                    $(element).closest(".form-group").find("#email").removeClass("invalid");
                    $(element).closest(".form-group").find("#phone").removeClass("invalid");
                    $(element).closest(".form-group").find("#password").removeClass("invalid");
                    $(element).closest(".form-group").find("#confirmPassword").removeClass("invalid");
                    $(element).closest(".form-group").find("#terms").removeClass("invalid");
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
        });
    </script>
</body>

</html>