<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Thanh thoán</title>
    <link rel="stylesheet" href="./views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./views/pages/site/checkout/checkout.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Quí Super Shoes" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include_once("./views/layout/site/header-site/header-site.php") ?>
    <!-- Main Content - Checkout Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><a href="index.php?router=cart">Giỏ hàng</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li>Thanh toán</li>
                </ul>
            </div>
        </div>

        <!-- Checkout Section -->
        <section class="checkout-section">
            <div class="container">
                <h1 class="page-title">Thanh toán</h1>

                <!-- Checkout Progress -->
                <div class="checkout-progress">
                    <div class="progress-step completed">
                        <div class="step-number">1</div>
                        <div class="step-label">Giỏ hàng</div>
                    </div>
                    <div class="progress-connector completed"></div>
                    <div class="progress-step active">
                        <div class="step-number">2</div>
                        <div class="step-label">Thanh toán</div>
                    </div>
                    <div class="progress-connector"></div>
                    <div class="progress-step">
                        <div class="step-number">3</div>
                        <div class="step-label">Hoàn tất</div>
                    </div>
                </div>

                <!-- Checkout Content -->
                <form method="post" class="checkout-content">
                    <!-- Checkout Form -->
                    <div class="checkout-form">
                        <div id="checkoutForm">
                            <!-- Customer Information -->
                            <div class="checkout-section-title">
                                <h2>Thông tin khách hàng</h2>
                            </div>
                            <div class="form-section">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fullName">Họ và tên <span class="required">*</span></label>
                                        <input type="text" id="fullName" name="ho_va_ten" class="form-control" value="<?= $_SESSION['user']['ho_va_ten'] ?? '' ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="required">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?= $_SESSION['user']['email'] ?? '' ?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                                        <input type="tel" id="phone" name="so_dien_thoai" class="form-control" value="<?= $_SESSION['user']['so_dien_thoai'] ?? '' ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="checkout-section-title">
                                <h2>Địa chỉ</h2>
                            </div>
                            <div class="form-section">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="billingAddress">Địa chỉ <span class="required">*</span></label>
                                        <input type="text" id="billingAddress" name="dia_chi" class="form-control" value="<?= $_SESSION['user']['dia_chi'] ?? '' ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="checkout-section-title">
                                <h2>Phương thức thanh toán</h2>
                            </div>
                            <div class="form-section">
                                <div class="payment-methods">
                                    <div class="payment-method">
                                        <label class="radio-label">
                                            <input type="radio" name="phuong_thuc_thanh_toan" value="1" checked>
                                            <span class="radio-custom"></span>
                                            <div class="payment-method-info">
                                                <div class="payment-method-name">Thanh toán khi nhận hàng (COD)</div>
                                                <div class="payment-method-desc">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                            </div>
                                            <div class="payment-method-icon">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="payment-method">
                                        <label class="radio-label">
                                            <input type="radio" name="phuong_thuc_thanh_toan" value="2">
                                            <span class="radio-custom"></span>
                                            <div class="payment-method-info">
                                                <div class="payment-method-name">Chuyển khoản ngân hàng</div>
                                                <div class="payment-method-desc">Chuyển khoản trước khi giao hàng</div>
                                            </div>
                                            <div class="payment-method-icon">
                                                <i class="fas fa-university"></i>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="summary-header">
                            <h2>Đơn hàng của bạn</h2>
                        </div>
                        <div class="summary-content">
                            <div class="summary-products">
                                <?php $total = 0; ?>
                                <?php foreach ($cartItems as $item): ?>
                                    <?php $subtotal = $item['gia'] * $item['so_luong']; ?>
                                    <?php $total += $subtotal; ?>
                                    <div class="summary-product-item">
                                        <div class="product-image">
                                            <img src="./assets/uploads/product/<?= $item['hinh'] ?>" alt="<?= $item['ten_san_pham'] ?>">
                                        </div>
                                        <div class="product-details">
                                            <h3 class="product-title"><?= $item['ten_san_pham'] ?></h3>
                                            <div class="product-quantity-price"><?= $item['so_luong'] ?> x <?= formatCurrency($item['gia'], 'vn') ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="summary-totals">
                                <div class="summary-row total-row">
                                    <div class="summary-label">Tổng cộng:</div>
                                    <input type="number" name="tong_tien" hidden value="<?= $total ?>">
                                    <div class="summary-value" id="orderTotal"><?= formatCurrency($total, 'vn') ?></div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" name="check-out-btn" class="place-order-btn">
                                Đặt hàng <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include_once("./views/layout/site/footer-site/footer-site.php") ?>

    <script src="./views/layout/site/layout-site.js"></script>

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
</body>

</html>