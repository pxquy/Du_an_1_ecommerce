<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Giỏ hàng</title>
    <link rel="stylesheet" href="./views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./views/pages/site/cart/cart.css">

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
                    <div class="cart-content" id="cartContent">
                        <!-- Cart Items -->
                        <div class="cart-items">
                            <div class="cart-header">
                                <div class="cart-header-product">Sản phẩm</div>
                                <div class="cart-header-price">Đơn giá</div>
                                <div class="cart-header-quantity">Số lượng</div>
                                <div class="cart-header-subtotal">Thành tiền</div>
                                <div class="cart-header-action"></div>
                            </div>
                            <?php $total = 0; ?>

                            <?php foreach ($cartItems as $item): ?>
                                <?php $subtotal = $item['gia'] * $item['so_luong']; ?>
                                <?php $total += $subtotal; ?>
                                <div class="cart-item">
                                    <div class="cart-item-product">
                                        <div class="cart-item-image">
                                            <a href="product-detail.html">
                                                <img src="./assets/uploads/product/<?= $item['hinh'] ?>" alt="<?= $item['ten_san_pham'] ?>">
                                            </a>
                                        </div>
                                        <div class="cart-item-details">
                                            <h3 class="cart-item-title">
                                                <a href="product-detail.html"><?= $item['ten_san_pham'] ?></a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="cart-item-price"><?= formatCurrency($item['gia'], 'vn') ?></div>
                                    <div class="cart-item-quantity">
                                        <form method="post" class="quantity-selector">
                                            <button type="submit" name="minus-btn" class="quantity-btn minus" data-id="1">-</button>
                                            <input type="hidden" name="product_id" value="<?= $item['san_pham_id'] ?>">
                                            <input type="number" name="quantity" class="quantity-input" value="<?= $item['so_luong'] ?>" min="1">
                                            <button type="submit" name="plus-btn" class="quantity-btn plus" data-id="1">+</button>
                                        </form>
                                    </div>
                                    <div class="cart-item-subtotal"><?= formatCurrency($subtotal, 'vn') ?></div>
                                    <div class="cart-item-action">
                                        <a href="index.php?router=cart&product_id=<?= $item['san_pham_id'] ?>" onclick="return confirm('Xóa sản phẩm này?')" class="remove-item-btn" data-id="1">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Cart Actions -->
                            <div class="cart-actions">
                                <div class="cart-action-left">
                                    <a href="index.php?router=home" class="continue-shopping-btn">
                                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                                    </a>
                                    <a href="index.php?router=cart&clear-cart" onclick="return confirm('Xóa toàn bộ giỏ hàng?')" class="clear-cart-btn" id="clearCartBtn">
                                        <i class="fas fa-trash"></i> Xóa giỏ hàng
                                    </a>
                                </div>
                                <div class="cart-action-right">
                                    <!-- Total -->
                                    <div class="summary-row total-row">
                                        <div class="summary-label">Tổng cộng:</div>
                                        <div class="summary-value" id="cartTotal"><?= formatCurrency($total, 'vn') ?></div>
                                    </div>

                                    <!-- Checkout Button -->
                                    <a href="index.php?router=checkout" class="checkout-btn">
                                        Tiến hành thanh toán <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Empty Cart State (hidden by default) -->
                    <div class="empty-cart" id="emptyCart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h2 class="empty-cart-title">Giỏ hàng của bạn đang trống</h2>
                        <p class="empty-cart-text">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm.</p>
                        <a href="index.php?router=home" class="empty-cart-btn">Tiếp tục mua sắm</a>
                    </div>
                <?php endif; ?>
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