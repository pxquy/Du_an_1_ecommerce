<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/order-complete/order-complete.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Shop Arrowwai" />
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
    <!-- Main Content - Order Complete Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><a href="index.php?router=cart">Giỏ hàng</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><a href="#">Thanh toán</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li>Hoàn tất đơn hàng</li>
                </ul>
            </div>
        </div>

        <!-- Order Complete Section -->
        <section class="order-complete-section">
            <div class="container">
                <!-- Checkout Progress -->
                <div class="checkout-progress">
                    <div class="progress-step completed">
                        <div class="step-number">1</div>
                        <div class="step-label">Giỏ hàng</div>
                    </div>
                    <div class="progress-connector completed"></div>
                    <div class="progress-step completed">
                        <div class="step-number">2</div>
                        <div class="step-label">Thanh toán</div>
                    </div>
                    <div class="progress-connector completed"></div>
                    <div class="progress-step completed <?= empty($order) || empty($listOrderDetail) ? 'active' : '' ?>">
                        <div class="step-number">3</div>
                        <div class="step-label">Hoàn tất</div>
                    </div>
                </div>


                <?php if (empty($orderId) || empty($listOrderDetail)) : ?>
                    <div class="order-error">
                        <div class="error-icon">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <h1 class="error-title">Đặt hàng không thành công!</h1>
                        <p class="error-message">Có lỗi xảy ra vui lòng thử lại hoặc báo cáo quản trị viên !</p>
                        <a href="index.php?router=home" class="error-btn">Về trang chủ</a>
                    </div>
                <?php else : ?>
                    <!-- Order Success Message -->
                    <div class="order-success">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="success-title">Đặt hàng thành công!</h1>
                        <p class="success-message">Cảm ơn bạn đã mua sắm tại Shop Arrowwai. Đơn hàng của bạn đã được xác nhận và đang được xử lý.</p>
                        <div class="order-number">
                            <span>Mã đơn hàng:</span> <strong>#QSS<?= $order['id'] ?></strong>
                        </div>
                        <p class="email-confirmation">Một email xác nhận đã được gửi đến <strong><?= $order['fullName'] ?></strong></p>
                    </div>

                    <!-- Order Details -->
                    <div class="order-details">
                        <div class="order-details-header">
                            <h2>Chi tiết đơn hàng</h2>
                        </div>

                        <div class="order-details-content">
                            <!-- Order Info -->
                            <div class="order-info">
                                <div class="info-column">
                                    <h3>Thông tin đơn hàng</h3>
                                    <ul class="info-list">
                                        <li><span>Mã đơn hàng:</span> <strong>#QSS<?= $order['id'] ?></strong></li>
                                        <li><span>Ngày đặt hàng:</span> <strong><?= date("d/m/Y", strtotime($order['createdAt'])) ?></strong></li>
                                        <li><span>Tổng tiền:</span> <strong><?= formatCurrency($order['total'], 'vn') ?></strong></li>
                                        <li><span>Phương thức thanh toán: </span> <strong style="padding-left: 5px;"><?= formatPaymentMethod($order['paymentMethod']) ?></strong></li>
                                    </ul>
                                </div>

                                <div class="info-column">
                                    <h3>Thông tin giao hàng</h3>
                                    <ul class="info-list">
                                        <li><span>Họ tên:</span> <strong><?= $order['fullName'] ?></strong></li>
                                        <li><span>Địa chỉ:</span> <strong><?= $order['orderAddress'] ?></strong></li>
                                        <li><span>Số điện thoại:</span> <strong><?= $order['phoneNumber'] ?></strong></li>
                                        <li><span>Email:</span> <strong><?= $order['fullName'] ?></strong></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="order-items">
                                <h3>Sản phẩm đã đặt</h3>
                                <div class="order-items-table">
                                    <div class="order-items-header">
                                        <div class="item-product">Sản phẩm</div>
                                        <div class="item-price">Đơn giá</div>
                                        <div class="item-quantity">Số lượng</div>
                                        <div class="item-total">Thành tiền</div>
                                    </div>

                                    <?php foreach ($listOrderDetail as $item) : ?>
                                        <div class="order-item">
                                            <div class="item-product">
                                                <div class="item-image">
                                                    <img src="./assets/uploads/product/<?= $item['thumbnail'] ?>" alt="<?= $item['title'] ?>">
                                                </div>
                                                <div class="item-details">
                                                    <h4 class="item-title"><?= $item['title'] ?></h4>
                                                </div>
                                            </div>
                                            <div class="item-price"><?= formatCurrency($item['price'], 'vn') ?></div>
                                            <div class="item-quantity"><?= $item['quantity'] ?></div>
                                            <div class="item-total"><?= formatCurrency($item['total'], 'vn') ?></div>
                                        </div>
                                    <?php endforeach; ?>


                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="order-summary">
                                <div class="summary-row total-row">
                                    <div class="summary-label">Tổng cộng:</div>
                                    <div class="summary-value"><?= formatCurrency($order['total'], 'vn') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="shipping-information">
                        <div class="shipping-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="shipping-content">
                            <h3>Thông tin vận chuyển</h3>
                            <p>Đơn hàng của bạn sẽ được giao trong vòng 3-5 ngày làm việc. Bạn có thể theo dõi trạng thái đơn hàng trong tài khoản của mình hoặc qua email.</p>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="next-steps">
                        <h3>Bạn có thể</h3>
                        <div class="steps-buttons">
                            <a href="index.php?router=home" class="step-btn">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Tiếp tục mua sắm</span>
                            </a>
                            <a href="#" class="step-btn">
                                <i class="fas fa-truck"></i>
                                <span>Theo dõi đơn hàng</span>
                            </a>
                            <a href="#" class="step-btn">
                                <i class="fas fa-user"></i>
                                <span>Xem tài khoản</span>
                            </a>
                        </div>
                    </div>

                    <!-- Thank You Message -->
                    <div class="thank-you-message">
                        <p>Cảm ơn bạn đã tin tưởng và lựa chọn Shop Arrowwai. Chúng tôi rất mong được phục vụ bạn trong tương lai!</p>
                    </div>
                <?php endif; ?>

                <!-- Customer Support -->
                <div class="customer-support">
                    <div class="support-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="support-content">
                        <h3>Hỗ trợ khách hàng</h3>
                        <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi qua:</p>
                        <div class="support-contacts">
                            <div class="support-contact">
                                <i class="fas fa-phone"></i>
                                <span>1900 1234</span>
                            </div>
                            <div class="support-contact">
                                <i class="fas fa-envelope"></i>
                                <span>cskh@quisupershoes.com</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <?php include_once("./client/views/layout/site/footer-site/footer-site.php") ?>

    <script src="./client/views/layout/site/layout-site.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print Order
            const printOrderBtn = document.querySelector('.print-order-btn');
            if (printOrderBtn) {
                printOrderBtn.addEventListener('click', function() {
                    window.print();
                });
            }
        });
    </script>
</body>

</html>