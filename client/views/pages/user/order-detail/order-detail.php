<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="./views/layout/user/layout-user.css">
    <link rel="stylesheet" href="./views/layout/user/sidebar-user/sidebar-user.css">
    <link rel="stylesheet" href="./views/layout/user/header-user/header-user.css">
    <link rel="stylesheet" href="./views/pages/user/order-detail/order-detail.css">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include_once("./views/layout/user/sidebar-user/sidebar-user.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once("./views/layout/user/header-user/header-user.php") ?>
            <div class="content">
                <!-- Edit Product Content -->
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="index.php?router=user/orders" class="breadcrumb-link">Đơn hàng của tôi</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Chi tiết đơn hàng</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Chi tiết đơn hàng</h1>
                            <!-- <p class="content-description">Update a product in your inventory.</p> -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="text">
                        <h2>CHÀO MỪNG QUAY TRỞ LẠI, <?= $_SESSION['user']['ho_va_ten'] ?></h2>
                        <p><i>Kiểm tra chi tiết đơn hàng của bạn tại đây</i></p>
                    </div>
                    <img class="icon" src="./assets/images/icon-account-checking.png">
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
                                    <li><span>Mã đơn hàng:</span> <strong>#QSS<?= $order['don_hang_id'] ?></strong></li>
                                    <li><span>Ngày đặt hàng:</span> <strong><?= date("d/m/Y", strtotime($order['ngay_dat'])) ?></strong></li>
                                    <li><span>Tổng tiền:</span> <strong><?= formatCurrency($order['tong_tien'], 'vn') ?></strong></li>
                                    <li><span>Trạng thái đơn hàng: </span> <strong style="padding-left: 5px;"><?= formatOrderStatus($order['trang_thai']) ?></strong></li>
                                    <li><span>Phương thức thanh toán: </span> <strong style="padding-left: 5px;"><?= formatPaymentMethod($order['phuong_thuc_thanh_toan']) ?></strong></li>
                                </ul>
                            </div>

                            <div class="info-column">
                                <h3>Thông tin giao hàng</h3>
                                <ul class="info-list">
                                    <li><span>Họ tên:</span> <strong><?= $order['ho_va_ten'] ?></strong></li>
                                    <li><span>Địa chỉ:</span> <strong><?= $order['dia_chi'] ?></strong></li>
                                    <li><span>Số điện thoại:</span> <strong><?= $order['so_dien_thoai'] ?></strong></li>
                                    <li><span>Email:</span> <strong><?= $order['email'] ?></strong></li>
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

                                <?php foreach ($listOrderDetail as $orderDetail) : ?>
                                    <div class="order-item">
                                        <div class="item-product">
                                            <div class="item-image">
                                                <img src="./assets/uploads/product/<?= $orderDetail['hinh'] ?>" alt="<?= $orderDetail['ten_san_pham'] ?>">
                                            </div>
                                            <div class="item-details">
                                                <h4 class="item-title"><?= $orderDetail['ten_san_pham'] ?></h4>
                                            </div>
                                        </div>
                                        <div class="item-price"><?= formatCurrency($orderDetail['gia'], 'vn') ?></div>
                                        <div class="item-quantity"><?= $orderDetail['so_luong'] ?></div>
                                        <div class="item-total"><?= formatCurrency($orderDetail['tong_tien'], 'vn') ?></div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary">
                            <div class="summary-row total-row">
                                <div class="summary-label">Tổng cộng:</div>
                                <div class="summary-value"><?= formatCurrency($order['tong_tien'], 'vn') ?></div>
                            </div>
                        </div>
                        <a href="index.php?router=user/orders" class="btn-cancel">Quay lại</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="./views/layout/user/layout-user.js"></script>
</body>

</html>