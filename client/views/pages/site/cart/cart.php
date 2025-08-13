<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/cart/cart.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Quí Super Shoes" />
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
    <!-- Main Content - Cart Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li>Giỏ hàng</li>
                </ul>
            </div>
        </div>

        <!-- Cart Section -->
        <section class="cart-section">
            <div class="container">
                <h1 class="page-title">Giỏ hàng của bạn</h1>

                <?php if (isset($_SESSION['user']) && !empty($cartItems)) : ?>
                    <!-- Cart Content -->
                    <form method="POST" action="<?= BASE_URL ?>?action=create_order" class="cart-content" id="cartContent">
                        <!-- Cart Items -->
                        <div class="cart-items">
                            <div class="cart-header">
                                <div><input type="checkbox" id="checkAll"></div>
                                <div>#</div>
                                <div class="cart-header-product">Sản phẩm</div>
                                <div class="cart-header-price">Đơn giá</div>
                                <div class="cart-header-quantity">Số lượng</div>
                                <div class="cart-header-subtotal">Thành tiền</div>
                                <div class="cart-header-action"></div>
                            </div>

                            <?php $total = 0; ?>
                            <?php foreach ($cartItems as $index => $item): ?>
                                <?php $subtotal = $item['price'] * $item['quantity']; ?>
                                <?php $total += $subtotal; ?>

                                <div class="cart-item">
                                    <!-- Checkbox chọn sản phẩm -->
                                    <div>
                                        <input type="checkbox" name="selected[]" value="<?= $item['cartProductId'] ?>">
                                        <input type="hidden" name="product_id[]" value="<?= $item['cartId'] ?>">
                                    </div>

                                    <!-- STT -->
                                    <div><?= $index + 1 ?></div>

                                    <!-- Thông tin sản phẩm -->
                                    <div class="cart-item-product">
                                        <div class="cart-item-image">
                                            <a href="<?= BASE_URL ?>?action=product_detail&id=<?= $item['cartId'] ?>">
                                                <img src="./assets/uploads/product/<?= htmlspecialchars($item['thumbnail']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                            </a>
                                        </div>
                                        <div class="cart-item-details">
                                            <h3 class="cart-item-title">
                                                <a href="<?= BASE_URL ?>?action=product_detail&id=<?= $item['cartId'] ?>">
                                                    <?= htmlspecialchars($item['title']) ?>
                                                </a>
                                            </h3>
                                            <small><?= htmlspecialchars($item['variantAttributes'] ?: '-') ?></small>
                                        </div>
                                    </div>

                                    <!-- Giá -->
                                    <div class="cart-item-price"><?= formatCurrency($item['price'], 'vn') ?></div>

                                    <!-- Số lượng -->
                                    <div class="cart-item-quantity">
                                        <div class="quantity-selector">
                                            <span><?= $item['quantity'] ?></span>
                                        </div>
                                    </div>

                                    <!-- Thành tiền -->
                                    <div class="cart-item-subtotal"><?= formatCurrency($subtotal, 'vn') ?></div>

                                    <!-- Xóa -->
                                    <div class="cart-item-action">
                                        <a href="<?= BASE_URL ?>?action=delete_cart&cartProductId=<?= $item['cartProductId'] ?>&cartId=<?= $item['cartId'] ?>"
                                            onclick="return confirm('Xóa sản phẩm này?')" class="remove-item-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Cart Actions -->
                            <div class="cart-actions">
                                <div class="cart-action-left">
                                    <a href="<?= BASE_URL ?>" class="continue-shopping-btn">
                                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                                    </a>
                                    <a href="<?= BASE_URL ?>?action=clear_cart"
                                        onclick="return confirm('Xóa toàn bộ giỏ hàng?')" class="clear-cart-btn">
                                        <i class="fas fa-trash"></i> Xóa giỏ hàng
                                    </a>
                                </div>

                                <div class="cart-action-right">
                                    <!-- Tổng cộng -->
                                    <div class="summary-row total-row">
                                        <div class="summary-label">Tổng cộng:</div>
                                        <div class="summary-value" id="cartTotal"><?= formatCurrency($total, 'vn') ?></div>
                                    </div>

                                    <!-- Checkout -->
                                    <button type="submit" name="checkout" class="checkout-btn">
                                        Tiến hành thanh toán <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>


                <?php else : ?>
                    <!-- Empty Cart State (hidden by default) -->
                    <div class="empty-cart" id="emptyCart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h2 class="empty-cart-title">Giỏ hàng của bạn đang trống</h2>
                        <p class="empty-cart-text">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm.</p>
                        <a href=<?= BASE_URL ?> class="empty-cart-btn">Tiếp tục mua sắm</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include_once("./client/views/layout/site/footer-site/footer-site.php") ?>

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

    <script src="./client/views/layout/site/layout-site.js"></script>

    <script>
        // Chọn/bỏ chọn tất cả
        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => cb.checked = this.checked);
        });
    </script>

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